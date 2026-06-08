<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User demo utama
        User::firstOrCreate(
            ['email' => 'demo@careertracker.test'],
            [
                'name'            => 'Budi Santoso',
                'password'        => Hash::make('password'),
                'university'      => 'Universitas Indonesia',
                'major'           => 'Teknik Informatika',
                'graduation_year' => 2024,
                'skills'          => ['Laravel', 'Vue.js', 'MySQL', 'Docker', 'Git'],
                'bio'             => 'Fresh graduate yang sedang aktif mencari pekerjaan di bidang backend development.',
                'linkedin_url'    => 'https://linkedin.com/in/budisantoso',
                'portfolio_url'   => 'https://budisantoso.dev',
            ]
        );

        // User kedua untuk testing multi-user
        User::firstOrCreate(
            ['email' => 'admin@careertracker.test'],
            [
                'name'            => 'Admin Career Tracker',
                'password'        => Hash::make('password'),
                'university'      => 'Institut Teknologi Bandung',
                'major'           => 'Sistem Informasi',
                'graduation_year' => 2023,
                'skills'          => ['Product Management', 'Figma', 'SQL'],
                'bio'             => 'Admin dan tester aplikasi Career Tracker.',
            ]
        );
    }
}