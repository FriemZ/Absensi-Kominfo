<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HariLibur extends Model
{
    use HasFactory;

    protected $table = 'hari_libur';

    protected $fillable = ['dinas_id', 'tanggal', 'keterangan'];

    public function dinas()
    {
        return $this->belongsTo(Dinas::class);
    }
}
