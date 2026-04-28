<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'location',
        'image_url',
        'phone'
    ];

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }
}