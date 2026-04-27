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
        'google_event_id',
        'base_price',
        'amenities_total',
        'grand_total',
        'selected_amenities_json'
    ];

    protected $casts = [
        'amenities' => 'array',
        'selected_amenities_json' => 'array',
        'check_in' => 'date',
        'check_out' => 'date',
        'base_price' => 'decimal:2',
        'amenities_total' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}