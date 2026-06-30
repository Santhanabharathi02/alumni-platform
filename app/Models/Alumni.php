<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Schema;

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

    public static function searchableColumns(): array
    {
        $table = (new self())->getTable();
        $columns = [];

        foreach (['first_name', 'last_name', 'name', 'email', 'company', 'job_title'] as $column) {
            if (Schema::hasColumn($table, $column)) {
                $columns[] = $column;
            }
        }

        return $columns;
    }

    public static function nameSortColumns(): array
    {
        $table = (new self())->getTable();

        if (Schema::hasColumn($table, 'last_name') && Schema::hasColumn($table, 'first_name')) {
            return ['last_name', 'first_name'];
        }

        if (Schema::hasColumn($table, 'name')) {
            return ['name'];
        }

        if (Schema::hasColumn($table, 'email')) {
            return ['email'];
        }

        return ['id'];
    }

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
        $firstName = (string) $this->getAttribute('first_name');
        $lastName = (string) $this->getAttribute('last_name');
        $fullName = trim($firstName.' '.$lastName);

        if ($fullName !== '') {
            return $fullName;
        }

        $name = trim((string) $this->getAttribute('name'));

        return $name !== '' ? $name : (string) $this->getAttribute('email');
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo_path) {
            return asset('storage/' . $this->photo_path);
        }

        $fullName = $this->full_name;
        $parts = preg_split('/\s+/', trim($fullName)) ?: [];
        $initials = '';

        foreach (array_slice($parts, 0, 2) as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
        }

        if ($initials === '') {
            $initials = strtoupper(substr((string) $this->getAttribute('email'), 0, 2));
        }

        $initials = urlencode($initials);

        return "https://ui-avatars.com/api/?name={$initials}&background=6366f1&color=fff&size=128";
    }
}
