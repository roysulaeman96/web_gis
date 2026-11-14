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
        Schema::table('trackings', function (Blueprint $table) {
            $table->string('jenis_sampah')->nullable()->after('image_after_path');
            $table->date('tanggal_tugas')->nullable()->after('jenis_sampah');
            $table->time('waktu_mulai')->nullable()->after('tanggal_tugas');
            $table->time('waktu_selesai')->nullable()->after('waktu_mulai');
            $table->string('lokasi_tugas')->nullable()->after('waktu_selesai');
            $table->text('catatan')->nullable()->after('lokasi_tugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trackings', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_sampah',
                'tanggal_tugas',
                'waktu_mulai',
                'waktu_selesai',
                'lokasi_tugas',
                'catatan'
            ]);
        });
    }
};
