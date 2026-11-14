<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KelompokSampahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Data Kelompok
        $kelompok = [
            ['nama_kelompok' => 'TPA 1', 'keterangan' => 'Tempat Pembuangan Akhir 1', 'created_at' => $now, 'updated_at' => $now],
            ['nama_kelompok' => 'TPA 2', 'keterangan' => 'Tempat Pembuangan Akhir 2', 'created_at' => $now, 'updated_at' => $now],
            ['nama_kelompok' => 'IPAL 1', 'keterangan' => 'Instalasi Pengolahan Air Limbah 1', 'created_at' => $now, 'updated_at' => $now],
            ['nama_kelompok' => 'IPAL 2', 'keterangan' => 'Instalasi Pengolahan Air Limbah 2', 'created_at' => $now, 'updated_at' => $now],
            ['nama_kelompok' => 'KRAMAT', 'keterangan' => 'Kelompok Kramat', 'created_at' => $now, 'updated_at' => $now],
            ['nama_kelompok' => 'PONCOL', 'keterangan' => 'Kelompok Poncol', 'created_at' => $now, 'updated_at' => $now],
            ['nama_kelompok' => 'CIPEUCANG', 'keterangan' => 'Kelompok Cipeucang', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('kelompok')->insert($kelompok);

        // Data Anggota Kelompok KRAMAT (kelompok_id = 5)
        $anggotaKramat = [
            ['kelompok_id' => 5, 'nama_anggota' => 'Laman', 'created_at' => $now, 'updated_at' => $now],
            ['kelompok_id' => 5, 'nama_anggota' => 'Roy S', 'created_at' => $now, 'updated_at' => $now],
            ['kelompok_id' => 5, 'nama_anggota' => 'Suryana', 'created_at' => $now, 'updated_at' => $now],
            ['kelompok_id' => 5, 'nama_anggota' => 'Mahmud', 'created_at' => $now, 'updated_at' => $now],
            ['kelompok_id' => 5, 'nama_anggota' => 'Tatim M', 'created_at' => $now, 'updated_at' => $now],
            ['kelompok_id' => 5, 'nama_anggota' => 'Alim', 'created_at' => $now, 'updated_at' => $now],
            ['kelompok_id' => 5, 'nama_anggota' => 'Ibel', 'created_at' => $now, 'updated_at' => $now],
            ['kelompok_id' => 5, 'nama_anggota' => 'Rama S', 'created_at' => $now, 'updated_at' => $now],
            ['kelompok_id' => 5, 'nama_anggota' => 'Junaedi', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('anggota_kelompok')->insert($anggotaKramat);

        // Data Jenis Sampah
        $jenisSampah = [
            [
                'nama_jenis' => 'Organik',
                'deskripsi' => 'Sampah yang berasal dari makhluk hidup dan mudah terurai secara alami',
                'contoh' => 'Sisa makanan, kulit buah, sayuran busuk, daun kering, dan ranting pohon',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_jenis' => 'Anorganik',
                'deskripsi' => 'Sampah yang tidak mudah terurai dan berasal dari bahan non-organik',
                'contoh' => 'Botol plastik, kantong plastik, kaleng, dan gelas kaca',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_jenis' => 'Kertas',
                'deskripsi' => 'Sampah berbahan dasar kertas yang dapat didaur ulang',
                'contoh' => 'Kardus, koran, buku bekas, dan bungkus kertas',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_jenis' => 'B3 (Bahan Berbahaya dan Beracun)',
                'deskripsi' => 'Sampah yang mengandung bahan berbahaya dan memerlukan penanganan khusus',
                'contoh' => 'Baterai bekas, lampu neon, aki, dan kemasan obat kimia',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nama_jenis' => 'Residu',
                'deskripsi' => 'Sampah sisa yang tidak dapat didaur ulang atau dimanfaatkan kembali',
                'contoh' => 'Popok bayi sekali pakai, pembalut wanita, tisu basah, dan puntung rokok',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];
        DB::table('jenis_sampah')->insert($jenisSampah);

        // Data Tugas Jadwal (contoh beberapa tugas)
        $tugasJadwal = [
            [
                'kelompok_id' => 5, // KRAMAT
                'jenis_sampah_id' => 1, // Organik
                'tanggal_tugas' => $now->copy()->addDays(1)->format('Y-m-d'),
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'lokasi' => 'Area Kramat Timur',
                'status' => 'pending',
                'catatan' => 'Pengangkutan sampah organik rutin',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'kelompok_id' => 5, // KRAMAT
                'jenis_sampah_id' => 2, // Anorganik
                'tanggal_tugas' => $now->copy()->addDays(2)->format('Y-m-d'),
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'lokasi' => 'Area Kramat Barat',
                'status' => 'pending',
                'catatan' => 'Pemilahan sampah anorganik',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'kelompok_id' => 1, // TPA 1
                'jenis_sampah_id' => 3, // Kertas
                'tanggal_tugas' => $now->copy()->addDays(1)->format('Y-m-d'),
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '16:00:00',
                'lokasi' => 'TPA 1 Zona A',
                'status' => 'pending',
                'catatan' => 'Pengumpulan sampah kertas',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];
        DB::table('tugas_jadwal')->insert($tugasJadwal);
    }
}
