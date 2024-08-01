import sys
import qrcode

# Ensure the script is called with the correct number of arguments
if len(sys.argv) != 4:
    print("Usage: generate_qr.py <id> <grade> <section>")
    sys.exit(1)

# Get the arguments
student_id = sys.argv[1]
grade = sys.argv[2]
section = sys.argv[3]

# Create the QR code data
qr_data = f"ID: {student_id}\nGrade: {grade}\nSection: {section}"

# Generate the QR code
qr = qrcode.QRCode(
    version=1,
    error_correction=qrcode.constants.ERROR_CORRECT_L,
    box_size=10,
    border=4,
)
qr.add_data(qr_data)
qr.make(fit=True)

# Ensure the output directory exists
import os
output_dir = "./qrcodes/"
os.makedirs(output_dir, exist_ok=True)

# Save the QR code as an image file
qr_code_path = os.path.join(output_dir, f"student_{student_id}.png")
img = qr.make_image(fill='black', back_color='white')
img.save(qr_code_path)

print(f"QR code generated and saved at {qr_code_path}")
