<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ToolsController;

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

//imagenes



Route::prefix('/')->group(function(){

    Route::get('/', function () {
        return view('client.home');
    })->name('client.home');

    Route::get('/solicitud', function () {
        return view('client.solicitud');
    })->name('client.solicitud');
});

Route::middleware(['auth'])->prefix('admin')->group(function(){

    Route::get('login', function(){
        return view('cms.login');
    });

    Route::get('/', function(){
        return view('cms.dashboard');
    })->name('cms.dash');

    Route::get('controles', function(){
        return view('cms.controles');
    })->name('cms.controles');


    Route::get('perfiles', function () {
        return view('cms.perfiles');
    })->name('cms.perfiles.index');

    Route::get('horarios-credencializacion', function () {
        return view('cms.horarios-credencializacion');
    })->name('cms.horarios-credencializacion.index');

    Route::get('terminales', function () {
        return view('cms.terminales');
    })->name('cms.terminales.index');

    Route::get('folios', function () {
        return view('cms.folios');
    })->name('cms.folios.index');

    Route::get('solicitudes-estados', function () {
        return view('cms.solicitudes-estados');
    })->name('cms.solicitudes-estados.index');

    Route::get('solicitudes', function () {
        return view('cms.solicitudes');
    })->name('cms.solicitudes.index');

    Route::get('usuarios', function () {        
        return view('cms.usuarios');
    })->name('cms.usuarios.index');


  

});


Route::get('storage/images', [ToolsController::class, 'ObtenerImagen'])->name('tools.getimagen');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');









