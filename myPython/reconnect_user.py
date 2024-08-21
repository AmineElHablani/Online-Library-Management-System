import cv2
import base64
import numpy as np
import sys
import face_recognition


def read_img(image):
    # Ensure input image is in RGB format
    image = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)
    (h, w) = image.shape[:2]
    width = 500
    ratio = width / float(w)
    height = int(h * ratio)
    return cv2.resize(image, (width, height))

# Check if the script received the correct arguments
if len(sys.argv) != 3:
    print("Usage: python script.py base64_image_data user_face_image")
    sys.exit(1)

# Get base64 image data
file = sys.argv[1]

f = open(file)
base64_image = f.read()
f.close()


# Get user face image file name
user_face = sys.argv[2]

# Convert base64 image data to numpy array
try:
    image_bytes = base64.b64decode(base64_image)
    nparr = np.frombuffer(image_bytes, np.uint8)

    # Decode numpy array to image
    image = cv2.imdecode(nparr, cv2.IMREAD_COLOR)

    # Process the image
    image_connecting = read_img(image)
    
    # Read user face image
    user_face_image = cv2.imread(user_face)
    
    # Ensure user face image is in RGB format
    user_face_image = cv2.cvtColor(user_face_image, cv2.COLOR_BGR2RGB)
    
    # Encode real user face
    real_user_encoding = face_recognition.face_encodings(user_face_image)[0]
    
    # Encode captured image
    if (len(face_recognition.face_encodings(image_connecting)) == 0):
        print("False")
        sys.exit(1)
    image_connecting_encoding = face_recognition.face_encodings(image_connecting)[0]

    
    
    # Compare faces
    result = face_recognition.compare_faces([real_user_encoding], image_connecting_encoding)
    
    if result[0] == True:
        print("True")
    else:
        print("False")

except Exception as e:
    print("Error:", e)
    sys.exit(1)
