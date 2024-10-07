<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'admin_id', 'position', 'status', 'date_hired'
    ];

    // A staff member belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A staff member belongs to an admin
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // A staff member can have many predictions
    public function predictions()
    {
        return $this->hasMany(Prediction::class);
    }
}
