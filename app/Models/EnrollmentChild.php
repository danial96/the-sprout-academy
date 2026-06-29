<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnrollmentChild extends Model
{
    protected $fillable = [
        'enrollment_id',
        'first_name',
        'middle_initial',
        'last_name',
        'gender',
        'date_of_birth',
        'profile_image',
        'child_order',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'child_order' => 'integer',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}
