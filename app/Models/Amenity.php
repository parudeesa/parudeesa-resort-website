<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = ['name', 'description', 'price', 'pricing_type', 'status', 'is_premium', 'image', 'condition_note', 'property_assignment'];

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }
}
