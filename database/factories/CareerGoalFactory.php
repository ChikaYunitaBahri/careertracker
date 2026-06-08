<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CareerGoalFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement([
                'Menjadi Backend Developer',
                'Belajar Laravel Advanced',
                'Mendapatkan Internship',
                'Meningkatkan Portfolio'
            ]),

            'job_type' => 'full_time',

            'target_industries' => [
                'Technology',
                'Fintech'
            ],

            'target_cities' => [
                'Jakarta',
                'Bandung'
            ],

            'target_application_count' => 20,

            'current_count' => fake()->numberBetween(0, 20),

            'target_salary_min' => fake()->numberBetween(
                7000000,
                12000000
            ),

            'deadline' => now()->addMonths(
                fake()->numberBetween(1, 6)
            ),

            'notes' => fake()->sentence(),

            'status' => 'active',
        ];
    }
}