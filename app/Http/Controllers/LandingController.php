<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\JadwalKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function home()
    {
        $userId = auth()->id();

        // Ambil semua absensi milik user yang sedang login, urut dari terbaru
        $absensis = Absensi::with('user')
            ->where('user_id', $userId)
            ->orderByDesc('tanggal')
            ->limit(4)
            ->get();

        $absenTotal = [
            'hadir' => Absensi::where('user_id', $userId)
                ->whereIn('status', ['hadir', 'terlambat'])
                ->count(),
            'izin'  => Absensi::where('user_id', $userId)->where('status', 'izin')->count(),
            'sakit' => Absensi::where('user_id', $userId)->where('status', 'sakit')->count(),
            'alpha' => Absensi::where('user_id', $userId)->where('status', 'alpha')->count(),
        ];
        $headerText = 'Beranda';
        return view('landing.home', compact('headerText', 'absenTotal', 'absensis'));
    }

    public function izin()
    {
        $headerText = 'Izin';
        return view('landing.xhadir', compact('headerText'));
    }


    public function history()
    {
        $headerText = 'Riwayat';
        return view('landing.history', compact('headerText'));
    }

    public function jadwal()
    {
        $jadwal = JadwalKerja::with('dinas')->get();
        $headerText = 'Jadwal';
        return view('landing.jadwal', compact('headerText', 'jadwal'));
    }

    public function profile()
    {
        $user = auth()->user();
        $honorer = $user->honorer; // relasi di model User

        $headerText = 'Profil';
        return view('landing.profile', compact('headerText', 'user', 'honorer'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();
        $honorer = $user->honorer;

        $request->validate([

            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'no_hp' => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update user table
        $user->username = $request->username;
        $user->name = $request->name;
        $user->tanggal_lahir = $request->tanggal_lahir;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        // Update honorer table
        $honorer->no_hp = $request->no_hp;
        $honorer->jenis_kelamin = $request->jenis_kelamin;
        $honorer->alamat = $request->alamat;
        $honorer->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }



    public function storeIzin(Request $request)
    {
        $request->validate([
            'status' => 'required|in:izin,sakit',
            'bukti_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = auth()->user();
        $tanggal = now()->toDateString();

        // Cek hari libur
        $hariNama = now()->translatedFormat('l');
        $dinas = $user->dinas; // pastikan relasi 'dinas' ada di model User

        $jadwalHariIni = JadwalKerja::where('dinas_id', $dinas->id)
            ->where('hari', $hariNama)
            ->first();

        $isInternalHoliday = !$jadwalHariIni || $jadwalHariIni->is_libur;

        $holidays = cache()->remember('daftar_hari_libur', 86400, function () {
            return Http::get('https://api-harilibur.vercel.app/api')->json();
        });

        $isNationalHoliday = collect($holidays)->contains('holiday_date', $tanggal);
        $isHoliday = $isInternalHoliday || $isNationalHoliday;

        if ($isHoliday) {
            return back()->with('error', 'Hari ini adalah hari libur. Pengajuan izin/sakit tidak diperlukan.');
        }

        // Cek apakah sudah absen hari ini
        $sudahAbsen = Absensi::where('user_id', $user->id)
            ->where('tanggal', $tanggal)
            ->exists();

        if ($sudahAbsen) {
            return back()->with('error', 'Anda sudah mengisi absensi hari ini.');
        }

        // Upload file bukti
        $file = $request->file('bukti_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('surat'), $filename);

        // Simpan absensi
        Absensi::create([
            'user_id' => $user->id,
            'jadwal_kerja_id' => $jadwalHariIni->id ?? 1, // fallback ke ID 1 jika tidak ditemukan
            'tanggal' => $tanggal,
            'status' => $request->status,
            'bukti_file' => 'surat/' . $filename,
        ]);

        return redirect('/history')->with('success', 'Absensi izin/sakit berhasil dicatat.');
    }




    public function scan() {}
}
