<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'demo@careertracker.test')->first();

        $companies = [
            [
                'name'          => 'Tokopedia',
                'industry'      => 'E-Commerce',
                'size'          => 'corporate',
                'website'       => 'https://tokopedia.com',
                'location'      => 'Jakarta Selatan, DKI Jakarta',
                'description'   => 'Platform e-commerce terbesar di Indonesia.',
                'culture_notes' => 'Budaya kerja agile, banyak kesempatan belajar teknologi baru.',
                'benefits_notes'=> 'BPJS, asuransi swasta, makan siang, remote-friendly.',
                'personal_rating' => 5,
                'tags'          => ['top-priority', 'tech', 'unicorn'],
            ],
            [
                'name'          => 'Gojek',
                'industry'      => 'Super App / Teknologi',
                'size'          => 'corporate',
                'website'       => 'https://gojek.com',
                'location'      => 'Jakarta Pusat, DKI Jakarta',
                'description'   => 'Super app dengan layanan transportasi, pesan antar, dan finansial.',
                'culture_notes' => 'Fast-paced, inovatif, banyak engineer senior.',
                'benefits_notes'=> 'Kompetitif, stock option, flexible working.',
                'personal_rating' => 4,
                'tags'          => ['top-priority', 'tech', 'unicorn'],
            ],
            [
                'name'          => 'Astra International',
                'industry'      => 'Konglomerat / Otomotif',
                'size'          => 'corporate',
                'website'       => 'https://astra.co.id',
                'location'      => 'Jakarta Utara, DKI Jakarta',
                'description'   => 'Salah satu perusahaan konglomerat terbesar di Indonesia.',
                'culture_notes' => 'Korporat, terstruktur, jenjang karir jelas.',
                'benefits_notes'=> 'BPJS, tunjangan transport, program pengembangan karyawan.',
                'personal_rating' => 3,
                'tags'          => ['backup', 'established'],
            ],
            [
                'name'          => 'Ruangguru',
                'industry'      => 'EdTech',
                'size'          => 'large',
                'website'       => 'https://ruangguru.com',
                'location'      => 'Jakarta Selatan, DKI Jakarta',
                'description'   => 'Platform edukasi terbesar di Indonesia.',
                'culture_notes' => 'Misi sosial kuat, tim muda dan dinamis.',
                'benefits_notes'=> 'Asuransi, laptop, budget learning.',
                'personal_rating' => 4,
                'tags'          => ['edtech', 'mission-driven'],
            ],
            [
                'name'          => 'Tiket.com',
                'industry'      => 'Travel Tech',
                'size'          => 'medium',
                'website'       => 'https://tiket.com',
                'location'      => 'Jakarta Pusat, DKI Jakarta',
                'description'   => 'Platform pemesanan tiket perjalanan online.',
                'culture_notes' => 'Startup culture, kolaboratif.',
                'benefits_notes'=> 'Diskon tiket, BPJS, hybrid working.',
                'personal_rating' => 3,
                'tags'          => ['travel', 'tech'],
            ],
        ];

        foreach ($companies as $data) {
            Company::firstOrCreate(
                ['name' => $data['name'], 'user_id' => $user->id],
                array_merge($data, ['user_id' => $user->id])
            );
        }
    }
}