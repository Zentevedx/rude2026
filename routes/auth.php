<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    // Vista de Registro
    Route::get('register', function () {
        return Inertia::render('auth/Register');
    })->name('register');

    // Vista de Login
    Route::get('login', function () {
        return Inertia::render('auth/Login');
    })->name('login');
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');