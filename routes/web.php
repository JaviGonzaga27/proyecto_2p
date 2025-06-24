<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas de usuarios con ruta adicional para verificación
Route::resource('usuarios', UserController::class);
Route::patch('usuarios/{usuario}/verify', [UserController::class, 'verify'])->name('usuarios.verify');

// Rutas de productos
Route::resource('productos', ProductoController::class);
