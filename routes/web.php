<?php

use App\Http\Controllers\RudeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| 1. RUTAS PÚBLICAS (Padres de Familia)
|--------------------------------------------------------------------------
*/

// Paso 1: Mostrar el Formulario (Home)
// Nombramos a esta ruta 'welcome' porque el controlador redirige aquí al terminar.
Route::get('/', [RudeController::class, 'index'])->name('welcome');

// Paso 2: Guardar los datos (POST)
// Esta es la ruta que busca el botón "FINALIZAR INSCRIPCIÓN"
Route::post('/rude/registrar', [RudeController::class, 'store'])->name('rude.store');


/*
|--------------------------------------------------------------------------
| 2. RUTAS PRIVADAS (Administrador / Secretaria)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth', // Usamos el guard por defecto (web session) para evitar problemas con Sanctum
    'verified',
])->group(function () {

    // Listado Dashboard
    Route::get('/dashboard', [RudeController::class, 'list'])->name('dashboard');

    // CRUD Admin RUDE
    Route::get('/admin/rude/{id}/edit', [RudeController::class, 'edit'])->name('rude.edit');
    Route::put('/admin/rude/{id}', [RudeController::class, 'update'])->name('rude.update');
    Route::delete('/admin/rude/{id}', [RudeController::class, 'destroy'])->name('rude.destroy');
    Route::get('/admin/rude/{id}/print', [RudeController::class, 'print'])->name('rude.print');
    
    // Ruta segura para ver documentos (evita acceso público directo)
    Route::get('/admin/rude/foto/{id}/{type}', [RudeController::class, 'showPhoto'])->name('rude.showPhoto');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';