<?php

namespace Database\Seeders;

use App\Models\RecruitmentStatus;
use Illuminate\Database\Seeder;

class RecruitmentStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['slug' => 'wishlist',   'label' => 'Wishlist',   'color' => '#95A5A6', 'sort_order' => 1, 'order_position' => 1],
            ['slug' => 'applied',    'label' => 'Applied',    'color' => '#3498DB', 'sort_order' => 2, 'order_position' => 2],
            ['slug' => 'hr_screen',  'label' => 'HR Screen',  'color' => '#9B59B6', 'sort_order' => 3, 'order_position' => 3],
            ['slug' => 'interview',  'label' => 'Interview',  'color' => '#F39C12', 'sort_order' => 4, 'order_position' => 4],
            ['slug' => 'offering',   'label' => 'Offering',   'color' => '#1ABC9C', 'sort_order' => 5, 'order_position' => 5],
            ['slug' => 'accepted',   'label' => 'Accepted',   'color' => '#27AE60', 'sort_order' => 6, 'order_position' => 6],
            ['slug' => 'rejected',   'label' => 'Rejected',   'color' => '#E74C3C', 'sort_order' => 7, 'order_position' => 7],
        ];

        foreach ($statuses as $status) {
            RecruitmentStatus::updateOrCreate(
                ['slug' => $status['slug']],
                array_merge($status, ['is_active' => true])
            );
        }
    }
}
