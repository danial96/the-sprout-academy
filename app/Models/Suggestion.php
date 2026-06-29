<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'subject',
        'description',
    ];
}

