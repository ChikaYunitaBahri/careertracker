<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'company_id', 'status_id', 'position_name', 'company_name',
        'applied_date', 'job_post_url', 'source', 'salary_min', 'salary_max',
        'job_type', 'work_location_type', 'location', 'referral_code',
        'initial_notes', 'is_archived',
    ];

    protected function casts(): array
    {
        return [
            'applied_date' => 'date',
            'is_archived'  => 'boolean',
        ];
    }

    // Relasi BelongsTo
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(RecruitmentStatus::class, 'status_id');
    }

    // Relasi HasMany
    public function notes(): HasMany
    {
        return $this->hasMany(ApplicationNote::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ApplicationActivity::class)->latest();
    }

    public function calendarEvents(): HasMany
    {
        return $this->hasMany(CalendarEvent::class);
    }

    // Scope helper
    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }
}
