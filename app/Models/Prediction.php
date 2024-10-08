<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'farm_id', 'serre_id','plaque_id', 'result' 
    ];

    // A prediction belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A prediction belongs to a farm
    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    // A prediction belongs to a serre
    public function serre()
    {
        return $this->belongsTo(Serre::class);
    }

    // A prediction can have many images
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
