<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@ukk.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Petugas user
        User::create([
            'name' => 'Petugas Peminjaman',
            'email' => 'petugas@ukk.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'email_verified_at' => now(),
        ]);

        // Regular user (peminjam)
        User::create([
            'name' => 'User Peminjam',
            'email' => 'user@ukk.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Additional test users
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@ukk.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@ukk.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
    }
}
