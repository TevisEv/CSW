<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');



Route::resource('/productos', ProductoController::class) ->name('home','')->middleware('auth');
Route::resource('/clientes', ClienteController::class)->name('home','')->middleware('auth');