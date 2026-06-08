<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Database\Seeder;

class CalendarEventSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'demo@careertracker.test')->first();

        if (!$user) {
            return;
        }

        $application = Application::where('user_id', $user->id)
            ->first();

        $events = [
            [
                'application_id'   => $application?->id,
                'title'            => 'Interview Teknis',
                'event_type'       => 'interview',
                'event_datetime'   => now()->addDays(3)->setTime(10, 0),
                'end_datetime'     => now()->addDays(3)->setTime(11, 30),
                'location'         => 'Google Meet',
                'description'      => 'Technical interview tahap lanjutan.',
                'reminder_minutes' => 60,
                'is_online'        => true,
                'is_completed'     => false,
                'color'            => '#3B82F6',
            ],

            [
                'application_id'   => null,
                'title'            => 'Follow-up Email',
                'event_type'       => 'followup',
                'event_datetime'   => now()->addDays(7)->setTime(9, 0),
                'end_datetime'     => now()->addDays(7)->setTime(9, 30),
                'description'      => 'Kirim email follow-up.',
                'reminder_minutes' => 30,
                'is_online'        => true,
                'is_completed'     => false,
                'color'            => '#F59E0B',
            ],

            [
                'application_id'   => null,
                'title'            => 'Deadline Update Portfolio',
                'event_type'       => 'deadline',
                'event_datetime'   => now()->addDays(5)->setTime(23, 59),
                'end_datetime'     => null,
                'description'      => 'Selesaikan update portfolio.',
                'reminder_minutes' => 1440,
                'is_online'        => false,
                'is_completed'     => false,
                'color'            => '#EF4444',
            ],
        ];

        foreach ($events as $event) {
            CalendarEvent::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => $event['title'],
                ],
                array_merge(
                    $event,
                    ['user_id' => $user->id]
                )
            );
        }
    }
}