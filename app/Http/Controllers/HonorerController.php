<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Dinas;
use App\Models\Honorer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Illuminate\Support\Facades\Log;


class HonorerController extends Controller
{

    public function honorer()
    {
        $user = auth()->user();

        if ($user->role == 'super_admin') {
            $honorers = Honorer::with('user')->get();
            $dinas = Dinas::all(); // Semua dinas untuk super admin
        } elseif ($user->role == 'admin') {
            $honorers = Honorer::with('user')
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('dinas_id', $user->dinas_id);
                })->get();
            $dinas = Dinas::where('id', $user->dinas_id)->get(); // Hanya dinas sendiri
        } else {
            return redirect()->back();
        }

        $headerText = 'Honorer';
        return view('dashboard.honorer', compact('honorers', 'headerText', 'dinas'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'email' => 'required|email|unique:users',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'dinas_id' => 'nullable|exists:dinas,id',
            'foto_wajah' => 'required|array|min:3',
            'foto_wajah.*' => 'image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Set default password dari tanggal lahir atau string tetap
        $defaultPassword = 'defaultpassword123';
        if (!empty($validated['tanggal_lahir'])) {
            $date = \Carbon\Carbon::parse($validated['tanggal_lahir']);
            $defaultPassword = $date->format('dmy'); // contoh: 150103
        }

        // Buat user baru
        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'email' => $validated['email'],
            'password' => \Hash::make($defaultPassword),
            'role' => 'honorer',
            'dinas_id' => $validated['dinas_id'] ?? null,
        ]);

        // Folder unik untuk simpan foto
        $randomStr = \Illuminate\Support\Str::random(8);
        $folderName = "face/{$user->id}_{$randomStr}";
        $fullPath = public_path($folderName);

        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
            \Log::info("Folder $fullPath berhasil dibuat.");
        }

        // Simpan foto-foto dengan nama tetap
        $photoPaths = [];
        foreach ($request->file('foto_wajah') as $index => $photo) {
            $filename = "foto" . ($index + 1) . "_{$user->id}.jpg"; // tanpa random
            $photo->move($fullPath, $filename); // file lama akan diganti jika upload ulang
            $photoPaths[] = '/' . $folderName . '/' . $filename; // hasil: /face/123/foto1_123.jpg

            \Log::info("Foto disimpan: {$folderName}/{$filename}");
        }


        \Log::info("Isi folder $fullPath: " . json_encode(scandir($fullPath)));
        $faceEncodingJson = null;

        try {
            $pythonCmd = env('PYTHON_PATH', 'python'); // bisa diset di .env
            $scriptPath = base_path('python/encode_face.py');
            $command = escapeshellcmd("{$pythonCmd} {$scriptPath} {$fullPath}");

            $output = shell_exec($command);
            \Log::info('📤 Output Python (shell_exec): ' . $output);

            if (!empty($output)) {
                $decoded = json_decode($output, true);
                if (is_array($decoded) && count($decoded) === 128) {
                    $faceEncodingJson = json_encode($decoded);
                } else {
                    \Log::warning("Encoding wajah tidak valid atau tidak lengkap: " . $output);
                    $faceEncodingJson = null;
                }
            } else {
                \Log::warning('⚠️ Output dari Python kosong');
            }
        } catch (\Exception $e) {
            \Log::error('❌ Gagal menjalankan Python script: ' . $e->getMessage());
        }

        // Simpan data honorer dengan encoding wajah
        Honorer::create([
            'user_id' => $user->id,
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'foto_wajah' => json_encode($photoPaths),
            'face_encoding' => $faceEncodingJson ?? '-',
        ]);

        return redirect()->back()->with([
            'alert_title' => 'Honorer Baru',
            'alert_message' => 'Honorer berhasil ditambahkan!',
        ]);
    }

    public function update(Request $request, $id)
    {
        $honorer = Honorer::findOrFail($id);
        $user = $honorer->user;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'foto_wajah.*' => 'image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Update data user
        $user->update([
            'name' => $validated['name'],
            'username' => $validated['username'],
        ]);

        // Update data honorer
        $honorer->update([
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
        ]);

        // Cek apakah ada file baru
        if ($request->hasFile('foto_wajah')) {
            // Ambil folder dari foto lama
            $oldPhotos = json_decode($honorer->foto_wajah, true);
            $folderPath = null;
            $folderName = null;

            if ($oldPhotos && count($oldPhotos) > 0) {
                $first = $oldPhotos[0];
                $segments = explode('/', parse_url($first, PHP_URL_PATH));
                if (count($segments) >= 3) {
                    $folderName = "{$segments[1]}/{$segments[2]}"; // face/xxx
                    $folderPath = public_path($folderName);
                }
            }

            // Jika folder lama tidak ada, buat baru
            if (!$folderPath || !file_exists($folderPath)) {
                $folderName = "face/{$user->id}";
                $folderPath = public_path($folderName);
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0755, true);
                }
            }

            // Simpan foto-foto dengan nama tetap
            $photoPaths = [];
            foreach ($request->file('foto_wajah') as $index => $photo) {
                $filename = "foto" . ($index + 1) . "_{$user->id}.jpg"; // nama tetap
                $photo->move($folderPath, $filename);
                $photoPaths[] = '/' . $folderName . '/' . $filename; // hasil: /face/123/foto1_123.jpg
            }

            // Proses encoding wajah ulang
            $faceEncodingJson = null;
            try {
                $pythonCmd = env('PYTHON_PATH', 'python');
                $scriptPath = base_path('python/encode_face.py');
                $command = escapeshellcmd("{$pythonCmd} {$scriptPath} {$folderPath}");
                $output = shell_exec($command);

                $decoded = json_decode($output, true);
                if (is_array($decoded) && count($decoded) === 128) {
                    $faceEncodingJson = json_encode($decoded);
                }
            } catch (\Exception $e) {
                \Log::error("Gagal encoding wajah: " . $e->getMessage());
            }

            $honorer->update([
                'foto_wajah' => json_encode($photoPaths),
                'face_encoding' => $faceEncodingJson ?? '-',
            ]);
        }

        return redirect()->back()->with([
            'alert_title' => 'Update Berhasil',
            'alert_message' => 'Data honorer berhasil diperbarui.',
        ]);
    }


    public function destroy($id)
    {
        $honorer = Honorer::with('user')->findOrFail($id); // Ambil satu honorer berdasarkan ID

        // Simpan nama user sebelum dihapus
        $userName = $honorer->user->name ?? 'User';

        $honorer->delete();

        return redirect()->back()->with([
            'alert_title' => $userName,
            'alert_message' => 'User berhasil dihapus!',
        ]);
    }
}
