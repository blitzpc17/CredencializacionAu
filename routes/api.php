<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TerminalController;
use App\Http\Controllers\FolioController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\HorarioCredencializacionController;
use App\Http\Controllers\SolicitudEstadoController;
use App\Http\Controllers\SolicitudController;

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

Route::post('solicitudes', [SolicitudController::class, 'store']);
Route::get('solicitudes/{folio}', [SolicitudController::class, 'consultarPorFolio']);




