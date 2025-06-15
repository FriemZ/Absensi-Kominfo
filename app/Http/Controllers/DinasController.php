<?php

namespace App\Http\Controllers;

use App\Models\Dinas;
use Illuminate\Http\Request;

class DinasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dinas = Dinas::findOrFail(auth()->user()->dinas_id); // hanya dinas milik admin
        $headerText = 'Dinas & Instansi';
        return view('dashboard.setting.dinasku', compact(
            'headerText', 'dinas'
        ));
    }

    // Update data dinas
    public function update(Request $request, $id)
    {
        $dinas = Dinas::findOrFail($id);

        $validated = $request->validate([
            'nama_dinas' => 'required|string|max:255',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_absen' => 'nullable|integer|min:0',
            'maks_keterlambatan' => 'nullable|integer|min:0|max:120',
        ]);

        $dinas->update([
            'nama_dinas' => $validated['nama_dinas'],
            'alamat' => $validated['alamat'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'radius_absen' => $validated['radius_absen'] ?? $dinas->radius_absen,
            'maks_keterlambatan' => $validated['maks_keterlambatan'] ?? $dinas->maks_keterlambatan,
        ]);

        return redirect()->back()->with([
            'alert_title' => 'Update Dinas',
            'alert_message' => 'Dinas berhasil diperbarui!',
        ]);
    }
}
