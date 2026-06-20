<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Alumni extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'graduation_year',
        'degree',
        'department',
        'company',
        'job_title',
        'location',
        'linkedin_url',
        'bio',
        'photo_path',
        'last_contacted_at',
        'is_mentor',
        'available_for_internships',
    ];

    protected $casts = [
        'graduation_year' => 'integer',
        'last_contacted_at' => 'date',
        'is_mentor' => 'boolean',
        'available_for_internships' => 'boolean',
    ];

    public function mentorships(): HasMany
    {
        return $this->hasMany(Mentorship::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo_path) {
            return asset('storage/' . $this->photo_path);
        }
        $initials = urlencode(strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1)));
        return "https://ui-avatars.com/api/?name={$initials}&background=6366f1&color=fff&size=128";
    }
}
