<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalendarEvent extends Model
{
    protected $fillable = [
        'user_id', 'application_id', 'title', 'event_type',
        'event_datetime', 'end_datetime', 'description', 'location',
        'is_online', 'reminder_minutes', 'is_completed', 'color',
    ];

    protected function casts(): array
    {
        return [
            'event_datetime' => 'datetime',
            'end_datetime'   => 'datetime',
            'is_online'      => 'boolean',
            'is_completed'   => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
