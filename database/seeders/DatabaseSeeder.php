<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@pltmh.com', // Email, karena login biasanya pake email
            'role' => 'admin', // Role Admin
            'password' => Hash::make('admin11'),
        ]);

        // Buat User Biasa (Contoh)
        User::create([
            'name' => 'Operator Lapangan',
            'email' => 'user@pltmh.com',
            'role' => 'user',
            'password' => Hash::make('user123'),
        ]);
    }
}
