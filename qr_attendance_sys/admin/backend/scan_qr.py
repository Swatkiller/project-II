import cv2
import requests
from pyzbar.pyzbar import decode
import time

def scan_qr_code():
    # Open the webcam
    cap = cv2.VideoCapture(0)
    
    while True:
        # Capture frame-by-frame
        ret, frame = cap.read()
        if not ret:
            print("Failed to grab frame")
            break
        
        # Decode the QR code
        qr_codes = decode(frame)
        
        for qr_code in qr_codes:
            # Extract QR code data
            qr_data = qr_code.data.decode('utf-8')
            print(f"QR Code Data: {qr_data}")
            
            # Send QR data to PHP backend for attendance marking
            response = send_data_to_backend(qr_data)
            if response:
                print("Attendance marked successfully!")
            else:
                print("Failed to mark attendance.")
            
            # Display the frame
            cv2.rectangle(frame, (qr_code.rect.left, qr_code.rect.top), 
                          (qr_code.rect.left + qr_code.rect.width, qr_code.rect.top + qr_code.rect.height), (0, 255, 0), 2)
        
        # Display the resulting frame
        cv2.imshow('QR Code Scanner', frame)
        
        # Break the loop on 'q' key press
        if cv2.waitKey(1) & 0xFF == ord('q'):
            break
    
    # When everything done, release the capture
    cap.release()
    cv2.destroyAllWindows()

def send_data_to_backend(qr_data):
    try:
        # Assuming the backend PHP script is hosted locally
        url = "http://localhost/qr_attendance_sys/admin/backend/mark_attendance.php"
        data = {'qr_code_data': qr_data}
        
        # Send a POST request to the PHP backend
        response = requests.post(url, json=data)
        
        if response.status_code == 200:
            return response.json().get('success', False)
        else:
            print(f"Error: {response.status_code}, {response.text}")
            return False
    except Exception as e:
        print(f"Exception occurred: {e}")
        return False

if __name__ == "__main__":
    scan_qr_code()
