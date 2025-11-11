<?php

use Illuminate\Support\Facades\Route;

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



Route::prefix('/')->group(function(){

    Route::get('/home', function () {
        return view('client.home');
    });

    Route::get('/solicitud', function () {
        return view('client.solicitud');
    });
});

Route::prefix('admin')->group(function(){

    Route::get('login', function(){
        return view('login');
    });

    Route::get('/', function(){
        return view('dashboard');
    });

});
