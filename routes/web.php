<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PlanillaController;
use App\Http\Controllers\ParametroController;

// Redirección inicial
Route::get('/', function () {
    return redirect('/login');
});

// Autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard general (requiere login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// ---------------------------------------------
// 🔐 ACCESO SOLO PARA ADMINISTRADOR
// ---------------------------------------------
Route::middleware(['auth', 'rol:administrador'])->group(function () {

    // Usuarios
    Route::resource('usuarios', UsuarioController::class);

    // Empleados
    Route::resource('empleados', EmpleadoController::class);

    // Parámetros generales
    Route::get('/parametros', [ParametroController::class, 'index'])->name('parametros.index');
    Route::get('/parametros/create', [ParametroController::class, 'create'])->name('parametros.create');
    Route::post('/parametros', [ParametroController::class, 'store'])->name('parametros.store');
    Route::get('/parametros/{parametro}/edit', [ParametroController::class, 'edit'])->name('parametros.edit');
    Route::put('/parametros/{parametro}', [ParametroController::class, 'update'])->name('parametros.update');

    // Parámetros por empleado
    Route::get('/parametros/empleado/{empleado}', [ParametroController::class, 'showEmpleado'])->name('parametros.empleado');
    Route::post('/parametros/empleado/{empleado}', [ParametroController::class, 'updateEmpleado'])->name('parametros.empleado.update');

    // Módulo de horarios (si lo quieres exclusivo de admin)
    Route::resource('horarios', HorarioController::class);
});

// ---------------------------------------------
// 🔐 ACCESO PARA ADMINISTRADOR Y OPERADOR
// ---------------------------------------------
Route::middleware(['auth', 'rol:administrador,operador'])->group(function () {

    // Permisos
    Route::resource('permisos', PermisoController::class);

    // Planillas
    Route::get('/planillas', [PlanillaController::class, 'index'])->name('planillas.index');
    Route::get('/planillas/create', [PlanillaController::class, 'create'])->name('planillas.create');
    Route::post('/planillas/generar', [PlanillaController::class, 'generar'])->name('planillas.generar');
    Route::get('/planillas/{planilla}', [PlanillaController::class, 'show'])->name('planillas.show');
});

// ---------------------------------------------
// 👤 TODOS LOS ROLES pueden usar esta ruta
// (Usuario, Operador, Administrador)
// ---------------------------------------------
Route::middleware(['auth', 'rol:usuario,operador,administrador'])->group(function () {
    Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');
    Route::post('/asistencia/entrada', [AsistenciaController::class, 'storeEntrada'])->name('asistencia.entrada');
    Route::post('/asistencia/salida', [AsistenciaController::class, 'storeSalida'])->name('asistencia.salida');
});

// ---------------------------------------------
// 🔓 Rutas públicas (sin protección por rol)
// ---------------------------------------------
Route::get('/imagenes/productos/{filename}', function ($filename) {
    $path = storage_path('app/public/productos/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $mimeType = File::mimeType($path);
    return response()->file($path, ['Content-Type' => $mimeType]);
})->name('productos.imagen');
