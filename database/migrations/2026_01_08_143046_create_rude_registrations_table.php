<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rude_registrations', function (Blueprint $table) {
            $table->id();
            
            // I. DATOS DE LA UNIDAD EDUCATIVA
            $table->string('sie_unidad_educativa')->default('80980000');
            
            // II. DATOS DE LA O EL ESTUDIANTE
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nombres');
            $table->string('codigo_rude')->unique()->nullable();
            $table->enum('sexo', ['M', 'F']);
            $table->date('fecha_nacimiento');
            
            // Lugar de Nacimiento
            $table->string('pais_nac');
            $table->string('depto_nac');
            $table->string('provincia_nac');
            $table->string('localidad_nac');
            
            // Documento de Identidad
            $table->string('ci_estudiante')->nullable();
            $table->string('ci_complemento')->nullable();
            $table->string('ci_expedido')->nullable();
            
            // Discapacidad
            $table->boolean('tiene_discapacidad')->default(false);
            $table->string('registro_discapacidad_ibc')->nullable();
            $table->string('tipo_discapacidad')->nullable();
            $table->string('grado_discapacidad')->nullable();
            
            // III. DIRECCIÓN ACTUAL
            $table->string('dir_departamento');
            $table->string('dir_provincia');
            $table->string('dir_municipio');
            $table->string('dir_localidad');
            $table->string('dir_zona');
            $table->string('dir_calle');
            $table->string('dir_num_casa');
            $table->string('telefono_fijo')->nullable();
            $table->string('celular_contacto');

            // IV. ASPECTOS SOCIOECONÓMICOS
            $table->string('idioma_niñez');
            $table->string('idiomas_frecuentes');
            $table->string('nacion_autoidentificacion');
            $table->boolean('tiene_seguro_salud')->default(false);
            $table->boolean('agua_red')->default(false);
            $table->boolean('luz_electrica')->default(false);
            $table->boolean('alcantarillado')->default(false);
            $table->string('acceso_internet')->nullable();
            $table->string('transporte_escuela')->nullable();
            $table->string('tiempo_transporte')->nullable();

            // V. DATOS PADRE, MADRE O TUTOR
            $table->string('vive_con')->nullable();
            $table->string('ci_tutor'); 
            $table->string('nombre_tutor');
            $table->string('parentesco_tutor');
            $table->string('ocupacion_tutor');
            $table->string('instruccion_tutor');

            // CAMPOS DE FOTOS
            $table->string('foto_ci_est_anverso')->nullable();
            $table->string('foto_ci_est_reverso')->nullable();
            $table->string('foto_ci_tut_anverso')->nullable();
            $table->string('foto_ci_tut_reverso')->nullable();

            $table->string('ip_registro')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rude_registrations');
    }
};