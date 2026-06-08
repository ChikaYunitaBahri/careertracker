<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class RecruitmentStatus extends Model
{
    protected $fillable = ['slug', 'label', 'color', 'order_position', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'status_id');
    }
}
