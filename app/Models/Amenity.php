<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = ['name', 'description', 'price', 'pricing_type', 'status', 'is_premium', 'image_url', 'condition_note'];

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }
}
