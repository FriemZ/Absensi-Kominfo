<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jadwal_kerja_id')->constrained('jadwal_kerja');
            $table->date('tanggal');
            $table->time('waktu_masuk')->nullable();
            $table->time('waktu_pulang')->nullable();
            $table->enum('status', ['hadir', 'terlambat', 'izin', 'sakit', 'alpha']);
            $table->string('bukti_file')->nullable(); // path file izin (foto/pdf)
            $table->integer('menit_terlambat')->default(0);
            $table->timestamps();
            $table->unique(['user_id', 'tanggal']); // mencegah absen dobel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
