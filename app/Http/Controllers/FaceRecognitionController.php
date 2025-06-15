<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use File;
use Python;

class FaceRecognitionController extends Controller
{
    // Fungsi untuk menyimpan foto dan encoding wajah
    public function storeFaceEncoding(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'foto_wajah' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Simpan gambar wajah ke storage
        $imagePath = $request->file('foto_wajah')->store('public/foto_wajah');

        // Ambil path gambar yang telah disimpan
        $path = storage_path('app/' . $imagePath);

        // Ambil face encoding dari gambar
        $faceEncoding = $this->getFaceEncodingFromImage($path);

        // Simpan data ke database
        $user = User::create([
            'nama' => $request->input('nama'),
            'foto_wajah' => $imagePath,  // simpan path
            'face_encoding' => json_encode($faceEncoding),  // simpan hasil encoding dalam format JSON
        ]);

        return response()->json(['message' => 'Face data saved successfully']);
    }

    // Fungsi untuk mendapatkan encoding wajah dari gambar
    public function getFaceEncodingFromImage($imagePath)
    {
        // Anda dapat menggunakan pustaka face_recognition atau dlib di Python untuk mendapatkan encoding wajah.
        // Berikut adalah contoh menggunakan pustaka Python di Laravel
        // Untuk implementasi ini, Anda memerlukan pustaka Python yang berjalan pada server.

        // Panggil Python script untuk mendapatkan encoding wajah
        $faceEncoding = Python::run('face_recognition_script.py', [$imagePath]);

        return json_decode($faceEncoding);
    }

    // Fungsi untuk mencocokkan wajah
    public function checkFace(Request $request)
    {
        // Ambil foto wajah dan encoding wajah baru dari permintaan
        $photo = $request->file('foto_wajah');
        $photoPath = $photo->store('public/foto_wajah');
        $photoEncoding = $this->getFaceEncodingFromImage(storage_path('app/' . $photoPath));

        // Ambil semua pengguna yang terdaftar
        $users = User::all();
        foreach ($users as $user) {
            // Decode face encoding dari database
            $dbEncoding = json_decode($user->face_encoding);

            // Bandingkan encoding wajah baru dengan encoding yang ada di database
            if ($this->compareEncodings($photoEncoding, $dbEncoding)) {
                return response()->json(['status' => 'success', 'user' => $user]);
            }
        }

        return response()->json(['status' => 'not recognized']);
    }

    // Fungsi untuk membandingkan encoding wajah
    public function compareEncodings($encoding1, $encoding2)
    {
        // Fungsi perbandingan encoding wajah menggunakan cosine similarity
        $distance = $this->cosineSimilarity($encoding1, $encoding2);
        return $distance < 0.6; // Threshold untuk menentukan kecocokan
    }

    // Fungsi untuk menghitung cosine similarity
    public function cosineSimilarity($a, $b)
    {
        $dotProduct = array_sum(array_map(function ($x, $y) {
            return $x * $y;
        }, $a, $b));

        $normA = sqrt(array_sum(array_map(function ($x) {
            return $x * $x;
        }, $a)));

        $normB = sqrt(array_sum(array_map(function ($x) {
            return $x * $x;
        }, $b)));

        return 1 - ($dotProduct / ($normA * $normB));
    }
}
