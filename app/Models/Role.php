<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public const ADMIN = 0;
    public const OWNER = 1;
    public const USER = 2;

    public function users()
    {   
        // Define a one-to-many relationship with the User model
        // This means a role can have many users associated with it
        return $this->hasMany(User::class);

    }
}
