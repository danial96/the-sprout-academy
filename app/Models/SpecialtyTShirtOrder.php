<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialtyTShirtOrder extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'location',
        'size',
        'themes',
        'special_instructions',
    ];

    protected $casts = [
        'themes' => 'array',
    ];
}

