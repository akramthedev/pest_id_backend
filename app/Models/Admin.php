<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'company_name', 'company_email', 'company_mobile'
    ];

    // An admin belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An admin can have many staff members
    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }

    // A staff member can have many predictions
    public function predictions()
    {
        return $this->hasMany(Prediction::class);
    }
    
}
