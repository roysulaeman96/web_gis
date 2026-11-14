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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('kelompok_id')->nullable()->after('role')->constrained('kelompok')->onDelete('set null');
            $table->foreignId('anggota_kelompok_id')->nullable()->after('kelompok_id')->constrained('anggota_kelompok')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kelompok_id']);
            $table->dropForeign(['anggota_kelompok_id']);
            $table->dropColumn(['kelompok_id', 'anggota_kelompok_id']);
        });
    }
};
