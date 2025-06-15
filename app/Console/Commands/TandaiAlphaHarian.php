<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Honorer;
use App\Models\Absensi;
use App\Models\JadwalKerja;
use Carbon\Carbon;

class TandaiAlphaHarian extends Command
{
    protected $signature = 'absensi:alpha-harian';
    protected $description = 'Menandai honorer yang tidak absen sebagai alpha setiap hari';

    public function handle()
    {
        $today = now()->toDateString();

        // Ambil daftar libur nasional dari cache/API
        $holidays = Cache::remember('daftar_hari_libur', 86400, function () {
            $response = Http::get('https://api-harilibur.vercel.app/api');
            return $response->successful() ? $response->json() : [];
        });

        $isNationalHoliday = collect($holidays)->contains('holiday_date', $today);

        Honorer::with('user.dinas', 'user.dinas.jadwalKerja')->get()->each(function ($honorer) use ($today, $isNationalHoliday) {
            $user = $honorer->user;
            $dinas = $user->dinas;

            if (!$dinas) {
                return;
            }

            // Cek apakah sudah absen
            $sudahAbsen = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', $today)
                ->exists();

            if ($sudahAbsen) return;

            // Cek jadwal hari ini
            $hariIni = now()->translatedFormat('l'); // Contoh: "Senin"
            $jadwal = JadwalKerja::where('dinas_id', $dinas->id)
                ->where('hari', $hariIni)
                ->first();

            // Jika tidak ada jadwal, atau jadwal bertanda libur → internal libur
            $isInternalHoliday = !$jadwal || $jadwal->is_libur;

            // Jika salah satu libur, tidak dicatat alpha
            if ($isInternalHoliday || $isNationalHoliday) {
                $this->info("Libur untuk {$user->name}, tidak dicatat alpha.");
                return;
            }

            // Cek apakah sudah lewat jam pulang + toleransi
            $jamPulang = Carbon::parse($jadwal->jam_pulang);
            $toleransi = $dinas->toleransi_keterlambatan ?? 15;
            $batasAlpha = $jamPulang->copy()->addMinutes($toleransi);

            if (now()->gt($batasAlpha)) {
                Absensi::create([
                    'user_id' => $user->id,
                    'jadwal_kerja_id' => $jadwal->id,
                    'tanggal' => $today,
                    'status' => 'alpha',
                    'waktu_masuk' => null,
                    'waktu_pulang' => null,
                    'menit_terlambat' => 0,
                ]);
                $this->info("Alpha dicatat untuk {$user->name}");
            }
        });

        return Command::SUCCESS;
    }
}
