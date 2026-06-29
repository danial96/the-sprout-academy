<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnrollmentAddress extends Model
{
    protected $fillable = [
        'enrollment_id',
        'enrollment_contact_id',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip_code',
        'is_physical',
        'is_mailing',
    ];

    protected $casts = [
        'is_physical' => 'boolean',
        'is_mailing' => 'boolean',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(EnrollmentContact::class, 'enrollment_contact_id');
    }
}
