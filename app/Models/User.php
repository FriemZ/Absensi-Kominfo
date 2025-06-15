<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'username', 'tanggal_lahir', 'email', 'password', 'role', 'dinas_id'];

    protected $hidden = ['password', 'remember_token'];

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'dinas_id'); // pastikan foreign key benar
    }


    public function honorer()
    {
        return $this->hasOne(Honorer::class);
    }


    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
