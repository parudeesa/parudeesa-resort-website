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
        'amount',
        'status',
        'property_id',
        'event_type',
        'package_name',
        'amenities',
        'payment_status',
        'notes',
        'created_by',
        'google_event_id'
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