<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Dinas;
use App\Models\Honorer;
use App\Models\JadwalKerja;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // database/seeders/UserSeeder.php

    public function run()
    {
        // 1. Buat Dinas
        $dinas = Dinas::create([
            'nama_dinas' => 'Dinas Kominfo Kabupaten Sumenep',
            'alamat' => 'Jl. Trunojoyo No. 10, Sumenep',
            'latitude' => -7.0141111,
            'longitude' => 113.8634722,
            'radius_absen' => 100,
            'maks_keterlambatan' => 15, // toleransi keterlambatan (menit) untuk masuk dan pulang
        ]);

        // 3. Buat Admin Dinas
        $admin = User::create([
            'username' => 'adminfri',
            'name' => 'Admin Kominfo',
            'email' => 'admin@kominfo.go.id',
            'password' => Hash::make('admin1'),
            'role' => 'admin',
            'dinas_id' => $dinas->id,
            'remember_token' => Str::random(10),
        ]);

        // 4. Buat Honorer
        $honorerUser = User::create([
            'username' => 'syafri',
            'name' => 'Rahmat Syafri',
            'email' => 'syafri@honorer.go.id',
            'password' => Hash::make('syf123'),
            'role' => 'honorer',
            'dinas_id' => $dinas->id,
            'remember_token' => Str::random(10),
        ]);

        Honorer::create([
            'user_id' => $honorerUser->id,
            'jenis_kelamin' => 'Laki-laki',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Veteran No. 5, Sumenep',
            'foto_wajah' => 'uploads/foto/syafri.jpg',
            'face_encoding' => json_encode([]), // kosong dulu
        ]);

        // 5. Buat Jadwal Kerja Senin-Jumat
        $hariKerja = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        foreach ($hariKerja as $hari) {
            JadwalKerja::create([
                'dinas_id' => $dinas->id,
                'hari' => $hari,
                'jam_masuk' => '07:30:00',
                'jam_pulang' => '16:00:00',
                'is_libur' => false,
            ]);
        }

        // 6. Sabtu dan Minggu default libur
        JadwalKerja::create([
            'dinas_id' => $dinas->id,
            'hari' => 'Sabtu',
            'jam_masuk' => null,
            'jam_pulang' => null,
            'is_libur' => true,
        ]);

        JadwalKerja::create([
            'dinas_id' => $dinas->id,
            'hari' => 'Minggu',
            'jam_masuk' => null,
            'jam_pulang' => null,
            'is_libur' => true,
        ]);
    }
}
