<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'location', 'size' 
    ];

    // A farm belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A farm can have many greenhouses (serres)
    public function serres()
    {
        return $this->hasMany(Serre::class);
    }

    // A farm can have many predictions
    public function predictions()
    {
        return $this->hasMany(Prediction::class);
    }
}
