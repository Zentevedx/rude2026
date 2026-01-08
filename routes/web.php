<?php

use App\Http\Controllers\RudeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Para los Padres de Familia)
|--------------------------------------------------------------------------
*/

// Formulario RUDE de la U.E. ISMAEL VÁSQUEZ
Route::get('/', function () {
    return Inertia::render('Public/RudeForm');
})->name('rude.form');

// Procesar el envío del formulario
Route::post('/enviar-rude', [RudeController::class, 'store'])->name('rude.store');


/*
|--------------------------------------------------------------------------
| RUTAS PRIVADAS (Solo para el Administrador)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Panel de Control Principal
    Route::get('/dashboard', [RudeController::class, 'index'])->name('dashboard');
    
    // Ruta segura para ver fotos de CI (Evita fuga de datos)
    Route::get('/admin/rude/foto/{id}/{tipo}', [RudeController::class, 'viewDocument'])
        ->name('admin.rude.foto');
});

/*
|--------------------------------------------------------------------------
| ARCHIVOS ADICIONALES
|--------------------------------------------------------------------------
*/
require __DIR__.'/settings.php';
require __DIR__.'/auth.php'; // Ahora este archivo ya existe