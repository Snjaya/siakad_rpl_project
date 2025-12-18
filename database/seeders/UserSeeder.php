<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data akun untuk simulasi Testing sesuai SKPL
        $users = [
            [
                'username' => 'admin_siakad',
                'email' => 'admin@example.com',
                'password' => Hash::make(' password'),
                'role' => 'Admin', // Pengontrol Sistem & Keamanan 
            ],
            [
                'username' => 'tu_siakad',
                'email' => 'tu@example.com',
                'password' => Hash::make(' password'),
                'role' => 'TU', // Administrator Data Akademik 
            ],
            [
                'username' => 'guru_siakad',
                'email' => 'guru@example.com',
                'password' => Hash::make(' password'),
                'role' => 'Guru', // Pengelola Nilai
            ],
            [
                'username' => 'siswa_siakad',
                'email' => 'siswa@example.com',
                'password' => Hash::make(' password'),
                'role' => 'Siswa', // Pengguna Informasi 
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['username' => $user['username']], // Unik berdasarkan username
                $user
            );
        }
    }
}
