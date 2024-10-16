<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;  
use Illuminate\Auth\Authenticatable;  

class User extends Model implements AuthenticatableContract  
{
    use HasFactory, HasApiTokens, Authenticatable;  

    protected $fillable = [
        'fullName',
        'email', 
        'password', 
        'mobile', 
        "image", 
        'type', 
        'canAccess', 
        'isEmailVerified', 
        'is_first_time_connected',
        'historique_notice',
        "mesfermes_notice", 
        "mespersonels_notice", 
        "dashboard_notice",
        "liste_users_notice",
        "nouvelle_demande_notice",
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
