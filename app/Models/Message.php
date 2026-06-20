<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'subject',
        'body',
        'is_read',
        'admin_reply',
        'replied_at',
        'reply_read',
        'alumni_reply',
        'alumni_replied_at',
        'admin_read_reply',
    ];

    protected $casts = [
        'is_read'          => 'boolean',
        'reply_read'       => 'boolean',
        'replied_at'       => 'datetime',
        'alumni_replied_at'=> 'datetime',
        'admin_read_reply' => 'boolean',
    ];

    /** The user who sent the message (alumni or admin) */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /** The intended recipient (set when admin initiates the message) */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    /** True when admin started the thread */
    public function isAdminInitiated(): bool
    {
        return !is_null($this->to_user_id);
    }
}
