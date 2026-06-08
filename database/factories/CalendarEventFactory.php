<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CalendarEventFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('now', '+30 days');

        return [
            'title' => fake()->sentence(3),

            'event_type' => fake()->randomElement([
                'interview',
                'test',
                'deadline',
                'followup',
                'other'
            ]),

            'event_datetime' => $start,

            'end_datetime' => (clone $start)->modify('+1 hour'),

            'description' => fake()->sentence(),

            'location' => fake()->city(),

            'is_online' => fake()->boolean(),

            'reminder_minutes' => 60,

            'is_completed' => false,

            'color' => '#3B82F6',
        ];
    }
}