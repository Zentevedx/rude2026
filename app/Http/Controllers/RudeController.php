<?php
namespace App\Http\Controllers;

use App\Models\RudeRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RudeController extends Controller {
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'rude_code' => 'required|unique:rude_registrations,rude_code',
            'ci_numero' => 'required|unique:rude_registrations,ci_numero',
            'fecha_nacimiento' => 'required|date',
            // Agregamos reglas de seguridad para menores
            'datos_padre.ci' => 'required_without:datos_madre.ci', 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $registro = RudeRegistration::create($request->all());

        return response()->json([
            'message' => 'Registro RUDE 2025 guardado exitosamente',
            'data' => $registro
        ], 201);
    }

    public function index() {
        // Solo para el Administrador
        return RudeRegistration::orderBy('apellido_paterno')->get();
    }
}