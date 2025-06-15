<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\File;

class Honorer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_kelamin',
        'no_hp',
        'alamat',
        'jabatan',
        'foto_wajah',
        'face_encoding'
    ];

    protected static function booted()
    {
        static::deleting(function ($honorer) {
            $faceDir = public_path('face');
            $userIdPrefix = $honorer->user_id . '_';

            // Cari semua folder dalam 'public/face'
            $folders = File::directories($faceDir);

            foreach ($folders as $folder) {
                if (str_starts_with(basename($folder), $userIdPrefix)) {
                    File::deleteDirectory($folder);
                    \Log::info("Folder {$folder} dihapus karena user {$honorer->user_id} dihapus.");
                }
            }

            // Hapus user terkait
            $honorer->user()->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
