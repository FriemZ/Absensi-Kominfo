<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKerja extends Model
{
    protected $table = 'jadwal_kerja';

    protected $fillable = [
        'dinas_id',
        'hari',
        'jam_masuk',
        'jam_pulang',
        'is_libur',
    ];

    public function dinas()
    {
        return $this->belongsTo(Dinas::class);
    }
}
