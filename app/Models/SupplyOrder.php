<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyOrder extends Model
{
    protected $fillable = [
        'location',
        'order_items',
        'other',
    ];

    protected $casts = [
        'order_items' => 'array',
    ];
}
