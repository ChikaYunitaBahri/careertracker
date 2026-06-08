<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CareerGoal extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'title', 'job_type', 'target_industries', 'target_cities',
        'target_application_count', 'current_count', 'target_salary_min',
        'deadline', 'notes', 'status',
    ];

    protected function casts(): array
    {
        return [
            'target_industries' => 'array',
            'target_cities'     => 'array',
            'deadline'          => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(GoalMilestone::class, 'goal_id')->orderBy('order_position');
    }

    // Hitung persentase progress secara dinamis
    public function getProgressPercentAttribute(): int
    {
        if ($this->target_application_count === 0) return 0;
        return min(100, (int) round($this->current_count / $this->target_application_count * 100));
    }
}
