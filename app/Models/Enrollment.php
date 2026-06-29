<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrollment extends Model
{
    protected $fillable = [
        'location',
        'referrer',
        'status',
        'current_step',
    ];

    protected $casts = [
        'current_step' => 'integer',
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(EnrollmentContact::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(EnrollmentChild::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(EnrollmentAddress::class);
    }

    public function phones(): HasMany
    {
        return $this->hasMany(EnrollmentPhone::class);
    }

    public function primaryContact()
    {
        return $this->hasOne(EnrollmentContact::class)->where('is_primary', true);
    }
}
