<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'email', 'event_type', 'event_date', 'event_time',
        'guests', 'need_stay', 'property_id', 'stay_guests', 'num_rooms', 'room_type', 
        'check_in', 'check_out', 'stay_duration', 'event_duration', 'budget', 'requirements', 'notes', 'status'
    ];

    protected $casts = [
        'event_date' => 'date',
        'requirements' => 'array',
    ];
}
