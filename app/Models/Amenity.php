<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = ['name', 'description', 'price', 'pricing_type', 'status'];

    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }
}
