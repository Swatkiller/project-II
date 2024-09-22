import cv2
import requests
from pyzbar.pyzbar import decode
import base64
from cryptography.hazmat.primitives.ciphers import Cipher, algorithms, modes
from cryptography.hazmat.backends import default_backend

# AES key (must be the same as the one used in generate_qr.py)
AES_KEY = b'your_16_byte_key'  # Replace with the actual key used during encryption

def decrypt_data(encrypted_data, key):
    try:
        # Base64 decode the encrypted data if it's in string form
        encrypted_data = base64.b64decode(encrypted_data)

        # Extract the IV (first 16 bytes) and the encrypted message
        iv = encrypted_data[:16]
        encrypted_message = encrypted_data[16:]

        # Initialize the AES cipher with the given key and IV in CFB mode
        cipher = Cipher(algorithms.AES(key), modes.CFB(iv), backend=default_backend())
        decryptor = cipher.decryptor()

        # Decrypt the encrypted message
        decrypted_data = decryptor.update(encrypted_message) + decryptor.finalize()

        # Return the decrypted message
        return decrypted_data.decode('utf-8')  # Now decode the decrypted binary as utf-8 string
    except Exception as e:
        print(f"Decryption error: {e}")
        raise e


def scan_qr_code():
    # Open the webcam
    cap = cv2.VideoCapture(0)
    camera_active = True  # Flag to check if the camera should keep running

    while camera_active:
        # Capture frame-by-frame
        ret, frame = cap.read()
        if not ret:
            print("Failed to grab frame")
            break
        
        # Decode the QR code
        qr_codes = decode(frame)
        
        for qr_code in qr_codes:
            # Extract QR code data (encrypted)
            encrypted_qr_data = qr_code.data.decode('utf-8')
            print(f"Encrypted QR Code Data: {encrypted_qr_data}")
            
            # Decrypt the QR data
            try:
                decrypted_qr_data = decrypt_data(encrypted_qr_data, AES_KEY)
                print(f"Decrypted QR Code Data: {decrypted_qr_data}")
                
                # Send decrypted data to PHP backend for attendance marking
                response = send_data_to_backend(decrypted_qr_data)
                if response:
                    print("Attendance marked successfully!")
                    camera_active = False  # Turn off the camera once attendance is marked
                else:
                    print("Failed to mark attendance.")
            except Exception as e:
                print(f"Decryption failed: {e}")
            
            # Display the frame with a rectangle around the QR code
            cv2.rectangle(frame, (qr_code.rect.left, qr_code.rect.top), 
                          (qr_code.rect.left + qr_code.rect.width, qr_code.rect.top + qr_code.rect.height), 
                          (0, 255, 0), 2)
        
        # Display the resulting frame
        cv2.imshow('QR Code Scanner', frame)
        
        # Break the loop on 'q' key press (in case manual exit is needed)
        if cv2.waitKey(1) & 0xFF == ord('q'):
            break
    
    # When everything is done, release the capture
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
