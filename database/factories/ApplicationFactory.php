<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Company;
use App\Models\RecruitmentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::query()->inRandomOrder()->value('id'),

            'status_id' => RecruitmentStatus::query()->inRandomOrder()->value('id'),

            'position_name' => fake()->randomElement([
                'Backend Developer',
                'Frontend Developer',
                'Fullstack Developer',
                'UI/UX Designer',
                'Product Designer',
                'Product Manager',
            ]),

            'company_name' => fake()->company(),

            'applied_date' => fake()->dateTimeBetween('-3 months', 'now'),

            'job_post_url' => fake()->url(),

            'source' => fake()->randomElement([
                'LinkedIn',
                'JobStreet',
                'Glints',
                'Indeed',
                'Company Website',
            ]),

            'salary_min' => fake()->numberBetween(
                5000000,
                10000000
            ),

            'salary_max' => fake()->numberBetween(
                10000000,
                20000000
            ),

            'job_type' => fake()->randomElement([
                'full_time',
                'part_time',
                'internship',
                'contract',
                'freelance',
            ]),

            'work_location_type' => fake()->randomElement([
                'onsite',
                'remote',
                'hybrid',
            ]),

            'location' => fake()->city(),

            'referral_code' => null,

            'initial_notes' => fake()->sentence(),

            'is_archived' => false,
        ];
    }
}