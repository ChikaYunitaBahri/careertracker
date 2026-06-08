<?php

namespace Database\Seeders;

use App\Models\CareerGoal;
use App\Models\GoalMilestone;
use App\Models\User;
use Illuminate\Database\Seeder;

class CareerGoalSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'demo@careertracker.test')->first();

        if (!$user) {
            return;
        }

        $goals = [
            [
                'title'                    => 'Mendapatkan Pekerjaan Backend Developer dalam 3 Bulan',
                'job_type'                 => 'full_time',
                'target_industries'        => ['Teknologi', 'E-Commerce', 'Fintech'],
                'target_cities'            => ['Jakarta', 'Bandung', 'Remote'],
                'target_application_count' => 20,
                'current_count'            => 5,
                'target_salary_min'        => 8000000,
                'deadline'                 => now()->addMonths(3)->toDateString(),
                'notes'                    => 'Target melamar minimal 20 perusahaan.',
                'status'                   => 'active',
                'milestones'               => [
                    [
                        'title' => 'Perbarui CV dan Portfolio',
                        'is_completed' => true,
                        'due_date' => now()->subDays(25)->toDateString(),
                    ],
                    [
                        'title' => 'Daftar 10 perusahaan pertama',
                        'is_completed' => true,
                        'due_date' => now()->subDays(10)->toDateString(),
                    ],
                    [
                        'title' => 'Daftar 10 perusahaan berikutnya',
                        'is_completed' => false,
                        'due_date' => now()->addDays(5)->toDateString(),
                    ],
                    [
                        'title' => 'Latihan technical interview online',
                        'is_completed' => false,
                        'due_date' => now()->addDays(14)->toDateString(),
                    ],
                    [
                        'title' => 'Dapatkan minimal 1 job offer',
                        'is_completed' => false,
                        'due_date' => now()->addMonths(3)->toDateString(),
                    ],
                ],
            ],

            [
                'title'                    => 'Kuasai Docker dan Kubernetes',
                'job_type'                 => null,
                'target_industries'        => ['Teknologi', 'Cloud Computing'],
                'target_cities'            => ['Remote'],
                'target_application_count' => 5,
                'current_count'            => 0,
                'target_salary_min'        => 10000000,
                'deadline'                 => now()->addMonths(2)->toDateString(),
                'notes'                    => 'Belajar containerization untuk meningkatkan nilai jual.',
                'status'                   => 'active',
                'milestones'               => [
                    [
                        'title' => 'Selesaikan kursus Docker di Udemy',
                        'is_completed' => true,
                        'due_date' => now()->subDays(5)->toDateString(),
                    ],
                    [
                        'title' => 'Buat project dengan Docker Compose',
                        'is_completed' => false,
                        'due_date' => now()->addDays(10)->toDateString(),
                    ],
                    [
                        'title' => 'Pelajari dasar-dasar Kubernetes',
                        'is_completed' => false,
                        'due_date' => now()->addDays(30)->toDateString(),
                    ],
                    [
                        'title' => 'Deploy project ke cluster Kubernetes',
                        'is_completed' => false,
                        'due_date' => now()->addMonths(2)->toDateString(),
                    ],
                ],
            ],
        ];

        foreach ($goals as $goalData) {

            $milestones = $goalData['milestones'];
            unset($goalData['milestones']);

            $goal = CareerGoal::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'title'   => $goalData['title'],
                ],
                array_merge(
                    $goalData,
                    ['user_id' => $user->id]
                )
            );

            foreach ($milestones as $index => $milestone) {

                GoalMilestone::firstOrCreate(
                    [
                        'goal_id' => $goal->id,
                        'title'   => $milestone['title'],
                    ],
                    [
                        'goal_id'        => $goal->id,
                        'title'          => $milestone['title'],
                        'due_date'       => $milestone['due_date'],
                        'is_completed'   => $milestone['is_completed'],
                        'completed_at'   => $milestone['is_completed'] ? now() : null,
                        'order_position' => $index + 1,
                    ]
                );
            }
        }
    }
}