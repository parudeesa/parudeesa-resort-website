<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'order_id',
        'payment_id',
        'signature',
        'status',
        'failure_reason',
        'amount'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
