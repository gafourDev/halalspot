<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantImage extends Model
{
    // Specify which fields are mass assignable
    protected $fillable = [
        'restaurant_id',
        'image_path',
        'is_featured',
    ];

    // Define the relationship with the Restaurant model
    public function restaurant()
    {
        // This method defines a many-to-one relationship
        // A restaurant image belongs to one restaurant
        // and a restaurant can have many images associated with it
        return $this->belongsTo(Restaurant::class);
    }
}
