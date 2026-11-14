<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelompok extends Model
{
    use HasFactory;

    protected $table = 'kelompok';

    protected $fillable = [
        'nama_kelompok',
        'keterangan',
    ];

    public function anggota(): HasMany
    {
        return $this->hasMany(AnggotaKelompok::class, 'kelompok_id');
    }

    public function tugasJadwal(): HasMany
    {
        return $this->hasMany(TugasJadwal::class, 'kelompok_id');
    }
}
