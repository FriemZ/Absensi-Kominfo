<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dinas;
use App\Models\Honorer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function user()
    {
        $users = User::all();
        $dinas = Dinas::all();
        $headerText = 'User';
        return view('dashboard.user', compact(
            'headerText',
            'users',
            'dinas'
        ));
    }

    public function admin()
    {
        $users = User::all();
        $dinas = Dinas::all();
        $headerText = 'Admin';
        return view('dashboard.admin', compact(
            'headerText',
            'users',
            'dinas'
        ));
    }




    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|email|unique:users',
            'role' => 'required|string',
            'dinas_id' => 'nullable|exists:dinas,id',
        ]);

        // Ambil tanggal lahir, format: YYYY-MM-DD
        $tgl = $validated['tanggal_lahir']; // contoh: 2003-01-15

        // Buat password dari tanggal lahir, ambil tanggal + bulan + tahun
        // Format password default: ddmmyyyy jadi dd + mm + yyyy atau sesuai kebutuhan
        $date = \Carbon\Carbon::parse($tgl);
        $defaultPassword = $date->format('dmy'); // 15 Jan 2003 => "150103" (bisa disesuaikan)

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'email' => $validated['email'],
            'password' => Hash::make($defaultPassword),
            'role' => $validated['role'],
            'dinas_id' => $validated['dinas_id'] ?? null,
        ]);

        // Jika role honorer, buat data di tabel honorers (dengan data default atau kosong)
        if ($validated['role'] === 'honorer') {
            Honorer::create([
                'user_id' => $user->id, // ✅ benar, ambil dari objek User yang baru dibuat
                'jenis_kelamin' => 'Laki-laki', // atau default lain, bisa juga dari input tambahan
                'no_hp' => '-',
                'alamat' => '-',
                'foto_wajah' => '-',
                'face_encoding' => '-',
            ]);
        }

        return redirect()->back()->with([
            'alert_title' => 'User Baru',
            'alert_message' => 'User berhasil ditambahkan!',
        ]); // Password default: $defaultPassword
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'tanggal_lahir' => 'required|date',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            // 'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|string',
            'dinas_id' => 'nullable|exists:dinas,id',
        ]);

        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->tanggal_lahir = $validated['tanggal_lahir'];
        $user->email = $validated['email'];

        // // Jika password diisi, pakai itu
        // if (!empty($validated['password'])) {
        //     $user->password = Hash::make($validated['password']);
        // } else {
        //     // Jika tidak isi password, pakai default dari tanggal lahir (optional)
        //     // Biasanya update password otomatis ini jarang dilakukan kecuali mau reset password,
        //     // jadi bisa diabaikan kalau ingin password tidak berubah.
        // }

        $user->role = $validated['role'];
        $user->dinas_id = $validated['dinas_id'] ?? null;
        $user->save();



        // Jika role sekarang honorer dan belum punya data honorer, buat baru
        if ($user->role === 'honorer' && !$user->honorer) {
            Honorer::create([
                'user_id' => $user->id,
                'jenis_kelamin' => 'Laki-laki',
                'no_hp' => '-',
                'alamat' => '-',
                'foto_wajah' => '-',
                'face_encoding' => '-',
            ]);
        }

        // Opsional: Jika role diubah dari honorer ke selain honorer, hapus data honorer
        if ($user->role !== 'honorer' && $user->honorer) {
            $user->honorer()->delete();
        }


        return redirect()->back()->with([
            'alert_title' => 'Update User',
            'alert_message' => 'User berhasil diperbarui!',
        ]);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $userName = $user->name;
        $user->delete();
        return redirect()->back()->with([
            'alert_title' => $user->name,
            'alert_message' => 'User berhasil dihapus!',
        ]);
    }
}
