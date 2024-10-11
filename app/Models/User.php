<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract; // Import the Authenticatable contract
use Illuminate\Auth\Authenticatable; // Import the Authenticatable trait

class User extends Model implements AuthenticatableContract // Implement the Authenticatable contract
{
    use HasFactory, HasApiTokens, Authenticatable; // Use the Authenticatable trait

    protected $fillable = [

    'fullName', 'email', 'password', 'mobile', "image", 'type', 'canAccess', 'isEmailVerified'
    ];

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }

    public function predictions()
    {
        return $this->hasMany(Prediction::class);
    }

    public function farms()
    {
        return $this->hasMany(Farm::class);
    }
    
}
