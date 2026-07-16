<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'address',
        'phone',
        'fax',
        'email',
        'hours_of_operation',
        'google_maps_address',
        'virtual_tour_image',
        'virtual_tour_label',
        'home_page_image',
        'show_schedule_tour',
        'show_enroll',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    public function getShowScheduleTourAttribute($value): bool
    {
        return $value === null ? true : (bool) $value;
    }

    public function getShowEnrollAttribute($value): bool
    {
        return $value === null ? true : (bool) $value;
    }

    /**
     * Get active locations ordered by display order
     */
    public static function active()
    {
        return static::where('is_active', true)->orderBy('display_order')->orderBy('name');
    }
}
