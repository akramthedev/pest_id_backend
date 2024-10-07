<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'prediction_id', 'name', 'size', 'class_A', 'class_B', 'class_C' 
    ];

    
    public function prediction()
    {
        return $this->belongsTo(Prediction::class);
    }
}
