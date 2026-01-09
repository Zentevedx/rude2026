namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RudeRegistration extends Model
{
    protected $fillable = [
        'current_step', 'gestion_escolar', 'estado_revision', 'cod_sie_colegio',
        'apellido_paterno', 'apellido_materno', 'nombres', 'pais_nac', 'depto_nac',
        'provincia_nac', 'localidad_nac', 'oficialia_n', 'libro_n', 'partida_n',
        'folio_n', 'fecha_nacimiento', 'sexo', 'codigo_rude', 'ci_estudiante',
        'ci_complemento', 'ci_expedido', 'tiene_discapacidad', 'n_registro_discapacidad',
        'tipo_discapacidad', 'grado_discapacidad', 'dir_depto', 'dir_provincia',
        'dir_municipio', 'dir_localidad', 'dir_zona', 'dir_calle', 'dir_n_vivienda',
        'telefono_fijo', 'celular_contacto', 'idioma_niñez', 'idioma_frecuente',
        'nacion_autoidentificacion', 'centro_salud_atencion', 'servicios_basicos',
        'tiene_internet', 'medio_transporte_colegio', 'ci_tutor', 'apellidos_tutor',
        'nombres_tutor', 'parentesco_tutor', 'instruccion_tutor', 'ocupacion_tutor',
        'path_foto_estudiante', 'path_ci_anverso_est', 'path_ci_reverso_est',
        'path_ci_anverso_tutor', 'path_ci_reverso_tutor'
    ];

    protected $casts = [
        'servicios_basicos' => 'array', // Maneja los checks de servicios automáticamente
        'tiene_discapacidad' => 'boolean',
        'centro_salud_atencion' => 'boolean',
        'tiene_internet' => 'boolean',
    ];
}