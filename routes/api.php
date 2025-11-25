<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TerminalController;
use App\Http\Controllers\FolioController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\HorarioCredencializacionController;
use App\Http\Controllers\SolicitudEstadoController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VariableGlobalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('perfiles', PerfilController::class);
Route::apiResource('horarios-credencializacion', HorarioCredencializacionController::class);
Route::apiResource('terminales', TerminalController::class);
Route::apiResource('folios', FolioController::class);
Route::apiResource('solicitudes-estados', SolicitudEstadoController::class);


//solicitudes
/*Route::post('solicitudes', [SolicitudController::class, 'store']);
Route::get('solicitudes/{folio}', [SolicitudController::class, 'consultarPorFolio']);
Route::get('solicitudes', [SolicitudController::class, 'index']);
Route::get('solicitudes-estadisticas/estadisticas', [SolicitudController::class, 'estadisticas']);*/

//usuarios
Route::prefix('usuarios')->group(function () {

    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{id}', [UserController::class, 'show'])->name('show');
    Route::put('/{id}', [UserController::class, 'update'])->name('update');
    Route::put('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
});


Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
    Route::get('/', [SolicitudController::class, 'index'])->name('index');
    Route::get('/form-data', [SolicitudController::class, 'getFormData'])->name('form-data');
    Route::post('/', [SolicitudController::class, 'store'])->name('store');
    Route::get('/{id}', [SolicitudController::class, 'show'])->name('show');
    Route::put('/{id}', [SolicitudController::class, 'update'])->name('update');
    Route::put('/{id}/cambiar-estado', [SolicitudController::class, 'cambiarEstado'])->name('cambiar-estado');
    Route::delete('/{id}', [SolicitudController::class, 'destroy'])->name('destroy');
    Route::get('/{id}/descargar-credencial', [SolicitudController::class, 'descargarCredencial']);
});



Route::prefix('variables-globales')->name('variables-globales.')->group(function () {
    Route::get('/', [VariableGlobalController::class, 'index'])->name('index');
    Route::post('/', [VariableGlobalController::class, 'store'])->name('store');
    Route::get('/{id}', [VariableGlobalController::class, 'show'])->name('show');
    Route::put('/{id}', [VariableGlobalController::class, 'update'])->name('update');
    Route::delete('/{id}', [VariableGlobalController::class, 'destroy'])->name('destroy');
    
    // Rutas especiales
    Route::get('/nombre/{nombre}', [VariableGlobalController::class, 'obtenerPorNombre'])->name('obtener-por-nombre');
    Route::put('/nombre/{nombre}', [VariableGlobalController::class, 'actualizarPorNombre'])->name('actualizar-por-nombre');
    Route::get('/configuracion/sistema', [VariableGlobalController::class, 'obtenerConfiguracionSistema'])->name('configuracion-sistema');
    Route::get('/configuracion/email', [VariableGlobalController::class, 'obtenerConfiguracionEmail'])->name('configuracion-email');
});

Route::get('/solicitudes/{id}/file/{field}', [SolicitudController::class, 'getFile']);



