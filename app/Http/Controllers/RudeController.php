<?php

namespace App\Http\Controllers;

use App\Models\RudeEstudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RudeController extends Controller
{
    /**
     * Muestra el formulario principal del RUDE.
     */
    public function index()
    {
        return Inertia::render('Public/RudeForm');
    }

    /**
     * Listado para el Administrador
     */
    public function list(Request $request)
    {
        // 1. Estadísticas por Curso (Cantidad)
        $stats_curso = RudeEstudiante::select('anio_escolaridad', DB::raw('count(*) as total'))
            ->groupBy('anio_escolaridad')
            ->orderBy('anio_escolaridad')
            ->get();

        // 2. Estadísticas de Tiempo (Registrados Hoy)
        $registrados_hoy = RudeEstudiante::whereDate('created_at', now()->today())->count();

        // 3. Query Principal con Filtros
        $query = RudeEstudiante::with(['direccion', 'padres', 'socioeconomico'])
            ->latest(); // Orden por tiempo (último momento al principio)

        // Filtro opcional por curso si se envía ?curso=...
        if ($request->has('curso') && $request->curso != 'todos') {
            $query->where('anio_escolaridad', $request->curso);
        }

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombres', 'like', "%{$search}%")
                  ->orWhere('apellido_paterno', 'like', "%{$search}%")
                  ->orWhere('carnet_identidad', 'like', "%{$search}%");
            });
        }

        $registros = $query->paginate(15)
            ->withQueryString()
            ->through(function ($estudiante) {
                $padres = $estudiante->padres;
                $direccion = $estudiante->direccion;
                $socio = $estudiante->socioeconomico;

                // Determine logic for 'Apoderado' display
                $nombre_apoderado = 'Sin Registro';
                $ci_apoderado = '';
                $parentesco = '';

                if ($padres) {
                    if ($padres->tutor_nombres) {
                         $nombre_apoderado = $padres->tutor_nombres . ' ' . $padres->tutor_paterno;
                         $ci_apoderado = $padres->tutor_ci;
                         $parentesco = $padres->tutor_parentesco ?? 'TUTOR';
                    } elseif ($padres->padre_nombres) {
                         $nombre_apoderado = $padres->padre_nombres . ' ' . $padres->padre_paterno;
                         $ci_apoderado = $padres->padre_ci;
                         $parentesco = 'PADRE';
                    } elseif ($padres->madre_nombres) {
                         $nombre_apoderado = $padres->madre_nombres . ' ' . $padres->madre_paterno;
                         $ci_apoderado = $padres->madre_ci;
                         $parentesco = 'MADRE';
                    }
                }

                return [
                    'id' => $estudiante->id,
                    'is_recent' => $estudiante->created_at->diffInHours(now()) < 24, // Flag para "Nuevo"
                    'anio_escolaridad' => $estudiante->anio_escolaridad, // Necesario para mostrar el curso
                    'nombres' => $estudiante->nombres,
                    'apellido_paterno' => $estudiante->apellido_paterno,
                    'apellido_materno' => $estudiante->apellido_materno,
                    'ci_estudiante' => $estudiante->carnet_identidad,
                    'celular_contacto' => $direccion ? $direccion->celular_contacto : '',
                    'nombre_tutor' => $nombre_apoderado,
                    'parentesco_tutor' => $parentesco,
                    'ci_tutor' => $ci_apoderado,
                    'created_at' => $estudiante->created_at->diffForHumans(), // Tiempo relativo para "hace X min"
                    'created_at_raw' => $estudiante->created_at, // Para title/tooltip
                    
                    // Detalles para modal/print si necesario
                    'pais_nac' => $estudiante->pais_nacimiento,
                    'depto_nac' => $estudiante->departamento_nacimiento,
                ];
            });

        return Inertia::render('Admin/RudeDashboard', [
            'registros' => $registros,
            'stats' => [
                'por_curso' => $stats_curso,
                'hoy' => $registrados_hoy,
                'total' => RudeEstudiante::count()
            ],
            'filters' => $request->only(['search', 'curso'])
        ]);
    }

    /**
     * Procesa el guardado de todo el formulario y sus archivos.
     */
    public function store(Request $request)
    {
        // 1. VALIDACIÓN
        $request->validate([
            // A. Estudiante
            'estudiante.codigo_sie' => 'nullable|string|max:20',
            'estudiante.anio_escolaridad' => 'required|string', // NUEVO
            'estudiante.apellido_paterno' => 'nullable|string|max:50',
            'estudiante.apellido_materno' => 'nullable|string|max:50',
            'estudiante.nombres' => 'required|string|max:50',
            'estudiante.pais_nacimiento' => 'required|string',
            'estudiante.fecha_nacimiento' => 'required|date',
            'estudiante.sexo' => 'required|in:MASCULINO,FEMENINO',
            'estudiante.file_ci_anverso' => 'nullable|image|max:5120', // 5MB
            'estudiante.file_ci_reverso' => 'nullable|image|max:5120',
            
            // B. Direccion
            'direccion.departamento' => 'required|string',
            'direccion.provincia' => 'required|string',
            'direccion.municipio' => 'required|string',
            'direccion.localidad' => 'required|string',
            'direccion.zona' => 'required|string',
            'direccion.avenida_calle' => 'required|string',
            
            // C. Socioeconomico
            'socioeconomico.idioma_ninez' => 'required|string',
            'socioeconomico.idioma_frecuente_1' => 'required|string',
            'socioeconomico.acceso_agua' => 'required|boolean',
            'socioeconomico.tiene_alcantarillado' => 'required|boolean',
            
            // D. Padres/Tutores
            'padres.vive_con' => 'required|string',
            'padres.tutor_parentesco' => 'required_if:padres.vive_con,TUTOR(A)|nullable|string',
            'padres.file_ci_anverso' => 'nullable|image|max:5120',
            'padres.file_ci_reverso' => 'nullable|image|max:5120',
        ]);

        try {
            DB::beginTransaction();

            // A. ESTUDIANTE
            $estudianteData = $request->input('estudiante');
            
            // Manejo de Archivos Estudiante
            if ($request->hasFile('estudiante.file_ci_anverso')) {
                $path = $request->file('estudiante.file_ci_anverso')->store('cedulas', 'public');
                $estudianteData['file_ci_anverso'] = $path;
            }
            if ($request->hasFile('estudiante.file_ci_reverso')) {
                $path = $request->file('estudiante.file_ci_reverso')->store('cedulas', 'public');
                $estudianteData['file_ci_reverso'] = $path;
            }

            $estudiante = RudeEstudiante::create($estudianteData);

            // B. DISCAPACIDAD
            if ($estudianteData['tiene_discapacidad']) {
                $discapacidadData = $request->input('discapacidad');
                $estudiante->discapacidad()->create($discapacidadData);
            }

            // C. DIRECCIÓN
            $direccionData = $request->input('direccion');
            $estudiante->direccion()->create($direccionData);

            // D. SOCIOECONÓMICO
            $socioData = $request->input('socioeconomico');
            $estudiante->socioeconomico()->create($socioData);

            // E. PADRES
            $padresData = $request->input('padres');
            
            // Manejo de Archivos Padres
            if ($request->hasFile('padres.file_ci_anverso')) {
                $path = $request->file('padres.file_ci_anverso')->store('cedulas', 'public');
                $padresData['file_ci_anverso'] = $path;
            }
            if ($request->hasFile('padres.file_ci_reverso')) {
                $path = $request->file('padres.file_ci_reverso')->store('cedulas', 'public');
                $padresData['file_ci_reverso'] = $path;
            }

            $estudiante->padres()->create($padresData);

            DB::commit();

            return redirect()->route('welcome')
                ->with('success', '¡Inscripción Exitosa! El estudiante ' . $estudiante->nombres . ' ha sido registrado corréctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al guardar: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Formulario de Edición (Admin)
     */
    public function edit($id)
    {
        // Cargamos relaciones
        $estudiante = RudeEstudiante::with(['padres', 'direccion', 'socioeconomico', 'discapacidad'])->findOrFail($id);

        // Transformamos la estructura plana de la BD a la estructura anidada del formulario
        $formData = [
            'id' => $estudiante->id,
            'estudiante' => [
                'codigo_sie' => $estudiante->codigo_sie,
                'anio_escolaridad' => $estudiante->anio_escolaridad,
                'apellido_paterno' => $estudiante->apellido_paterno,
                'apellido_materno' => $estudiante->apellido_materno,
                'nombres' => $estudiante->nombres,
                'pais_nacimiento' => $estudiante->pais_nacimiento,
                'departamento_nacimiento' => $estudiante->departamento_nacimiento,
                'provincia_nacimiento' => $estudiante->provincia_nacimiento,
                'localidad_nacimiento' => $estudiante->localidad_nacimiento,
                'cert_oficialia' => $estudiante->cert_oficialia,
                'cert_libro' => $estudiante->cert_libro,
                'cert_partida' => $estudiante->cert_partida,
                'cert_folio' => $estudiante->cert_folio,
                'fecha_nacimiento' => $estudiante->fecha_nacimiento,
                'sexo' => $estudiante->sexo,
                'codigo_rude' => $estudiante->codigo_rude,
                'tiene_discapacidad' => (bool)$estudiante->tiene_discapacidad,
                'carnet_identidad' => $estudiante->carnet_identidad,
                'complemento' => $estudiante->complemento,
                'expedido' => $estudiante->expedido,
                // Files no se envían de vuelta al editar a menos que cambien
            ],
            'direccion' => [
                'departamento' => $estudiante->direccion ? $estudiante->direccion->departamento : 'Cochabamba',
                'provincia' => $estudiante->direccion ? $estudiante->direccion->provincia : '',
                'municipio' => $estudiante->direccion ? $estudiante->direccion->municipio : '',
                'localidad' => $estudiante->direccion ? $estudiante->direccion->localidad : '',
                'zona' => $estudiante->direccion ? $estudiante->direccion->zona : '',
                'avenida_calle' => $estudiante->direccion ? $estudiante->direccion->avenida_calle : '',
                'numero_vivienda' => $estudiante->direccion ? $estudiante->direccion->numero_vivienda : '',
                'telefono_fijo' => $estudiante->direccion ? $estudiante->direccion->telefono_fijo : '',
                'celular_contacto' => $estudiante->direccion ? $estudiante->direccion->celular_contacto : '',
            ],
            'socioeconomico' => [
                'idioma_ninez' => $estudiante->socioeconomico ? $estudiante->socioeconomico->idioma_ninez : '',
                'idioma_frecuente_1' => $estudiante->socioeconomico ? $estudiante->socioeconomico->idioma_frecuente_1 : '',
                'nacion_originaria' => $estudiante->socioeconomico ? $estudiante->socioeconomico->nacion_originaria : '',
                'existe_centro_salud' => $estudiante->socioeconomico ? (bool)$estudiante->socioeconomico->existe_centro_salud : false,
                'frecuencia_salud' => $estudiante->socioeconomico ? $estudiante->socioeconomico->frecuencia_salud : '',
                'acceso_agua' => $estudiante->socioeconomico ? (bool)$estudiante->socioeconomico->acceso_agua : false,
                'tiene_bano' => $estudiante->socioeconomico ? (bool)$estudiante->socioeconomico->tiene_bano : false,
                'tiene_alcantarillado' => $estudiante->socioeconomico ? (bool)$estudiante->socioeconomico->tiene_alcantarillado : false,
                'usa_electricidad' => $estudiante->socioeconomico ? (bool)$estudiante->socioeconomico->usa_electricidad : false,
                'servicio_basura' => $estudiante->socioeconomico ? (bool)$estudiante->socioeconomico->servicio_basura : false,
                'propiedad_vivienda' => $estudiante->socioeconomico ? $estudiante->socioeconomico->propiedad_vivienda : '',
                'acceso_internet_lugar' => $estudiante->socioeconomico ? $estudiante->socioeconomico->acceso_internet_lugar : '',
                'frecuencia_internet' => $estudiante->socioeconomico ? $estudiante->socioeconomico->frecuencia_internet : '',
                'trabajo_gestion_pasada' => $estudiante->socioeconomico ? (bool)$estudiante->socioeconomico->trabajo_gestion_pasada : false,
                'trabajo_actividad' => $estudiante->socioeconomico ? $estudiante->socioeconomico->trabajo_actividad : '',
            ],
            'padres' => $estudiante->padres ? [
                'vive_con' => $estudiante->padres->vive_con,
                'padre_ci' => $estudiante->padres->padre_ci,
                'padre_paterno' => $estudiante->padres->padre_paterno,
                'padre_materno' => $estudiante->padres->padre_materno,
                'padre_nombres' => $estudiante->padres->padre_nombres,
                'madre_ci' => $estudiante->padres->madre_ci,
                'madre_paterno' => $estudiante->padres->madre_paterno,
                'madre_materno' => $estudiante->padres->madre_materno,
                'madre_nombres' => $estudiante->padres->madre_nombres,
                'tutor_ci' => $estudiante->padres->tutor_ci,
                'tutor_paterno' => $estudiante->padres->tutor_paterno,
                'tutor_materno' => $estudiante->padres->tutor_materno,
                'tutor_nombres' => $estudiante->padres->tutor_nombres,
                'tutor_parentesco' => $estudiante->padres->tutor_parentesco,
            ] : []
        ];

        return Inertia::render('Admin/RudeEdit', [
            'rude_data' => $formData
        ]);
    }

    /**
     * Actualizar datos (Admin)
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $estudiante = RudeEstudiante::findOrFail($id);
            
            // Actualizar Estudiante
            $estData = $request->input('estudiante', []);
            $estudiante->fill($estData);
            $estudiante->save();

            // Actualizar Dirección
            // Si no existe, crearla. Si existe, actualizarla.
            $dirData = $request->input('direccion', []);
            if($estudiante->direccion) {
                 $estudiante->direccion->update($dirData);
            } else {
                 $estudiante->direccion()->create($dirData);
            }
            
            // Actualizar Socioeconomico
            $socData = $request->input('socioeconomico', []);
            if($estudiante->socioeconomico) {
                $estudiante->socioeconomico->update($socData);
            } else {
                $estudiante->socioeconomico()->create($socData);
            }

            // Actualizar Padres
            $padresData = $request->input('padres', []);
            if ($estudiante->padres) {
                $estudiante->padres->update($padresData);
            } else {
                $estudiante->padres()->create($padresData);
            }

            // Manejo de Archivos (si se suben nuevos)
            if ($request->hasFile('estudiante.file_ci_anverso')) {
                $path = $request->file('estudiante.file_ci_anverso')->store('cedulas', 'public');
                $estudiante->file_ci_anverso = $path;
                $estudiante->save();
            }
            // ... similar para otros archivos ...

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Registro actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    /**
     * Eliminar registro (Admin)
     */
    public function destroy($id)
    {
        $estudiante = RudeEstudiante::findOrFail($id);
        $estudiante->delete();
        return redirect()->route('dashboard')->with('success', 'Registro eliminado correctamente.');
    }

    /**
     * Vista de Impresión (PDF Friendly)
     */
    public function print($id)
    {
        $estudiante = RudeEstudiante::with(['padres', 'direccion', 'socioeconomico', 'discapacidad'])->findOrFail($id);
        return Inertia::render('Admin/RudePrint', [
            'estudiante' => $estudiante
        ]);
    }

    /**
     * Mostrar fotos de forma segura
     */
    public function showPhoto($id, $type)
    {
        $estudiante = RudeEstudiante::with('padres')->findOrFail($id);
        $path = null;

        switch ($type) {
            case 'estudiante_anverso':
                $path = $estudiante->file_ci_anverso;
                break;
            case 'estudiante_reverso':
                $path = $estudiante->file_ci_reverso;
                break;
            case 'padre_anverso':
                $path = $estudiante->padres ? $estudiante->padres->file_ci_anverso : null;
                break;
            case 'padre_reverso':
                $path = $estudiante->padres ? $estudiante->padres->file_ci_reverso : null;
                break;
        }

        if ($path && Storage::disk('public')->exists($path)) {
            return response()->file(storage_path('app/public/' . $path));
        }

        return abort(404);
    }
}