<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RudePadres extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function estudiante()
    {
        return $this->belongsTo(RudeEstudiante::class); 
    }
}
