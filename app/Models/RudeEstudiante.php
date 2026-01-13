<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RudeEstudiante extends Model
{
    use SoftDeletes;
    
    protected $table = 'rude_estudiantes';
    protected $guarded = [];

    public function direccion() {
        return $this->hasOne(RudeDireccion::class, 'estudiante_id');
    }

    public function socioeconomico() {
        return $this->hasOne(RudeSocioeconomico::class, 'estudiante_id');
    }

    public function padres() {
        return $this->hasOne(RudePadres::class, 'estudiante_id');
    }
    
    public function discapacidad() {
        return $this->hasOne(RudeDiscapacidad::class, 'estudiante_id');
    }
}