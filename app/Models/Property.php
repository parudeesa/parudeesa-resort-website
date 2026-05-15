<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'name',
        'description',
        'weekday_price',
        'weekday_tier2_price',
        'weekend_price',
        'capacity',
        'status',
        'type',
        'location',
        'image',
        'gallery_images',
        'highlights',
        'phone',
        'admin_id',
        'accommodation',
        'outdoor_spaces'
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'highlights' => 'array',
        'amenity_data' => 'array',
        'accommodation' => 'array',
        'outdoor_spaces' => 'array',
        'status' => 'boolean',
    ];

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }
}
