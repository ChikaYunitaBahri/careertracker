<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\CalendarEvent;
use App\Models\CareerGoal;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where(
            'email',
            'demo@careertracker.test'
        )->first();

        if (!$user) {
            return;
        }

        Company::factory(15)->create([
            'user_id' => $user->id,
        ]);

        Application::factory(25)->create([
            'user_id' => $user->id,
        ]);

        CareerGoal::factory(3)->create([
            'user_id' => $user->id,
        ]);

        CalendarEvent::factory(10)->create([
            'user_id' => $user->id,
        ]);
    }
}