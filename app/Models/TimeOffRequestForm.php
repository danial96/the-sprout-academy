<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeOffRequestForm extends Model
{
    protected $table = 'time_off_requests';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'location',
        'todays_date',
        'start_date',
        'end_date',
        'paid_unpaid',
        'reason',
        'director_signature',
        'status',
        'approved_by',
        'rejected_by',
        'approved_at',
        'rejected_at',
        'rejection_reason',
    ];

    /**
     * Get the user that owns the time off request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'todays_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];
}
