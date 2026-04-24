<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'check_in',
        'check_out',
        'guests',
        'property_id',
        'amount',
        'status',
        'event_type',
        'package_name',
        'amenities'
    ];

    protected $casts = [
        'amenities' => 'array',
        'check_in' => 'date',
        'check_out' => 'date',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}