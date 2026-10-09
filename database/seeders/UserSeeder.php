<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@jatisanan.test'], [
            'name' => 'Administrator',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::updateOrCreate(['email' => 'santri@jatisanan.test'], [
            'name' => 'Santri Contoh',
            'password' => Hash::make('santri123'),
            'role' => 'student',
            'is_active' => true,
        ]);
    }
}