import sys
import qrcode
from cryptography.hazmat.primitives.ciphers import Cipher, algorithms, modes
from cryptography.hazmat.backends import default_backend
import os
import base64

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

# Generate a random 16-byte key for AES encryption
key = os.urandom(16)

# Function to encrypt data using AES
def encrypt_data(data, key):
    # Convert the data to bytes if it's a string
    if isinstance(data, str):
        data = data.encode('utf-8')

    # Generate a random IV
    iv = os.urandom(16)

    # Initialize the AES cipher in CFB mode
    cipher = Cipher(algorithms.AES(key), modes.CFB(iv), backend=default_backend())
    encryptor = cipher.encryptor()

    # Encrypt the data
    encrypted_data = encryptor.update(data) + encryptor.finalize()

    # Return the IV + encrypted data, encoded as base64
    return base64.b64encode(iv + encrypted_data).decode('utf-8')


# Encrypt the QR data
encrypted_qr_data = encrypt_data(qr_data, key)

# Generate the QR code with encrypted data
qr = qrcode.QRCode(
    version=1,
    error_correction=qrcode.constants.ERROR_CORRECT_L,
    box_size=10,
    border=4,
)
qr.add_data(encrypted_qr_data)
qr.make(fit=True)

# Define the output directory
output_dir = "./qrcodes/"
os.makedirs(output_dir, exist_ok=True)

# Save the QR code as an image file
qr_code_path = os.path.join(output_dir, f"student_{student_id}.png")
img = qr.make_image(fill='black', back_color='white')
img.save(qr_code_path)

print(f"Encrypted QR code generated and saved at {qr_code_path}")
