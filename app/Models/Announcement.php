<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'body',
        'category',
        'is_published',
        'publish_at',
        'expires_at',
        'created_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'publish_at' => 'date',
        'expires_at' => 'date',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(AnnouncementComment::class)->latest();
    }
}
