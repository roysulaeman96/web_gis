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
        // Tabel Kelompok
        Schema::create('kelompok', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelompok');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Tabel Anggota Kelompok
        Schema::create('anggota_kelompok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_id')->constrained('kelompok')->onDelete('cascade');
            $table->string('nama_anggota');
            $table->timestamps();
        });

        // Tabel Jenis Sampah
        Schema::create('jenis_sampah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis');
            $table->text('deskripsi')->nullable();
            $table->text('contoh')->nullable();
            $table->timestamps();
        });

        // Tabel Tugas Jadwal
        Schema::create('tugas_jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_id')->constrained('kelompok')->onDelete('cascade');
            $table->foreignId('jenis_sampah_id')->constrained('jenis_sampah')->onDelete('cascade');
            $table->date('tanggal_tugas');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('lokasi')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_jadwal');
        Schema::dropIfExists('jenis_sampah');
        Schema::dropIfExists('anggota_kelompok');
        Schema::dropIfExists('kelompok');
    }
};
