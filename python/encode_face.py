import sys
import os
import json
import face_recognition
import numpy as np

def encode_faces_from_folder(folder_path):
    encodings = []

    if not os.path.exists(folder_path):
        print(json.dumps([]))
        return

    for filename in os.listdir(folder_path):
        filepath = os.path.join(folder_path, filename)

        try:
            image = face_recognition.load_image_file(filepath)
            face_locations = face_recognition.face_locations(image)

            if not face_locations:
                continue

            encoding = face_recognition.face_encodings(image, known_face_locations=face_locations)
            if encoding:
                encodings.append(encoding[0])
        except Exception:
            continue

    if encodings:
        average_encoding = np.mean(encodings, axis=0)
        print(json.dumps(average_encoding.tolist()))
    else:
        print(json.dumps([]))

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(json.dumps([]))
    else:
        encode_faces_from_folder(sys.argv[1])
