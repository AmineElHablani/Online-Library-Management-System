import cv2
import base64
import numpy as np
import sys
import face_recognition


def read_img(image):
    image = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)
    (h, w) = image.shape[:2]
    width = 500
    ratio = width / float(w)
    height = int(h * ratio)
    return cv2.resize(image, (width, height))

# Check if the script received the correct arguments
if len(sys.argv) != 2:
    print("Usage: python script.py base64_image_data")
    sys.exit(1)

# Get image data from PHP



file = sys.argv[1]
f = open(file)
base64_image = f.read()
f.close()



# Convert base64 image data to numpy array
try:
    #return jsonify({'success': False})
    image_bytes = base64.b64decode(base64_image)
    nparr = np.frombuffer(image_bytes, np.uint8)

    # Decode numpy array to image
    image = cv2.imdecode(nparr, cv2.IMREAD_COLOR)

    # Process the image
    image = read_img(image)
    if len(face_recognition.face_encodings(image)) > 0:
        print("True")
    else:
        print("False")


    # Now, you can use the processed image for further processing
except Exception as e:
    print("Error:", e)
    sys.exit(1)
