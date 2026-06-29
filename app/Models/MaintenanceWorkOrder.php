<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceWorkOrder extends Model
{
    protected $fillable = [
        'todays_date',
        'completion_date',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'location',
        'description',
        'file_path',
        'area_repair',
    ];

    protected $casts = [
        'todays_date' => 'date',
        'completion_date' => 'date',
    ];
}
