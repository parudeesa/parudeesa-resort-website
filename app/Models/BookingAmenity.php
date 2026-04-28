<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingAmenity extends Model
{
    protected $fillable = [
        'booking_id',
        'amenity_id',
        'quantity',
        'unit_price',
        'amount',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function amenity()
    {
        return $this->belongsTo(Amenity::class);
    }
}
