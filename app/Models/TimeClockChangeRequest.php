<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeClockChangeRequest extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'location',
        'date_to_be_changed',
        'clock_in_time',
        'clock_out_for_lunch',
        'clock_in_from_lunch',
        'clock_out_time',
        'reason_for_change',
        'supervisor_first_name',
        'supervisor_last_name',
    ];

    protected $casts = [
        'date_to_be_changed' => 'date',
    ];
}

