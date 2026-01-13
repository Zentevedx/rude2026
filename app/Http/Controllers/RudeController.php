<?php

namespace App\Http\Controllers;

use App\Models\RudeEstudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RudeController extends Controller
{
    // Muestra el formulario principal
    public function index()
    {
        return Inertia::render('Public/RudeForm');
    }

    // Guarda todo el formulario
    public function store(Request $request)
    {
        // 1. Validación básica (puedes expandirla)
        $request->validate([
            'estudiante.carnet_identidad' => 'required|unique:rude_estudiantes,carnet_identidad',
            'estudiante.nombres' => 'required',
            'estudiante.file_ci_anverso' => 'required|image|max:5120', // Máx 5MB
            'tutor.carnet_identidad' => 'required',
        ]);

        return DB::transaction(function () use ($request) {
            
            // A. Guardar Estudiante
            $dataEstudiante = $request->input('estudiante');
            
            // Subida de Archivos Estudiante
            if ($request->hasFile('estudiante.file_ci_anverso')) {
                $path = $request->file('estudiante.file_ci_anverso')->store('documentos/estudiantes', 'public');
                $dataEstudiante['file_ci_anverso_path'] = $path;
            }
            if ($request->hasFile('estudiante.file_ci_reverso')) {
                $path = $request->file('estudiante.file_ci_reverso')->store('documentos/estudiantes', 'public');
                $dataEstudiante['file_ci_reverso_path'] = $path;
            }
            // Limpiamos los campos que no son de la DB (los inputs file)
            unset($dataEstudiante['file_ci_anverso']);
            unset($dataEstudiante['file_ci_reverso']);

            $estudiante = RudeEstudiante::create($dataEstudiante);

            // B. Guardar Dirección
            $estudiante->direccion()->create($request->input('direccion'));

            // C. Guardar Socioeconómico
            $estudiante->socioeconomico()->create($request->input('socioeconomico'));

            // D. Guardar Tutor
            $dataTutor = $request->input('tutor');
            
            // Subida de Archivos Tutor
            if ($request->hasFile('tutor.file_ci_anverso')) {
                $path = $request->file('tutor.file_ci_anverso')->store('documentos/tutores', 'public');
                $dataTutor['file_ci_anverso_path'] = $path;
            }
            if ($request->hasFile('tutor.file_ci_reverso')) {
                $path = $request->file('tutor.file_ci_reverso')->store('documentos/tutores', 'public');
                $dataTutor['file_ci_reverso_path'] = $path;
            }
            unset($dataTutor['file_ci_anverso']);
            unset($dataTutor['file_ci_reverso']);

            $estudiante->tutores()->create($dataTutor);

            return redirect()->route('welcome')->with('success', 'Formulario RUDE registrado correctamente.');
        });
    }
}