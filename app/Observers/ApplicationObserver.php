<?php

namespace App\Observers;

use App\Models\Application;
use App\Models\ApplicationActivity;

class ApplicationObserver
{
    public function created(Application $application): void
    {
        ApplicationActivity::create([
            'application_id' => $application->id,
            'user_id'        => $application->user_id,
            'activity_type'  => 'application_created',
            'description'    => "Lamaran untuk posisi {$application->position_name} ditambahkan.",
            'metadata'       => null,
        ]);
    }

    public function updated(Application $application): void
    {
        if ($application->wasChanged('status_id')) {
            ApplicationActivity::create([
                'application_id' => $application->id,
                'user_id'        => $application->user_id,
                'activity_type'  => 'status_changed',
                'description'    => "Status lamaran diperbarui.",
                'metadata'       => [
                    'from_status_id' => $application->getOriginal('status_id'),
                    'to_status_id'   => $application->status_id,
                ],
            ]);
        }
    }
}