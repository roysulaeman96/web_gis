<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisSampah extends Model
{
    use HasFactory;

    protected $table = 'jenis_sampah';

    protected $fillable = [
        'nama_jenis',
        'deskripsi',
        'contoh',
    ];

    public function tugasJadwal(): HasMany
    {
        return $this->hasMany(TugasJadwal::class, 'jenis_sampah_id');
    }
}
