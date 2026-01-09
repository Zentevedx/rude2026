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
            $table->string('ue_sie')->default('80980XXX');
            $table->string('ue_nombre')->default('ISMAEL VÁSQUEZ');

            // II. DATOS DEL ESTUDIANTE
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nombres');
            $table->string('codigo_rude')->unique(); // ID ÚNICO
            $table->enum('sexo', ['M', 'F']);
            $table->date('fecha_nacimiento');
            
            // 2.2 Lugar de Nacimiento
            $table->string('nac_pais')->default('BOLIVIA');
            $table->string('nac_depto');
            $table->string('nac_provincia');
            $table->string('nac_localidad');
            
            // 2.3 Certificado Nacimiento
            $table->string('cert_oficialia')->nullable();
            $table->string('cert_libro')->nullable();
            $table->string('cert_partida')->nullable();
            $table->string('cert_folio')->nullable();
            
            // 2.5 Documento Identidad
            $table->string('ci_estudiante')->unique()->nullable(); // ID ÚNICO
            $table->string('ci_complemento')->nullable();
            $table->string('ci_expedido')->nullable();
            
            // 2.8 Discapacidad
            $table->boolean('tiene_discapacidad')->default(false);
            $table->string('disc_registro')->nullable(); // IBC
            $table->string('disc_tipo')->nullable();
            $table->string('disc_grado')->nullable();

            // III. DIRECCIÓN ACTUAL
            $table->string('dir_depto');
            $table->string('dir_provincia');
            $table->string('dir_municipio');
            $table->string('dir_localidad');
            $table->string('dir_zona');
            $table->string('dir_calle');
            $table->string('dir_numero')->nullable();
            $table->string('dir_telefono')->nullable();
            $table->string('dir_celular'); // OBLIGATORIO

            // IV. ASPECTOS SOCIOECONÓMICOS
            // 4.1 Idioma
            $table->string('socio_idioma_ninez');
            $table->string('socio_idioma_frec1');
            $table->string('socio_idioma_frec2')->nullable();
            $table->string('socio_idioma_frec3')->nullable();
            $table->string('socio_nacion'); // Autoidentificación
            
            // 4.2 Salud
            $table->string('salud_centro'); // Donde acude
            $table->string('salud_veces')->nullable();
            $table->boolean('salud_seguro')->default(false);
            
            // 4.3 Servicios
            $table->string('serv_agua');
            $table->boolean('serv_electricidad')->default(false);
            $table->string('serv_alcantarillado');
            
            // 4.4 Internet
            $table->string('net_acceso')->nullable(); // Lugar
            $table->string('net_frecuencia')->nullable();
            
            // 4.5 Trabajo
            $table->boolean('trabajo_realiza')->default(false);
            $table->string('trabajo_actividad')->nullable(); // Rubro
            $table->string('trabajo_dias')->nullable(); // Mañana/Tarde/Noche
            $table->string('trabajo_turno')->nullable();

            // 4.6 Transporte
            $table->string('trans_medio'); // A pie, vehículo...
            $table->string('trans_tiempo'); // Menos de 30min...

            // 4.7 Abandono
            $table->boolean('abandono_gestion_pasada')->default(false);
            $table->string('abandono_razon')->nullable();

            // V. DATOS PADRE/MADRE/TUTOR
            // Padre
            $table->string('padre_ci')->nullable();
            $table->string('padre_paterno')->nullable();
            $table->string('padre_materno')->nullable();
            $table->string('padre_nombres')->nullable();
            $table->string('padre_ocupacion')->nullable();
            $table->string('padre_grado')->nullable();
            
            // Madre
            $table->string('madre_ci')->nullable();
            $table->string('madre_paterno')->nullable();
            $table->string('madre_materno')->nullable();
            $table->string('madre_nombres')->nullable();
            $table->string('madre_ocupacion')->nullable();
            $table->string('madre_grado')->nullable();
            
            // Tutor
            $table->string('tutor_ci')->nullable();
            $table->string('tutor_paterno')->nullable();
            $table->string('tutor_materno')->nullable();
            $table->string('tutor_nombres')->nullable();
            $table->string('tutor_parentesco')->nullable();
            $table->string('tutor_ocupacion')->nullable();

            // ARCHIVOS
            $table->string('foto_ci_est_anverso');
            $table->string('foto_ci_est_reverso')->nullable();
            $table->string('foto_ci_tut_anverso');
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