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
        'payment_status',
        'event_type',
        'package_name',
        'notes',
        'google_event_id',
        'amenities',
        'amenity_total',
        'base_amount',
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

    public function bookingAmenities()
    {
        return $this->hasMany(BookingAmenity::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
