<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\JadwalKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function home()
    {
        $user = auth()->user();
        $userId = $user->id;

        // Ambil 4 absensi terakhir user
        $absensis = Absensi::with('user')
            ->where('user_id', $userId)
            ->orderByDesc('tanggal')
            ->limit(4)
            ->get();

        // Rekap total kehadiran
        $absenTotal = [
            'hadir' => Absensi::where('user_id', $userId)->whereIn('status', ['hadir', 'terlambat'])->count(),
            'izin' => Absensi::where('user_id', $userId)->where('status', 'izin')->count(),
            'sakit' => Absensi::where('user_id', $userId)->where('status', 'sakit')->count(),
            'alpha' => Absensi::where('user_id', $userId)->where('status', 'alpha')->count(),
        ];

        // Ambil absensi hari ini
        $hariIni = now()->translatedFormat('l');
        $tanggal = now()->toDateString();
        $absenHariIni = Absensi::where('user_id', $userId)
            ->where('tanggal', $tanggal)
            ->first();

        // Ambil jadwal kerja dan dinas
        $jadwal = JadwalKerja::where('dinas_id', $user->dinas_id ?? 1)
            ->where('hari', $hariIni)
            ->first();

        $jamMasuk = optional($jadwal)->jam_masuk ? Carbon::parse($jadwal->jam_masuk) : now();
        $jamPulang = optional($jadwal)->jam_pulang ? Carbon::parse($jadwal->jam_pulang) : now()->addHours(8);
        $maksKeterlambatan = optional($user->dinas)->maks_keterlambatan ?? 20;

        $sekarang = now();

        // Tentukan mode absen
        if (!$absenHariIni) {
            $modeAbsen = 'masuk';
        } elseif ($absenHariIni && !$absenHariIni->waktu_pulang) {
            $modeAbsen = 'pulang';
        } else {
            $modeAbsen = null;
        }

        $menitTerlambat = 0;
        $tampilkanTerlambat = false;

        $statusDikecualikan = ['alpha', 'izin', 'sakit'];
        if ($absenHariIni && in_array($absenHariIni->status, $statusDikecualikan)) {
            // Tidak hitung keterlambatan
        } else {
            $batasKeterlambatanMasuk = $jamMasuk->copy()->addMinutes($maksKeterlambatan);
            $batasKeterlambatanPulang = $jamPulang->copy()->addMinutes($maksKeterlambatan);

            if ($modeAbsen === 'masuk' && $sekarang->gt($batasKeterlambatanMasuk)) {
                $menitTerlambat = $sekarang->diffInMinutes($batasKeterlambatanMasuk);
                $tampilkanTerlambat = true;
            } elseif ($modeAbsen === 'pulang' && $sekarang->gt($batasKeterlambatanPulang)) {
                $menitTerlambat = $sekarang->diffInMinutes($batasKeterlambatanPulang);
                $tampilkanTerlambat = true;
            }
        }

        // Rekap keterlambatan bulan ini
        $bulanIni = Carbon::now()->format('m');
        $bulanSekarang = Carbon::now()->translatedFormat('F Y');
        $totalTerlambat = 0;
        $totalMenitTerlambat = 0;

        foreach (Absensi::where('user_id', $userId)->get() as $absen) {
            if ($absen->status === 'terlambat' && Carbon::parse($absen->tanggal)->format('m') === $bulanIni) {
                $totalTerlambat++;
                $totalMenitTerlambat += $absen->menit_terlambat ?? 0;
            }
        }

        $jam = floor($totalMenitTerlambat / 60);
        $menit = $totalMenitTerlambat % 60;

        $headerText = 'Beranda';

        return view('landing.home', compact(
            'headerText',
            'absenTotal',
            'absensis',
            'absenHariIni',
            'modeAbsen',
            'menitTerlambat',
            'tampilkanTerlambat',
            'jamMasuk',
            'sekarang',
            'totalTerlambat',
            'totalMenitTerlambat',
            'jam',
            'menit',
            'bulanSekarang'
        ));
    }

    public function izin()
    {
        $headerText = 'Izin';
        return view('landing.xhadir', compact('headerText'));
    }


    public function history()
    {
        $userId = auth()->id();

        $absensiHariIni = Absensi::where('user_id', auth()->id())
            ->whereDate('tanggal', now())
            ->first();


        $absensis = Absensi::where('user_id', auth()->id())
            ->orderByDesc('tanggal')
            ->get()
            ->map(function ($absen) {
                $absen->waktu_masuk_formatted = $absen->waktu_masuk ? \Carbon\Carbon::parse($absen->waktu_masuk)->format('H:i') : '-';
                $absen->waktu_pulang_formatted = $absen->waktu_pulang ? \Carbon\Carbon::parse($absen->waktu_pulang)->format('H:i') : '-';
                return $absen;
            });
        $headerText = 'Riwayat';
        return view('landing.history', compact('headerText', 'absensis', 'absensiHariIni'));
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
            'password' => 'nullable|string|min:6',
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
}
