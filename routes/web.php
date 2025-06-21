<?php

use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DinasController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\HonorerController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\JadwalKerjaController;
use App\Http\Controllers\FaceRecognitionController;

// Register alias middleware 'role'
Route::aliasMiddleware('role', CheckRole::class);
Route::get('/', function () {
    return redirect('/login');
});
// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/check-temp', function () {
    return response()->json([
        'TEMP' => getenv('TEMP'),
        'TMP' => getenv('TMP'),
        'TEMP_exists' => is_dir(getenv('TEMP')),
        'TMP_exists' => is_dir(getenv('TMP')),
    ]);
});


Route::middleware('auth')->group(function () {

    // Dashboard hanya super_admin dan admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/user', [UserController::class, 'user']);
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/dispensasi', [AbsensiController::class, 'dispensasi'])->name('dispensasi.create');
        Route::post('/admin/dispensasi', [AbsensiController::class, 'store'])->name('admin.dispensasi.store');
        
        Route::get('/dinasku', [DinasController::class, 'index']);
        Route::put('/dinasku/{user}', [DinasController::class, 'update'])->name('dinasku.update');

        Route::get('/honorer', [HonorerController::class, 'honorer']);
        Route::post('/honorer', [HonorerController::class, 'store'])->name('honorer.store');
        Route::put('/honorer/{user}', [HonorerController::class, 'update'])->name('honorer.update');
        Route::delete('/honorer/{id}', [HonorerController::class, 'destroy'])->name('honorer.destroy');


        Route::get('/jadwal-kerja', [JadwalKerjaController::class, 'index'])->name('jadwal.index');
        Route::post('/jadwal-kerja/update', [JadwalKerjaController::class, 'update'])->name('jadwal.update'); // POST
        Route::post('/jadwal/reset/{id}', [JadwalKerjaController::class, 'resetSingle'])->name('jadwal.reset.single');

        Route::get('/admin', [UserController::class, 'admin']);
    });

    // Landing hanya honorer
    Route::middleware('role:honorer')->group(function () {
        Route::get('/home', [LandingController::class, 'home'])->name('home');

        Route::get('/izins', [LandingController::class, 'izin'])->name('izin');
        Route::post('/izin/store', [LandingController::class, 'storeIzin'])->name('storeIzin');

        Route::get('/history', [LandingController::class, 'history'])->name('history');
        Route::get('/jadwal', [LandingController::class, 'jadwal'])->name('jadwal');

        Route::get('/profile', [LandingController::class, 'profile'])->name('profile');
        Route::put('/profile', [LandingController::class, 'update'])->name('profile.update');

        Route::get('/scan', [AbsensiController::class, 'create'])->name('create');
        Route::post('/scan-wajah/validasi-lokasi', [AbsensiController::class, 'validasiLokasi'])->name('scan.validasiLokasi');
        Route::post('/scan/check-location', [AbsensiController::class, 'checkLocation'])->name('scan.check-location');
        Route::post('/scan-wajah/check', [AbsensiController::class, 'check']);
    });
});
