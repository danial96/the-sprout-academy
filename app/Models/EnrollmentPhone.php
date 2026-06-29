<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnrollmentPhone extends Model
{
    protected $fillable = [
        'enrollment_id',
        'enrollment_contact_id',
        'type',
        'area_code',
        'phone_number',
        'phone_order',
    ];

    protected $casts = [
        'phone_order' => 'integer',
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
