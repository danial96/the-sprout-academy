<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandardTShirtOrder extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'location',
        'size',
        'colors',
        'special_instructions',
    ];

    protected $casts = [
        'colors' => 'array',
    ];
}

