<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    protected $fillable = [
        'alumni_id',
        'donor_name',
        'donor_email',
        'amount',
        'currency',
        'donated_at',
        'purpose',
        'status',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'donated_at' => 'date',
    ];

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class);
    }
}
