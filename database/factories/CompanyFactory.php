<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),

            'industry' => fake()->randomElement([
                'Technology',
                'Fintech',
                'E-Commerce',
                'Education',
                'Healthcare',
            ]),

            'size' => fake()->randomElement([
                'startup',
                'small',
                'medium',
                'large',
                'corporate',
            ]),

            'website' => fake()->url(),

            'location' => fake()->city(),

            'logo_url' => null,

            'description' => fake()->paragraph(),

            'culture_notes' => fake()->sentence(),

            'benefits_notes' => fake()->sentence(),

            'personal_rating' => fake()->numberBetween(1, 5),

            'tags' => [
                fake()->word(),
                fake()->word(),
            ],
        ];
    }
}