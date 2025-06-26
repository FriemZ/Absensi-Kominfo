<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jadwal_kerja_id',
        'tanggal',
        'waktu_masuk',
        'waktu_pulang',
        'status',
        'bukti_file',
        'menit_terlambat'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    public function jadwalKerja()
    {
        return $this->belongsTo(JadwalKerja::class);
    }

    protected $casts = [
        'tanggal' => 'date',
    ];
}
