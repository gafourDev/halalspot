<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    // Specify which fields are mass assignable
    protected $fillable = [
        'name',
        'description',
        'address',
        'latitude',
        'longitude',
        'halal_certification',
        'cuisine_type',
        'price_range',
        'phone',
        'image',
    ];

    // Define the relationship with the User model
    // This method defines a many-to-one relationship
    // A restaurant belongs to one user (owner)
    public function user()
    {   
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(RestaurantImage::class);
    }

    // Example relationship: A restaurant has many menus
    public function menus()
    {
        // This method defines a one-to-many relationship
        // A restaurant can have many menus
        // and a menu belongs to one restaurant
        return $this->hasMany(Menu::class);
    }
}
