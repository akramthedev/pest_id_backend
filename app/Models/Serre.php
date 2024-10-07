<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serre extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id', 'name', 'location', 'size' 
    ];

    // A serre belongs to a farm
    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    // A serre can have many predictions
    public function predictions()
    {
        return $this->hasMany(Prediction::class);
    }

    
}
