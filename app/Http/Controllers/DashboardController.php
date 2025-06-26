<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use App\Models\Honorer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Data absensi per hari selama 30 hari terakhir
        $start = now()->subDays(30)->startOfDay();
        $end = now()->endOfDay();

        $absensiData = Absensi::selectRaw("DATE(tanggal) as tgl, 
            SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as hadir,
            SUM(CASE WHEN status = 'terlambat' THEN 1 ELSE 0 END) as terlambat,
            SUM(CASE WHEN status = 'alpha' THEN 1 ELSE 0 END) as alpha")
            ->whereBetween('tanggal', [$start, $end])
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        // Format untuk chart JS
        $labels = [];
        $hadir = [];
        $terlambat = [];
        $alpha = [];

        foreach ($absensiData as $data) {
            $labels[] = $data->tgl;
            $hadir[] = $data->hadir;
            $terlambat[] = $data->terlambat;
            $alpha[] = $data->alpha;
        }

        $totalAdmin = User::where('role', 'admin')->count();
        $totalHonorer = Honorer::count();

        $totalAlpha = Absensi::where('status', 'alpha')->count();

        // Status absensi yang dianggap valid
        $totalAbsensiValid = Absensi::whereIn('status', ['hadir', 'sakit', 'izin', 'terlambat'])->count();
        $headerText = 'Dashboard';
        return view('dashboard.dashboard', compact('totalAdmin', 'totalHonorer', 'totalAlpha', 'totalAbsensiValid', 'headerText', 'labels', 'hadir', 'terlambat', 'alpha'));
    }


    public function profile()
    {
        $headerText = 'Profile';

        return view('dashboard.profile', compact('headerText'));
    }


    public function ubahPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            // password lama TIDAK cocok
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with([
            'alert_title' => 'Berhasil!',
            'alert_message' => 'Password berhasil diubah.',
        ]);
    }
}
