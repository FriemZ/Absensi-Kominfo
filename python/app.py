import sys
import json
import base64
import numpy as np
# import face_recognition or library kamu pakai
import face_recognition

def main():
    try:
        base64_data = sys.stdin.read()
        if not base64_data:
            print(json.dumps({"error": "No input data"}))
            sys.exit(1)

        # Buang header jika ada (misal "data:image/jpeg;base64,...")
        if "," in base64_data:
            base64_data = base64_data.split(",")[1]

        # Decode base64 ke bytes gambar
        img_bytes = base64.b64decode(base64_data)

        # Simpan sementara atau langsung proses dari bytes
        # Jika face_recognition butuh numpy array, kamu bisa pakai PIL:
        from PIL import Image
        import io

        image = Image.open(io.BytesIO(img_bytes))
        image_np = np.array(image)

        # Ambil face encoding
        encodings = face_recognition.face_encodings(image_np)
        if not encodings or len(encodings) != 1:
            print(json.dumps({"error": "Deteksi wajah tidak valid, pastikan hanya satu wajah"}))
            sys.exit(1)

        encoding = encodings[0].tolist()

        print(json.dumps({"encoding": encoding}))
    except Exception as e:
        print(json.dumps({"error": str(e)}))
        sys.exit(1)

if __name__ == "__main__":
    main()
