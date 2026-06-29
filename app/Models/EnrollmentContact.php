<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EnrollmentContact extends Model
{
    protected $fillable = [
        'enrollment_id',
        'first_name',
        'middle_initial',
        'last_name',
        'gender',
        'date_of_birth',
        'profile_image',
        'relationship_type',
        'lives_with',
        'is_emergency_contact',
        'is_authorized_pickup',
        'is_primary',
        'contact_order',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'lives_with' => 'boolean',
        'is_emergency_contact' => 'boolean',
        'is_authorized_pickup' => 'boolean',
        'is_primary' => 'boolean',
        'contact_order' => 'integer',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(EnrollmentAddress::class);
    }

    public function phones(): HasMany
    {
        return $this->hasMany(EnrollmentPhone::class);
    }
}
