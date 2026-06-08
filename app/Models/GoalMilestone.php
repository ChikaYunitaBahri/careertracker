<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoalMilestone extends Model
{
    protected $fillable = [
        'goal_id', 'title', 'target_count', 'is_achieved', 'achieved_at', 'order_position',
    ];

    protected function casts(): array
    {
        return [
            'is_achieved' => 'boolean',
            'achieved_at' => 'datetime',
        ];
    }

    public function goal(): BelongsTo
    {
        return $this->belongsTo(CareerGoal::class, 'goal_id');
    }
}
