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
                'password' => Hash::make('password123'), // PERBAIKAN: Gunakan password123
                'role' => 'Admin',
            ],
            [
                'username' => 'tu_siakad',
                'email' => 'tu@example.com',
                'password' => Hash::make('password123'), // PERBAIKAN: Gunakan password123
                'role' => 'TU',
            ],
            [
                'username' => 'guru_siakad',
                'email' => 'guru@example.com',
                'password' => Hash::make('password123'), // PERBAIKAN: Gunakan password123
                'role' => 'Guru',
            ],
            [
                'username' => 'siswa_siakad',
                'email' => 'siswa@example.com',
                'password' => Hash::make('password123'), // PERBAIKAN: Gunakan password123
                'role' => 'Siswa',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['username' => $user['username']],
                $user
            );
        }
    }
}
