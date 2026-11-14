<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@webgis.test'],
            [
                'name' => 'Admin Web GIS',
                'username' => 'admin_webgis',
                'role' => 'admin',
                'password' => Hash::make('password123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'petugas@webgis.test'],
            [
                'name' => 'Petugas Lapangan',
                'username' => 'petugas_lapangan',
                'role' => 'petugas',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
