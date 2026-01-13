<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RudeEstudiante extends Model
{
    use SoftDeletes;
    
    protected $table = 'rude_estudiantes';
    protected $guarded = []; // Habilitar asignación masiva

    // Relaciones
    public function direccion() {
        return $this->hasOne(RudeDireccion::class, 'estudiante_id');
    }

    public function socioeconomico() {
        return $this->hasOne(RudeSocioeconomico::class, 'estudiante_id');
    }

    public function tutores() {
        return $this->hasMany(RudeTutor::class, 'estudiante_id');
    }
    
    public function discapacidad() {
        return $this->hasOne(RudeDiscapacidad::class, 'estudiante_id');
    }
}