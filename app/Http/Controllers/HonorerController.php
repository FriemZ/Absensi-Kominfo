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

        // Simpan foto-foto
        $photoPaths = [];
        foreach ($request->file('foto_wajah') as $index => $photo) {
            $filename = "foto" . ($index + 1) . "_{$user->id}_" . \Illuminate\Support\Str::random(8) . "." . $photo->getClientOriginalExtension();
            $photo->move($fullPath, $filename);
            $photoPaths[] = url("{$folderName}/{$filename}");
            \Log::info("Foto disimpan: " . end($photoPaths));
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



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
