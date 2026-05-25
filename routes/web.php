<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth.session'])->group(function () {
    
    // Cerrar sesión    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard general
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // ========== RESERVAS ==========
    Route::prefix('reservas')->name('reservas.')->group(function () {
        Route::get('/crear', [ReservaController::class, 'create'])->name('create');
        Route::post('/guardar', [ReservaController::class, 'store'])->name('store');
        Route::get('/mis-reservas', [ReservaController::class, 'misReservas'])->name('mis-reservas');
        Route::get('/ver/{id}', [ReservaController::class, 'show'])->name('show');
        Route::post('/cancelar/{id}', [ReservaController::class, 'cancelar'])->name('cancelar');
        Route::get('/horarios-disponibles', [ReservaController::class, 'horariosDisponibles'])->name('horarios');
    });
    
    // ========== ADMINISTRACIÓN ==========
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Gestión de usuarios
        Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
        Route::get('/usuarios/crear', [AdminController::class, 'crearUsuario'])->name('usuarios.crear');
        Route::post('/usuarios/guardar', [AdminController::class, 'guardarUsuario'])->name('usuarios.guardar');
        Route::get('/usuarios/editar/{id}', [AdminController::class, 'editarUsuario'])->name('usuarios.editar');
        Route::put('/usuarios/actualizar/{id}', [AdminController::class, 'actualizarUsuario'])->name('usuarios.actualizar');
        Route::delete('/usuarios/eliminar/{id}', [AdminController::class, 'eliminarUsuario'])->name('usuarios.eliminar');
        
        // Gestión de recursos
        Route::get('/recursos', [AdminController::class, 'recursos'])->name('recursos');
        Route::get('/recursos/crear', [AdminController::class, 'crearRecurso'])->name('recursos.crear');
        Route::post('/recursos/guardar', [AdminController::class, 'guardarRecurso'])->name('recursos.guardar');
        Route::get('/recursos/editar/{id}', [AdminController::class, 'editarRecurso'])->name('recursos.editar');
        Route::put('/recursos/actualizar/{id}', [AdminController::class, 'actualizarRecurso'])->name('recursos.actualizar');
        Route::delete('/recursos/eliminar/{id}', [AdminController::class, 'eliminarRecurso'])->name('recursos.eliminar');
        
        // Gestión de reservas
        Route::get('/reservas', [AdminController::class, 'reservas'])->name('reservas');
        Route::post('/reservas/aprobar/{id}', [AdminController::class, 'aprobarReserva'])->name('reservas.aprobar');
        Route::post('/reservas/rechazar/{id}', [AdminController::class, 'rechazarReserva'])->name('reservas.rechazar');
        Route::post('/reservas/finalizar/{id}', [AdminController::class, 'finalizarReserva'])->name('reservas.finalizar');
        
        // Historial
        Route::get('/historial', [AdminController::class, 'historial'])->name('historial');
    });
});