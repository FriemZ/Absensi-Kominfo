<?php

namespace App\Http\Controllers;

use App\Models\JadwalKerja;
use Illuminate\Http\Request;

class JadwalKerjaController extends Controller
{
    public function index()
    {
        $jadwal = JadwalKerja::with('dinas')->get();
        return view('dashboard.setting.jadwal', compact('jadwal'));
    }

    public function update(Request $request)
    {
        foreach ($request->id as $key => $id) {
            $jamMasuk = $request->jam_masuk[$key];
            $jamPulang = $request->jam_pulang[$key];

            $jadwal = JadwalKerja::find($id);

            // Tentukan is_libur berdasarkan input jam masuk & pulang
            $isLibur = (is_null($jamMasuk) && is_null($jamPulang)) ? true : false;

            $jadwal->update([
                'jam_masuk' => $jamMasuk,
                'jam_pulang' => $jamPulang,
                'is_libur' => $isLibur,
            ]);
        }

        return redirect()->back()->with([
            'alert_title' => 'Berhasil!',
            'alert_message' => 'Jadwal berhasil diperbarui.'
        ]);
    }

    public function resetSingle($id)
    {
        $jadwal = JadwalKerja::findOrFail($id);
        $jadwal->update([
            'jam_masuk' => null,
            'jam_pulang' => null,
            'is_libur' => true,
        ]);

        return redirect()->route('jadwal.index')->with([
            'alert_title' => 'Berhasil!',
            'alert_message' => 'Jadwal hari ' . $jadwal->hari . ' berhasil direset ke libur.',
        ]);
    }
}
