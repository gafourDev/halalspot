<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
    ];

    public function role()
    {   
        // Define a many-to-one relationship with the Role model
        // This means a user belongs to one role
        // and a role can have many users associated with it
        return $this->belongsTo(\App\Models\Role::class);
    }

    public function restaurants()
    {
        // Define a one-to-many relationship with the Restaurant model
        // This means a user can own many restaurants
        // and a restaurant belongs to one user (owner)
        // This is useful for owners to manage their restaurants
        // and for admins to view all restaurants owned by users
        return $this->hasMany(Restaurant::class);
    }

    public function isAdmin()
    {   
        // Check if the user's role is ADMIN
        // This method is used to determine if the user has admin privileges
        // It returns true if the user is an admin, false otherwise
        return $this->role_id === Role::ADMIN;
    }

    public function isOwner()
    {
        // Check if the user's role is OWNER
        // This method is used to determine if the user has owner privileges
        // It returns true if the user is an owner, false otherwise
        return $this->role_id === Role::OWNER;
    }

    public function isUser()
    {
        // Check if the user's role is USER
        // This method is used to determine if the user has regular user privileges
        // It returns true if the user is a regular user, false otherwise
        return $this->role_id === Role::USER;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
