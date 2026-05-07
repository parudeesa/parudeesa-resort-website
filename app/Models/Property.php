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
        'gallery_images',
        'highlights',
        'phone',
        'admin_id'
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'highlights' => 'array',
        'amenity_data' => 'array',
    ];

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }
}
