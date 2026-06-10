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

        $neededCompanies = max(0, 15 - $user->companies()->count());

        if ($neededCompanies > 0) {
            Company::factory($neededCompanies)->create([
                'user_id' => $user->id,
            ]);
        }

        $neededApplications = max(0, 25 - $user->applications()->count());

        if ($neededApplications > 0) {
            Application::factory($neededApplications)
                ->make(['user_id' => $user->id])
                ->each(function (Application $application) use ($user) {
                    $company = $user->companies()->inRandomOrder()->first();

                    if ($company) {
                        $application->company_id = $company->id;
                        $application->company_name = $company->name;
                    }

                    $application->save();
                });
        }

        $neededGoals = max(0, 3 - $user->careerGoals()->count());

        if ($neededGoals > 0) {
            CareerGoal::factory($neededGoals)->create([
                'user_id' => $user->id,
            ]);
        }

        $neededEvents = max(0, 10 - $user->calendarEvents()->count());

        if ($neededEvents > 0) {
            CalendarEvent::factory($neededEvents)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
