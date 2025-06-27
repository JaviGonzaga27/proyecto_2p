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

// Rutas de usuarios
Route::resource('usuarios', UserController::class);
Route::patch('usuarios/{usuario}/verify', [UserController::class, 'verify'])->name('usuarios.verify');

// Rutas de productos eliminados y restauración
Route::get('productos/eliminados', [ProductoController::class, 'eliminados'])->name('productos.eliminados');
Route::get('productos/auditoria', [ProductoController::class, 'auditoria'])->name('productos.auditoria');
Route::post('productos/{id}/restore', [ProductoController::class, 'restore'])->name('productos.restore');
Route::delete('productos/{id}/force-destroy', [ProductoController::class, 'forceDestroy'])->name('productos.forceDestroy');

// Rutas de productos
Route::resource('productos', ProductoController::class);
