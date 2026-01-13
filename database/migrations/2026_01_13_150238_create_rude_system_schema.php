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
        // 1. TABLA PRINCIPAL: ESTUDIANTES (Padre)
        Schema::create('rude_estudiantes', function (Blueprint $table) {
            $table->id(); 
            $table->string('codigo_rude')->unique()->nullable();
            
            // Identificación
            $table->string('carnet_identidad', 20)->unique()->index(); 
            $table->string('complemento', 5)->nullable();
            $table->string('expedido', 5)->nullable(); 
            
            // Nombres
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nombres');
            
            // Nacimiento
            $table->string('pais_nacimiento')->default('Bolivia');
            $table->string('departamento_nacimiento')->nullable();
            $table->string('provincia_nacimiento')->nullable();
            $table->string('localidad_nacimiento')->nullable();
            $table->date('fecha_nacimiento');
            $table->enum('sexo', ['M', 'F']);
            
            // Registro Civil
            $table->string('oficialia')->nullable();
            $table->string('libro')->nullable();
            $table->string('partida')->nullable();
            $table->string('folio')->nullable();
            
            // Discapacidad General
            $table->boolean('tiene_discapacidad')->default(false);
            $table->string('registro_discapacidad')->nullable(); // N° Carnet IBC
            
            // Archivos (Rutas de almacenamiento)
            $table->string('file_ci_anverso_path')->nullable();
            $table->string('file_ci_reverso_path')->nullable();
            $table->string('file_certificado_nacimiento_path')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // 2. DISCAPACIDADES (Hija)
        Schema::create('rude_discapacidades', function (Blueprint $table) {
            $table->id();
            // Relación con Estudiante
            $table->foreignId('estudiante_id')->constrained('rude_estudiantes')->onDelete('cascade');
            
            $table->boolean('auditiva')->default(false);
            $table->boolean('visual')->default(false);
            $table->boolean('intelectual')->default(false);
            $table->boolean('fisico_motora')->default(false);
            $table->boolean('psiquica_mental')->default(false);
            $table->boolean('autismo')->default(false);
            $table->boolean('multiple')->default(false);
            
            $table->timestamps();
        });

        // 3. DIRECCIONES (Hija)
        Schema::create('rude_direcciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('rude_estudiantes')->onDelete('cascade');
            
            $table->string('departamento');
            $table->string('provincia');
            $table->string('municipio');
            $table->string('localidad');
            $table->string('zona');
            $table->string('avenida_calle');
            $table->string('numero_vivienda')->nullable();
            $table->string('telefono_fijo')->nullable();
            $table->string('celular_contacto');
            
            $table->timestamps();
        });

        // 4. SOCIOECONOMICOS (Hija)
        Schema::create('rude_socioeconomicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('rude_estudiantes')->onDelete('cascade');
            
            $table->string('idioma_ninez');
            $table->string('idioma_frecuente_1');
            $table->string('nacion_originaria')->default('Ninguno');
            
            $table->boolean('existe_centro_salud')->default(true);
            $table->boolean('tiene_seguro_salud')->default(false);
            
            $table->boolean('tiene_agua_potable')->default(true);
            $table->boolean('tiene_electricidad')->default(true);
            $table->boolean('tiene_alcantarillado')->default(true);
            
            $table->enum('acceso_internet', ['Domicilio', 'Celular', 'Publico', 'No accede'])->default('Celular');
            
            $table->boolean('trabajo_estudiante')->default(false);
            $table->string('actividad_laboral')->nullable();
            
            $table->enum('medio_transporte', ['A pie', 'Vehiculo publico', 'Vehiculo particular', 'Otro'])->default('A pie');
            $table->string('tiempo_transporte')->default('Menos de 30 min');
            
            $table->timestamps();
        });

        // 5. TUTORES (Hija)
        Schema::create('rude_tutores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('rude_estudiantes')->onDelete('cascade');
            
            $table->enum('parentesco', ['PADRE', 'MADRE', 'TUTOR']);
            $table->string('carnet_identidad');
            $table->string('complemento', 5)->nullable();
            $table->string('expedido', 5)->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nombres');
            
            $table->string('idioma_frecuente')->nullable();
            $table->string('ocupacion_laboral')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            
            // Archivos del Tutor
            $table->string('file_ci_anverso_path')->nullable();
            $table->string('file_ci_reverso_path')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // El orden de borrado debe ser INVERSO a la creación para no romper las llaves foráneas
        Schema::dropIfExists('rude_tutores');
        Schema::dropIfExists('rude_socioeconomicos');
        Schema::dropIfExists('rude_direcciones');
        Schema::dropIfExists('rude_discapacidades');
        Schema::dropIfExists('rude_estudiantes');
    }
};