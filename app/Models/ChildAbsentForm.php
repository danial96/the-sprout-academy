<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildAbsentForm extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'child_first_name',
        'child_last_name',
        'phone_number',
        'location',
        'date_submission',
        'date_of_expected_return',
        'reason',
    ];

    protected $casts = [
        'date_submission' => 'date',
        'date_of_expected_return' => 'date',
    ];
}
