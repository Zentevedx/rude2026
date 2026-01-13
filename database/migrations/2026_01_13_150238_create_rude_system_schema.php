<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. TABLA PRINCIPAL: ESTUDIANTES (Secciones I y II)
        Schema::create('rude_estudiantes', function (Blueprint $table) {
            $table->id();
            
            // I. DATOS DE LA UNIDAD EDUCATIVA
            $table->string('codigo_sie')->nullable();
            
            // NUEVO: Año de escolaridad
            $table->string('anio_escolaridad')->nullable(); // Ej: "1° DE PRIMARIA"

            // II. DATOS DE LA O EL ESTUDIANTE
            // a. Apellidos y Nombres
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nombres');
            
            // b. Lugar de Nacimiento
            $table->string('pais_nacimiento')->default('Bolivia');
            $table->string('departamento_nacimiento')->nullable();
            $table->string('provincia_nacimiento')->nullable();
            $table->string('localidad_nacimiento')->nullable();
            
            // c. Certificado de Nacimiento
            $table->string('cert_oficialia')->nullable();
            $table->string('cert_libro')->nullable();
            $table->string('cert_partida')->nullable();
            $table->string('cert_folio')->nullable();
            
            // d. Fecha de Nacimiento
            $table->date('fecha_nacimiento');
            
            // e. Sexo
            $table->enum('sexo', ['MASCULINO', 'FEMENINO']);
            
            // f. Código RUDE
            $table->string('codigo_rude')->unique()->nullable();
            
            // g. Discapacidad Check
            $table->boolean('tiene_discapacidad')->default(false);
            
            // h. Carnet de Identidad y Archivos
            $table->string('carnet_identidad')->unique()->index();
            $table->string('complemento')->nullable();
            $table->string('expedido')->nullable();

            // NUEVO: Archivos CI Estudiante
            $table->string('file_ci_anverso')->nullable();
            $table->string('file_ci_reverso')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // 2. DISCAPACIDADES (Sección IV.g - Relacionado si tiene_discapacidad = true)
        Schema::create('rude_discapacidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('rude_estudiantes')->onDelete('cascade');
            
            // IV.g.i Tipos y Grados
            // Guardamos el grado (Leve, Grave, etc) o null si no aplica
            $table->string('discapacidad_auditiva')->nullable(); // Grado
            $table->string('discapacidad_visual')->nullable();
            $table->string('discapacidad_intelectual')->nullable();
            $table->string('discapacidad_fisica')->nullable();
            $table->string('discapacidad_mental')->nullable();
            $table->string('discapacidad_autista')->nullable(); // Tipo 1, 2, 3
            
            // IV.g.ii Origen
            $table->enum('origen_discapacidad', ['NACIMIENTO', 'ADQUIRIDA'])->nullable();
            
            // IV.g.iii Dificultades Aprendizaje (Si no tiene discapacidad)
            // Guardamos como booleans o JSON. Usaremos columnas simples.
            $table->boolean('dificultad_lectura')->default(false);
            $table->boolean('dificultad_razonamiento')->default(false);
            $table->boolean('dificultad_calculo')->default(false);
            $table->boolean('dificultad_pedagogico')->default(false);

            $table->timestamps();
        });

        // 3. DIRECCIONES (Sección III)
        Schema::create('rude_direcciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('rude_estudiantes')->onDelete('cascade');
            
            $table->string('departamento');
            $table->string('provincia');
            $table->string('municipio'); // Sección/Municipio
            $table->string('localidad'); // Localidad/Comunidad
            $table->string('zona'); // Zona/Villa
            $table->string('avenida_calle');
            $table->string('numero_vivienda')->nullable();
            $table->string('telefono_fijo')->nullable();
            $table->string('celular_contacto');
            
            $table->timestamps();
        });

        // 4. SOCIOECONOMICOS (Sección IV a-f)
        Schema::create('rude_socioeconomicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('rude_estudiantes')->onDelete('cascade');
            
            // a. Idioma y Cultura
            $table->string('idioma_ninez');
            $table->string('idioma_frecuente_1');
            $table->string('idioma_frecuente_2')->nullable();
            $table->string('idioma_frecuente_3')->nullable();
            $table->string('nacion_originaria')->default('NINGUNO');
            
            // Salud
            $table->boolean('existe_centro_salud'); // IV.a.iv.1
            
            // IV.a.v ¿Dónde se atendió el año pasado? (Multiple choice -> stored as distinct booleans)
            $table->boolean('salud_sus')->default(false);
            $table->boolean('salud_caja')->default(false);
            $table->boolean('salud_publico')->default(false);
            $table->boolean('salud_privado')->default(false);
            $table->boolean('salud_vivienda')->default(false);
            $table->boolean('salud_tradicional')->default(false);
            $table->boolean('salud_automedicacion')->default(false);
            
            $table->string('frecuencia_salud'); // IV.a.vi
            $table->boolean('tiene_seguro_salud'); // IV.a.vii

            // b. Servicios Básicos
            $table->boolean('acceso_agua'); // IV.b.i
            $table->boolean('tiene_bano'); // IV.b.ii
            $table->boolean('tiene_alcantarillado'); // IV.b.iii
            $table->boolean('usa_electricidad'); // IV.b.iv
            $table->boolean('servicio_basura'); // IV.b.v
            $table->string('propiedad_vivienda'); // IV.b.vi (Propia, Alquilada...)

            // c. Internet
            $table->string('acceso_internet_lugar'); // IV.c.i enum like string
            $table->string('frecuencia_internet'); // IV.c.ii

            // d. Actividad Laboral
            $table->boolean('trabajo_gestion_pasada'); // IV.d.i
            $table->string('trabajo_actividad')->nullable(); // IV.d.ii
            $table->string('trabajo_turnos')->nullable(); // IV.d.iii
            $table->string('trabajo_frecuencia')->nullable(); // IV.d.iv
            $table->boolean('trabajo_pago')->nullable(); // IV.d.v

            // e. Medio de Transporte
            $table->string('medio_transporte'); // IV.e.i
            $table->string('tiempo_transporte'); // IV.e.ii

            // f. Abandono Escolar
            $table->boolean('abandono_gestion_pasada'); // IV.f.i
            $table->string('abandono_razon')->nullable(); // IV.f.ii

            $table->timestamps();
        });

        // 5. PADRES Y TUTORES (Sección V)
        Schema::create('rude_padres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('rude_estudiantes')->onDelete('cascade');
            
            // a. Vive con
            $table->string('vive_con'); // Padre y Madre, Solo Padre, etc.

            // b. Datos del PADRE
            $table->string('padre_ci')->nullable();
            $table->string('padre_paterno')->nullable();
            $table->string('padre_materno')->nullable();
            $table->string('padre_nombres')->nullable();
            $table->string('padre_idioma')->nullable();
            $table->string('padre_ocupacion')->nullable();
            $table->string('padre_grado')->nullable();
            $table->date('padre_fecha_nacimiento')->nullable();

            // c. Datos de la MADRE
            $table->string('madre_ci')->nullable();
            $table->string('madre_paterno')->nullable();
            $table->string('madre_materno')->nullable();
            $table->string('madre_nombres')->nullable();
            $table->string('madre_idioma')->nullable();
            $table->string('madre_ocupacion')->nullable();
            $table->string('madre_grado')->nullable();
            $table->date('madre_fecha_nacimiento')->nullable();

            // d. Datos del TUTOR
            $table->string('tutor_ci')->nullable();
            $table->string('tutor_paterno')->nullable();
            $table->string('tutor_materno')->nullable();
            $table->string('tutor_nombres')->nullable();
            $table->string('tutor_idioma')->nullable();
            $table->string('tutor_ocupacion')->nullable();
            $table->string('tutor_grado')->nullable();
            $table->string('tutor_parentesco')->nullable();
            $table->date('tutor_fecha_nacimiento')->nullable();

            // NUEVO: Archivos CI Padre/Tutor
            // Almacenamos solo un juego de archivos para el apoderado "principal"
            $table->string('file_ci_anverso')->nullable();
            $table->string('file_ci_reverso')->nullable();

            // e. Datos del TUTOR EXTRAORDINARIO (Opcional según form)
            // Se usa si el tutor es institucional o algo así
            $table->string('extra_ci')->nullable();
            $table->string('extra_paterno')->nullable();
            $table->string('extra_materno')->nullable();
            $table->string('extra_nombres')->nullable();
            $table->string('extra_cargo')->nullable();
            $table->string('extra_institucion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rude_padres');
        Schema::dropIfExists('rude_socioeconomicos');
        Schema::dropIfExists('rude_direcciones');
        Schema::dropIfExists('rude_discapacidades');
        Schema::dropIfExists('rude_estudiantes');
    }
};