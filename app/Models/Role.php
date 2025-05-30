<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{   
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];
    public const ADMIN = 1;
    public const OWNER = 2;
    public const USER = 3;

    public function users()
    {   
        // Define a one-to-many relationship with the User model
        // This means a role can have many users associated with it
        return $this->hasMany(User::class);

    }
}
