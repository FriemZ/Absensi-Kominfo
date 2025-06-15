<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dinas extends Model
{
    use HasFactory;
    protected $table = 'dinas';
    protected $fillable = ['nama_dinas', 'alamat', 'latitude', 'longitude', 'radius_absen','maks_keterlambatan'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function jadwalKerja()
    {
        return $this->hasMany(JadwalKerja::class);
    }

    public function hariLibur()
    {
        return $this->hasMany(HariLibur::class);
    }
}
