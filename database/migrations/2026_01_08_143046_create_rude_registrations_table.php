<?php
// database/migrations/2026_01_09_000000_create_rude_registrations_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rude_registrations', function (Blueprint $table) {
            $table->id();
            
            // --- I. DATOS DE LA UNIDAD EDUCATIVA ---
            $table->string('ue_codigo_sie')->default('80980000'); // Ajustar al SIE del Ismael Vásquez
            $table->string('ue_nombre')->default('UNIDAD EDUCATIVA ISMAEL VÁSQUEZ');

            // --- II. DATOS DE LA O EL ESTUDIANTE ---
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nombres');
            $table->string('pais_nacimiento')->default('BOLIVIA');
            $table->string('departamento_nacimiento');
            $table->string('provincia_nacimiento');
            $table->string('localidad_nacimiento');
            
            // Certificado de Nacimiento
            $table->string('cert_oficialia')->nullable();
            $table->string('cert_libro')->nullable();
            $table->string('cert_partida')->nullable();
            $table->string('cert_folio')->nullable();
            
            $table->date('fecha_nacimiento');
            $table->enum('sexo', ['M', 'F']);
            
            // Documentos Clave
            $table->string('codigo_rude')->unique(); // VALIDACIÓN DE NO REPETICIÓN
            $table->string('documento_identidad')->unique();
            $table->string('documento_complemento')->nullable();
            $table->string('documento_expedido')->nullable();
            
            // Discapacidad
            $table->boolean('tiene_discapacidad')->default(false);
            $table->string('discapacidad_registro_ibc')->nullable();
            $table->string('discapacidad_tipo')->nullable(); // Mental, Motora, etc.
            $table->string('discapacidad_grado')->nullable(); // Leve, Moderado, Grave

            // --- III. DIRECCIÓN ACTUAL ---
            $table->string('dir_departamento');
            $table->string('dir_provincia');
            $table->string('dir_municipio');
            $table->string('dir_localidad');
            $table->string('dir_zona');
            $table->string('dir_calle');
            $table->string('dir_numero')->nullable();
            $table->string('dir_telefono_fijo')->nullable();
            $table->string('dir_celular'); // Obligatorio para contacto

            // --- IV. ASPECTOS SOCIOECONÓMICOS ---
            // 4.1 Idioma y Cultura
            $table->string('socio_idioma_ninez');
            $table->string('socio_idioma_frecuente_1');
            $table->string('socio_idioma_frecuente_2')->nullable();
            $table->string('socio_nacion_originaria'); // Quechua, Aymara, Mestizo, etc.
            
            // 4.2 Salud
            $table->string('socio_salud_centro'); // Caja, Centro de Salud, Privado, etc.
            $table->integer('socio_salud_veces_enfermo')->nullable();
            $table->boolean('socio_salud_seguro')->default(false);
            
            // 4.3 Servicios Básicos
            $table->string('socio_agua_procedencia'); // Cañería red pública, Pozo, etc.
            $table->boolean('socio_energia_electrica')->default(true);
            $table->string('socio_wc_tipo'); // Alcantarillado, Pozo ciego, etc.
            
            // 4.4 Acceso a Internet
            $table->string('socio_internet_lugar')->nullable(); // Casa, Celular, No tiene
            $table->string('socio_internet_frecuencia')->nullable();

            // 4.5 Actividad Laboral
            $table->boolean('socio_trabaja')->default(false);
            $table->string('socio_trabajo_actividad')->nullable(); // Agricultura, Vendedor, etc.
            $table->string('socio_trabajo_dias')->nullable();
            $table->string('socio_trabajo_turno')->nullable();

            // 4.6 Transporte
            $table->string('socio_transporte_tipo'); // A pie, Minibus, etc.
            $table->string('socio_transporte_tiempo'); // Menos de media hora, etc.

            // --- V. DATOS DEL PADRE, MADRE O TUTOR ---
            // Padre
            $table->string('padre_ci')->nullable();
            $table->string('padre_apellidos')->nullable();
            $table->string('padre_nombres')->nullable();
            $table->string('padre_ocupacion')->nullable();
            $table->string('padre_grado_instruccion')->nullable();
            
            // Madre
            $table->string('madre_ci')->nullable();
            $table->string('madre_apellidos')->nullable();
            $table->string('madre_nombres')->nullable();
            $table->string('madre_ocupacion')->nullable();
            $table->string('madre_grado_instruccion')->nullable();

            // Tutor (si aplica)
            $table->string('tutor_ci')->nullable();
            $table->string('tutor_apellidos')->nullable();
            $table->string('tutor_nombres')->nullable();
            $table->string('tutor_parentesco')->nullable();

            // --- ANEXOS DIGITALES (FOTOS) ---
            $table->string('img_estudiante_ci_anverso'); // Obligatorio
            $table->string('img_estudiante_ci_reverso')->nullable();
            $table->string('img_tutor_ci_anverso'); // Obligatorio (del responsable)
            $table->string('img_tutor_ci_reverso')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rude_registrations');
    }
};