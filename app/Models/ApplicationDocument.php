<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ApplicationDocument extends Model
{
    protected $fillable = [
        'application_id', 'user_id', 'document_type',
        'file_name', 'file_path', 'file_size', 'mime_type',
    ];

    // Accessor: URL file yang bisa diakses
    public function getFileUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
