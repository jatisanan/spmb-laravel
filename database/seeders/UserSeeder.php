<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // SUPER ADMIN — akses penuh
        User::firstOrCreate(
            ['email' => 'admin@jatisanan.my.id'],
            [
                'name'      => 'Super Administrator',
                'password'  => Hash::make('12344321'),
                'role'      => 'super_admin',
                'is_active' => true,
            ]
        );

        // ADMIN — akses admin tanpa menu Pengguna
        User::firstOrCreate(
            ['email' => 'admin@jatisanan.test'],
            [
                'name'      => 'Admin Testing',
                'password'  => Hash::make('admin123'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );

        // SANTRI — akses panel santri
        User::firstOrCreate(
            ['email' => 'santri@jatisanan.test'],
            [
                'name'      => 'Santri Testing',
                'password'  => Hash::make('santri123'),
                'role'      => 'student',
                'is_active' => true,
            ]
        );
    }
}