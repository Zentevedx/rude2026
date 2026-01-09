<?php

namespace App\Http\Controllers;

use App\Models\RudeRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RudeController extends Controller
{
    /**
     * Muestra el formulario público para los padres.
     */
    public function create()
    {
        return Inertia::render('Public/RudeForm');
    }

    /**
     * Procesa y guarda el formulario RUDE.
     */
    public function store(Request $request)
    {
        // 1. VALIDACIÓN RIGUROSA (Seguridad y Unicidad)
        $validated = $request->validate([
            // --- IDENTIFICADORES ÚNICOS ---
            'codigo_rude' => 'required|string|unique:rude_registrations,codigo_rude',
            'ci_estudiante' => 'nullable|string|unique:rude_registrations,ci_estudiante',

            // --- DATOS DEL ESTUDIANTE ---
            'apellido_paterno' => 'nullable|string',
            'apellido_materno' => 'nullable|string',
            'nombres' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|in:M,F',
            'pais_nac' => 'required|string',
            'depto_nac' => 'required|string',
            'provincia_nac' => 'required|string',
            'localidad_nac' => 'required|string',
            
            // Certificado (Opcionales pero recomendados)
            'cert_oficialia' => 'nullable|string',
            'cert_libro' => 'nullable|string',
            'cert_partida' => 'nullable|string',
            'cert_folio' => 'nullable|string',
            
            // Discapacidad
            'tiene_discapacidad' => 'boolean',
            'registro_discapacidad_ibc' => 'nullable|required_if:tiene_discapacidad,true',

            // --- DIRECCIÓN ---
            'dir_departamento' => 'required|string',
            'dir_provincia' => 'required|string',
            'dir_municipio' => 'required|string',
            'dir_localidad' => 'required|string',
            'dir_zona' => 'required|string',
            'dir_calle' => 'required|string',
            'dir_num_casa' => 'nullable|string',
            'celular_contacto' => 'required|string|min:8', // Vital para contacto

            // --- SOCIOECONÓMICO ---
            'idioma_niñez' => 'required|string',
            'idiomas_frecuentes' => 'required|string',
            'nacion_autoidentificacion' => 'required|string',
            'socio_agua_procedencia' => 'required|string',
            'socio_energia_electrica' => 'boolean',
            'socio_wc_tipo' => 'required|string',
            'acceso_internet' => 'nullable|string',
            'transporte_escuela' => 'required|string',
            'tiempo_transporte' => 'required|string',

            // --- TUTOR / PADRES ---
            'ci_tutor' => 'required|string',
            'nombre_tutor' => 'required|string',
            'parentesco_tutor' => 'required|string',
            'ocupacion_tutor' => 'nullable|string',
            'instruccion_tutor' => 'nullable|string',

            // --- ARCHIVOS (FOTOS) ---
            // Máximo 3MB, solo imágenes
            'foto_ci_est_anverso' => 'required|image|mimes:jpg,jpeg,png|max:3072',
            'foto_ci_est_reverso' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'foto_ci_tut_anverso' => 'required|image|mimes:jpg,jpeg,png|max:3072',
            'foto_ci_tut_reverso' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',

        ], [
            // MENSAJES DE ERROR PERSONALIZADOS (Español)
            'codigo_rude.unique' => 'Este CÓDIGO RUDE ya está registrado. No se admiten duplicados.',
            'ci_estudiante.unique' => 'Este CARNET DE IDENTIDAD (Estudiante) ya figura en el sistema.',
            'codigo_rude.required' => 'El Código RUDE es obligatorio.',
            'foto_ci_est_anverso.required' => 'Debe subir la foto del carnet del estudiante.',
            'celular_contacto.required' => 'El número de celular es obligatorio para contactarlo.',
            'foto_ci_est_anverso.max' => 'La foto del carnet es muy pesada (Máximo 3MB).',
        ]);

        // 2. PROCESAMIENTO DE ARCHIVOS
        // Creamos una carpeta con el año y el código RUDE para organizar
        $rudeCode = $request->input('codigo_rude');
        $storagePath = "documentos_rude_2025/{$rudeCode}";

        $paths = [];
        
        if ($request->hasFile('foto_ci_est_anverso')) {
            $paths['foto_ci_est_anverso'] = $request->file('foto_ci_est_anverso')->store($storagePath, 'local'); 
            // Usamos 'local' (storage/app) para que no sea público directamente
        }
        if ($request->hasFile('foto_ci_est_reverso')) {
            $paths['foto_ci_est_reverso'] = $request->file('foto_ci_est_reverso')->store($storagePath, 'local');
        }
        if ($request->hasFile('foto_ci_tut_anverso')) {
            $paths['foto_ci_tut_anverso'] = $request->file('foto_ci_tut_anverso')->store($storagePath, 'local');
        }
        if ($request->hasFile('foto_ci_tut_reverso')) {
            $paths['foto_ci_tut_reverso'] = $request->file('foto_ci_tut_reverso')->store($storagePath, 'local');
        }

        // 3. GUARDAR EN BASE DE DATOS
        // Unimos los datos validados (menos los archivos raw) con las rutas de los archivos
        $datosAGuardar = $request->except([
            'foto_ci_est_anverso', 'foto_ci_est_reverso', 
            'foto_ci_tut_anverso', 'foto_ci_tut_reverso'
        ]);

        $datosAGuardar = array_merge($datosAGuardar, $paths);
        
        // Agregar IP para seguridad/auditoría
        $datosAGuardar['ip_registro'] = $request->ip();

        RudeRegistration::create($datosAGuardar);

        // 4. RESPUESTA AL USUARIO
        return redirect()->back()->with('success', '¡Formulario RUDE registrado exitosamente! La unidad educativa revisará sus documentos.');
    }

    /**
     * Panel de Administración (Solo para el usuario Admin).
     */
    public function index()
    {
        // Obtener todos los registros ordenados por fecha
        $registros = RudeRegistration::orderBy('created_at', 'desc')->get();

        return Inertia::render('Admin/RudeDashboard', [
            'registros' => $registros
        ]);
    }

    /**
     * Método para ver las imágenes de forma segura (Solo Admin).
     * Ruta ejemplo: /admin/rude/documento/{id}/{tipo}
     */
    public function viewDocument($id, $tipo)
    {
        // Verificar seguridad (Solo admin logueado)
        if (!Auth::check()) {
            abort(403, 'No autorizado');
        }

        $registro = RudeRegistration::findOrFail($id);
        
        // Seleccionar qué campo de imagen queremos ver
        $path = null;
        switch ($tipo) {
            case 'est_anverso': $path = $registro->foto_ci_est_anverso; break;
            case 'est_reverso': $path = $registro->foto_ci_est_reverso; break;
            case 'tut_anverso': $path = $registro->foto_ci_tut_anverso; break;
            case 'tut_reverso': $path = $registro->foto_ci_tut_reverso; break;
        }

        if ($path && Storage::disk('local')->exists($path)) {
            return response()->file(storage_path('app/' . $path));
        }

        abort(404, 'Imagen no encontrada');
    }
}