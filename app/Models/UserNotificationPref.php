<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNotificationPref extends Model
{
    protected $table = 'user_notification_prefs';

    protected $fillable = [
        'user_id', 'email_enabled', 'push_enabled',
        'interview_reminder_email', 'interview_reminder_push',
        'idle_application_email', 'idle_application_push',
        'goal_milestone_push', 'weekly_summary_email',
    ];

    protected function casts(): array
    {
        return [
            'email_enabled'             => 'boolean',
            'push_enabled'              => 'boolean',
            'interview_reminder_email'  => 'boolean',
            'interview_reminder_push'   => 'boolean',
            'idle_application_email'    => 'boolean',
            'idle_application_push'     => 'boolean',
            'goal_milestone_push'       => 'boolean',
            'weekly_summary_email'      => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
