<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentApplication extends Model
{
    protected $fillable = [
        'position',
        'location',
        'start_date',
        'resume_path',
        'salary_dollars',
        'salary_cents',
        'first_name',
        'last_name',
        'email',
        'phone',
    ];

    protected $casts = [
        'start_date' => 'date',
    ];
}
