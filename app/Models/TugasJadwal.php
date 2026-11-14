<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TugasJadwal extends Model
{
    use HasFactory;

    protected $table = 'tugas_jadwal';

    protected $fillable = [
        'kelompok_id',
        'jenis_sampah_id',
        'tanggal_tugas',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_tugas' => 'date',
    ];

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }

    public function jenisSampah(): BelongsTo
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah_id');
    }
}
