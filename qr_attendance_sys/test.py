# import os

# AES_KEY = os.urandom(16)  # Generates a random 16-byte key
# IV = os.urandom(16)       # Generates a random 16-byte IV

# print (AES_KEY)
# print(IV)

from Crypto.Cipher import AES
from Crypto.Util.Padding import pad, unpad
import base64

AES_KEY = b'\x97\xc9I\xd3\xfe\xbe2\x00\x97-TU\x8e\xfd/2'
IV = b'\x9eCyW\xd2\xb0\x9eO)\x0e\xa5\xf5\xdc\xf4\xde"'

def encrypt_data(data):
    cipher = AES.new(AES_KEY, AES.MODE_CBC, IV)
    padded_data = pad(data.encode(), AES.block_size)
    encrypted_data = cipher.encrypt(padded_data)
    return base64.b64encode(encrypted_data).decode('utf-8')

def decrypt_data(encrypted_data):
    try:
        encrypted_data_bytes = base64.b64decode(encrypted_data)
        cipher = AES.new(AES_KEY, AES.MODE_CBC, IV)
        decrypted = cipher.decrypt(encrypted_data_bytes)
        decrypted = unpad(decrypted, AES.block_size)
        return decrypted.decode('utf-8')
    except Exception as e:
        print(f"Decryption error: {e}")
        return None

# Test the process
original_data = "ID: 12345\nGrade: A\nSection: 10"
encrypted = encrypt_data(original_data)
print(f"Encrypted data: {encrypted}")

decrypted = decrypt_data(encrypted)
print(f"Decrypted data: {decrypted}")
