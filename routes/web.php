<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PlanillaController;
use App\Http\Controllers\ParametroController;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
//Módulo Usuarios
Route::get('/usuarios', [UsuarioController::class, 'index'])->middleware('auth')->name('usuarios.index');

Route::resource('usuarios', UsuarioController::class)->middleware('auth');

Route::resource('empleados', EmpleadoController::class);


Route::get('/imagenes/productos/{filename}', function ($filename) {
    $path = storage_path('app/public/productos/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $mimeType = File::mimeType($path);
    return response()->file($path, ['Content-Type' => $mimeType]);
})->name('productos.imagen');

Route::resource('horarios', HorarioController::class);

Route::get('asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');

Route::post('asistencia/entrada', [AsistenciaController::class, 'storeEntrada'])->name('asistencia.entrada');
Route::post('asistencia/salida', [AsistenciaController::class, 'storeSalida'])->name('asistencia.salida');

Route::resource('permisos', PermisoController::class);

// Parámetros generales
Route::get('/parametros', [ParametroController::class, 'index'])->name('parametros.index');
Route::get('/parametros/{parametro}/edit', [ParametroController::class, 'edit'])->name('parametros.edit');
Route::put('/parametros/{parametro}', [ParametroController::class, 'update'])->name('parametros.update');
Route::get('/parametros/create', [ParametroController::class, 'create'])->name('parametros.create');
Route::post('/parametros', [ParametroController::class, 'store'])->name('parametros.store');

// Parámetros por empleado
Route::get('/parametros/empleado/{empleado}', [ParametroController::class, 'showEmpleado'])->name('parametros.empleado');
Route::post('/parametros/empleado/{empleado}', [ParametroController::class, 'updateEmpleado'])->name('parametros.empleado.update');

// Planillas
Route::get('/planillas', [PlanillaController::class, 'index'])->name('planillas.index');
Route::get('/planillas/{planilla}', [PlanillaController::class, 'show'])->name('planillas.show');
Route::get('/planillas/create', [PlanillaController::class, 'create'])->name('planillas.create');
Route::post('/planillas/generar', [PlanillaController::class, 'generar'])->name('planillas.generar');
