<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\ApplicationNote;
use App\Models\Company;
use App\Models\RecruitmentStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'demo@careertracker.test')->first();

        // Ambil status ID berdasarkan slug
        $statuses = RecruitmentStatus::pluck('id', 'slug');

        // Ambil company ID berdasarkan nama
        $companies = Company::where('user_id', $user->id)->pluck('id', 'name');

        $applications = [
            [
                'company_name'      => 'Tokopedia',
                'position_name'     => 'Backend Engineer (Laravel)',
                'status_slug'       => 'interview',
                'applied_date'      => now()->subDays(20),
                'job_type'          => 'full_time',
                'work_location_type'=> 'hybrid',
                'location'          => 'Jakarta Selatan',
                'salary_min'        => 8000000,
                'salary_max'        => 12000000,
                'source'            => 'LinkedIn',
                'job_post_url'      => 'https://linkedin.com/jobs/1234567',
                'initial_notes'     => 'Posisi yang sangat sesuai dengan skill stack saya.',
                'notes' => [
                    [
                        'note_type'       => 'hr_interview',
                        'interview_date'  => now()->subDays(10),
                        'interviewer_name'=> 'Sarah (HR Tokopedia)',
                        'content'         => 'Wawancara berjalan lancar. Ditanya tentang pengalaman proyek Laravel dan pemahaman tentang REST API.',
                        'impression'      => 'Positif, HR sangat ramah dan informatif tentang kultur perusahaan.',
                    ],
                ],
            ],
            [
                'company_name'      => 'Gojek',
                'position_name'     => 'Software Engineer - Backend',
                'status_slug'       => 'applied',
                'applied_date'      => now()->subDays(5),
                'job_type'          => 'full_time',
                'work_location_type'=> 'remote',
                'location'          => 'Jakarta Pusat',
                'salary_min'        => 10000000,
                'salary_max'        => 15000000,
                'source'            => 'Website Perusahaan',
                'job_post_url'      => 'https://gojek.com/careers/backend-engineer',
                'initial_notes'     => 'Daftar melalui career page langsung.',
                'notes' => [],
            ],
            [
                'company_name'      => 'Ruangguru',
                'position_name'     => 'Full Stack Developer',
                'status_slug'       => 'hr_screen',
                'applied_date'      => now()->subDays(15),
                'job_type'          => 'full_time',
                'work_location_type'=> 'onsite',
                'location'          => 'Jakarta Selatan',
                'salary_min'        => 7000000,
                'salary_max'        => 10000000,
                'source'            => 'Jobstreet',
                'initial_notes'     => 'Tertarik karena misi sosial perusahaan.',
                'notes' => [
                    [
                        'note_type'       => 'general',
                        'interview_date'  => null,
                        'interviewer_name'=> null,
                        'content'         => 'Sudah mengisi form online screening. Menunggu jadwal panggilan HR.',
                        'impression'      => 'Proses administrasi cepat dan rapi.',
                    ],
                ],
            ],
            [
                'company_name'      => 'Tiket.com',
                'position_name'     => 'Backend Developer (PHP)',
                'status_slug'       => 'rejected',
                'applied_date'      => now()->subDays(30),
                'job_type'          => 'full_time',
                'work_location_type'=> 'hybrid',
                'location'          => 'Jakarta Pusat',
                'salary_min'        => 6000000,
                'salary_max'        => 9000000,
                'source'            => 'Glints',
                'initial_notes'     => 'Mencoba melamar untuk pengalaman proses seleksi.',
                'notes' => [
                    [
                        'note_type'       => 'user_interview',
                        'interview_date'  => now()->subDays(18),
                        'interviewer_name'=> 'Raka (Tech Lead)',
                        'content'         => 'Technical test dan interview teknis. Diberikan soal algoritma dan desain sistem sederhana.',
                        'impression'      => 'Cukup menantang. Kurang optimal di bagian system design.',
                    ],
                ],
            ],
            [
                'company_name'      => 'Astra International',
                'position_name'     => 'IT Application Developer',
                'status_slug'       => 'wishlist',
                'applied_date'      => now()->subDays(2),
                'job_type'          => 'full_time',
                'work_location_type'=> 'onsite',
                'location'          => 'Jakarta Utara',
                'salary_min'        => 7000000,
                'salary_max'        => 11000000,
                'source'            => 'LinkedIn',
                'initial_notes'     => 'Masih dalam pertimbangan, belum apply.',
                'notes' => [],
            ],
        ];

        foreach ($applications as $data) {
            $notes = $data['notes'];
            unset($data['notes'], $data['status_slug']);

            $companyName   = $data['company_name'];
            $statusSlug    = collect($applications)->firstWhere('company_name', $companyName)['status_slug']
                             ?? 'wishlist';

            // Ambil status_slug dari data asli (sebelum unset)
            $matchedApp    = collect($applications)->firstWhere('company_name', $companyName);
            $resolvedSlug  = $matchedApp['status_slug'] ?? 'wishlist';

            $application = Application::firstOrCreate(
                [
                    'user_id'       => $user->id,
                    'company_name'  => $companyName,
                    'position_name' => $data['position_name'],
                ],
                array_merge($data, [
                    'user_id'    => $user->id,
                    'company_id' => $companies[$companyName] ?? null,
                    'status_id'  => $statuses[$resolvedSlug],
                ])
            );

            foreach ($notes as $note) {
                ApplicationNote::firstOrCreate(
                    [
                        'application_id' => $application->id,
                        'content'        => $note['content'],
                    ],
                    array_merge($note, [
                        'application_id' => $application->id,
                        'user_id'        => $user->id,
                    ])
                );
            }
        }
    }
}