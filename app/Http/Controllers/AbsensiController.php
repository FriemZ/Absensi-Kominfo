<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Honorer;
use App\Models\JadwalKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;


class AbsensiController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        if (!$user || !$user->dinas) {
            return abort(403, 'Dinas tidak ditemukan');
        }

        $dinas = $user->dinas;
        $hariNama = now()->translatedFormat('l');
        $jadwalHariIni = JadwalKerja::where('dinas_id', $dinas->id)
            ->where('hari', $hariNama)
            ->first();

        $isInternalHoliday = !$jadwalHariIni || $jadwalHariIni->is_libur;

        $holidays = cache()->remember('daftar_hari_libur', 86400, function () {
            return Http::get('https://api-harilibur.vercel.app/api')->json();
        });

        $today = now()->toDateString();
        $isNationalHoliday = collect($holidays)->contains('holiday_date', $today);
        $isHoliday = $isInternalHoliday || $isNationalHoliday;

        // Default values
        $isScanAllowed = false;
        $absenStatus = null;
        $infoMessage = null;

        if (!$isHoliday && $jadwalHariIni) {
            $now = now();
            $jamMasuk = Carbon::parse($jadwalHariIni->jam_masuk);
            $jamPulang = Carbon::parse($jadwalHariIni->jam_pulang);

            $absensi = Absensi::where('user_id', $user->id)->whereDate('tanggal', today())->first();

            // Cek apakah user sudah absen dan statusnya izin atau sakit
            if ($absensi && in_array($absensi->status, ['izin', 'sakit'])) {
                $isScanAllowed = false;
                $infoMessage = 'Hari ini kamu sedang ' . $absensi->status . ', tidak perlu absen.';
            } else {
                if (!$absensi && $now->gte($jamMasuk)) {
                    // Belum absen masuk dan sudah waktunya masuk
                    $isScanAllowed = true;
                    $absenStatus = 'masuk';
                } elseif ($absensi && !$absensi->waktu_pulang) {
                    if ($now->lt($jamPulang)) {
                        // Sudah absen masuk tapi belum waktunya pulang
                        $isScanAllowed = false;
                        $infoMessage = 'Kamu sudah absen masuk hari ini';
                    } else {
                        // Sudah absen masuk, sekarang waktunya pulang
                        $isScanAllowed = true;
                        $absenStatus = 'pulang';
                    }
                } elseif ($absensi && $absensi->waktu_pulang) {
                    // Sudah absen masuk & pulang
                    $isScanAllowed = false;
                    $infoMessage = 'Kamu sudah absen penuh untuk hari ini';
                }
            }
        }

        $headerText = 'Scan Absensi';

        return view('landing.scan', compact(
            'headerText',
            'dinas',
            'isHoliday',
            'isScanAllowed',
            'absenStatus',
            'infoMessage'
        ));
    }


    public function check(Request $request)
    {
        $user = auth()->user();
        $imageData = $request->input('image');

        if (!$imageData) {
            return response()->json(['error' => 'Data gambar tidak ditemukan'], 400);
        }

        $honorer = $user->honorer;
        if (!$honorer || empty($honorer->face_encoding)) {
            return response()->json(['error' => 'Data wajah tidak ditemukan di sistem'], 404);
        }

        $savedEncoding = json_decode($honorer->face_encoding, true);
        if (!$savedEncoding) {
            return response()->json(['error' => 'Face encoding di database tidak valid'], 422);
        }

        // Proses face recognition via Python
        $python = env('PYTHON_PATH', 'python');
        $script = base_path('python/app.py');

        $process = proc_open("{$python} {$script}", [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']], $pipes);
        if (!is_resource($process)) {
            return response()->json(['error' => 'Gagal menjalankan proses Python'], 500);
        }

        fwrite($pipes[0], $imageData);
        fclose($pipes[0]);

        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $errorOutput = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        $return_value = proc_close($process);

        if ($return_value !== 0) {
            \Log::error("Error Python: " . $errorOutput);
            return response()->json(['error' => 'Gagal proses encoding wajah'], 500);
        }

        $result = json_decode($output, true);
        if (!$result || isset($result['error'])) {
            return response()->json(['error' => $result['error'] ?? 'Output tidak valid'], 422);
        }

        $newEncoding = $result['encoding'];
        if (count($savedEncoding) !== count($newEncoding)) {
            return response()->json(['error' => 'Data encoding tidak konsisten'], 422);
        }

        $isMatch = $this->compareFaces($savedEncoding, $newEncoding, 0.4);
        if (!$isMatch) {
            return response()->json(['absen' => false, 'message' => 'Wajah tidak cocok'], 200);
        }

        // ✅ Cek jadwal kerja
        $jadwal = JadwalKerja::where('dinas_id', $user->dinas_id)
            ->where('hari', now()->translatedFormat('l'))
            ->first();

        if (!$jadwal) {
            return response()->json(['error' => 'Jadwal kerja tidak ditemukan untuk dinas Anda hari ini.'], 404);
        }

        $waktuSekarang = now();
        $jamMasuk = Carbon::parse($jadwal->jam_masuk);
        $jamPulang = Carbon::parse($jadwal->jam_pulang);
        $toleransiMenit = $jadwal->dinas->toleransi_keterlambatan ?? 15;
        $batasMasuk = $jamMasuk->copy()->addMinutes($toleransiMenit);

        $absensi = Absensi::where('user_id', $user->id)->whereDate('tanggal', today())->first();

        // === ABSEN MASUK ===
        if (!$absensi) {
            if ($waktuSekarang->lt($jamMasuk)) {
                return response()->json(['error' => 'Belum waktunya absen masuk'], 403);
            }

            $status = $waktuSekarang->gt($batasMasuk) ? 'terlambat' : 'hadir';
            $menitTerlambat = $status === 'terlambat' ? $jamMasuk->diffInMinutes($waktuSekarang) : 0;

            Absensi::create([
                'user_id' => $user->id,
                'jadwal_kerja_id' => $jadwal->id,
                'tanggal' => today(),
                'waktu_masuk' => $waktuSekarang->toTimeString(),
                'status' => $status,
                'menit_terlambat' => $menitTerlambat,
            ]);

            return response()->json(['absen' => true, 'message' => 'Absen masuk berhasil']);
        }

        // === ABSEN PULANG ===
        if (!$absensi->waktu_pulang) {
            if ($waktuSekarang->lt($jamPulang)) {
                return response()->json(['error' => 'Belum waktunya absen pulang'], 403);
            }

            $absensi->update([
                'waktu_pulang' => $waktuSekarang->toTimeString()
            ]);

            return response()->json(['absen' => true, 'message' => 'Absen pulang berhasil']);
        }

        return response()->json(['error' => 'Anda sudah absen masuk dan pulang hari ini'], 409);
    }



    // Helper function untuk bandingkan encoding wajah
    private function compareFaces(array $face1, array $face2, float $tolerance = 0.4): bool
    {
        $distance = 0;
        $count = count($face1);

        for ($i = 0; $i < $count; $i++) {
            $distance += pow($face1[$i] - $face2[$i], 2);
        }
        $distance = sqrt($distance);

        \Log::info("Face distance: " . $distance);
        return $distance <= $tolerance;
    }



    public function dispensasi()
    {
        $honorers = Honorer::with('user')->get();
        return view('dashboard.dispen', compact('honorers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'honorer_id' => 'required|exists:honorers,id',
            'bukti_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $tanggal = now()->toDateString();
        $honorer = Honorer::with('user')->findOrFail($request->honorer_id);

        // Cek jika sudah absen
        $sudahAbsen = Absensi::where('user_id', $honorer->user_id)
            ->where('tanggal', $tanggal)
            ->exists();

        if ($sudahAbsen) {
            return back()->with('error', 'Honorer sudah mengisi absensi hari ini.');
        }

        // Upload file bukti
        $file = $request->file('bukti_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('surat'), $filename);

        // Simpan ke tabel absensi
        Absensi::create([
            'user_id' => $honorer->user_id,
            'tanggal' => $tanggal,
            'jadwal_kerja_id' => 1, // fallback jadwal
            'waktu_masuk' => '-',
            'waktu_pulang' => '-',
            'status' => 'hadir',
            'bukti_file' => 'surat/' . $filename,
        ]);

        return redirect()->back()->with([
            'alert_title' => 'Absensi Dispensasi',
            'alert_message' => 'Honorer berhasil hadir!',
        ]);
    }
}
