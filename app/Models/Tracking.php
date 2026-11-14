<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'image_before_path',
        'image_after_path',
        'session_id',
        'tracked_at',
        'jenis_sampah',
        'tanggal_tugas',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi_tugas',
        'catatan',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'tracked_at' => 'datetime',
        'tanggal_tugas' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
