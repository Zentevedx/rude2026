<?php

namespace App\Http\Controllers;

use App\Models\RudeRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RudeController extends Controller
{
    /**
     * Muestra el panel administrativo (Protegido por Auth)
     */
    public function index()
    {
        return Inertia::render('Dashboard', [
            'registros' => RudeRegistration::orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Guarda el registro enviado por los padres
     */
    public function store(Request $request)
    {
        // 1. VALIDACIÓN RIGUROSA (Seguridad de datos de menores)
        $request->validate([
            'nombres' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|in:M,F',
            'celular_contacto' => 'required|numeric|digits_between:7,10',
            'ci_tutor' => 'required|string|max:20',
            // Fotos: Máximo 3MB por foto, solo imágenes
            'foto_ci_est_anverso' => 'required|image|mimes:jpg,jpeg,png|max:3072',
            'foto_ci_est_reverso' => 'required|image|mimes:jpg,jpeg,png|max:3072',
            'foto_ci_tut_anverso' => 'required|image|mimes:jpg,jpeg,png|max:3072',
            'foto_ci_tut_reverso' => 'required|image|mimes:jpg,jpeg,png|max:3072',
        ]);

        // 2. PROCESAMIENTO DE ARCHIVOS (Almacenamiento NO PÚBLICO)
        $folder = 'rudes/2025/' . str_replace(' ', '_', $request->nombres);
        
        $files = [];
        $fileFields = ['foto_ci_est_anverso', 'foto_ci_est_reverso', 'foto_ci_tut_anverso', 'foto_ci_tut_reverso'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // Se guarda en storage/app/private para máxima seguridad
                $files[$field] = $request->file($field)->store($folder, 'private');
            }
        }

        // 3. PERSISTENCIA EN BASE DE DATOS
        $data = $request->except($fileFields);
        $data = array_merge($data, $files);
        $data['ip_registro'] = $request->ip(); // Auditoría de seguridad

        RudeRegistration::create($data);

        return redirect()->back()->with('success', '¡Registro completado con éxito!');
    }
    // ... (dentro de la clase RudeController)

/**
 * Sirve las fotos de CI de forma segura validando la sesión.
 */
public function viewDocument($id, $tipo)
{
    $registro = RudeRegistration::findOrFail($id);
    
    // Mapeo de campos de fotos
    $campos = [
        'est_anverso' => $registro->foto_ci_est_anverso,
        'est_reverso' => $registro->foto_ci_est_reverso,
        'tut_anverso' => $registro->foto_ci_tut_anverso,
        'tut_reverso' => $registro->foto_ci_tut_reverso,
    ];

    $path = $campos[$tipo] ?? null;

    if (!$path || !Storage::disk('private')->exists($path)) {
        abort(404);
    }

    return response()->file(storage_path('app/private/' . $path));
}
}