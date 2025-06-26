<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Absensi::with(['user.honorer']);

        // Filter bulan dan tahun
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereMonth('tanggal', $request->bulan)
                ->whereYear('tanggal', $request->tahun);
        }

        if ($request->filled('status')) {
            if ($request->status == 'hadir') {
                // status hadir mencakup 'hadir' dan 'terlambat'
                $query->whereIn('status', ['hadir', 'terlambat']);
            } else {
                $query->where('status', $request->status);
            }
        }

        $absensis = $query->orderBy('tanggal', 'desc')->get();
        $headerText = 'Rekapitulasi Absensi';
        $totalTerlambat = $absensis->sum('menit_terlambat');
        return view('dashboard.rekap', compact('absensis', 'headerText', 'totalTerlambat'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
