<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

//Login y registro (lo que pensamos hoy mili lunes 31 de agosto)

// Vistas para mostrar los formularios (GET)
Route::get('/login', function () {
    return view('login'); // resources/views/login.blade.php
})->name('login');

Route::get('/register', function () {
    return view('register'); // resources/views/register.blade.php
})->name('register');

// Procesamiento de formularios (POST)
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- PRODUCTOS Y TIENDA ---

Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');

// Ruta principal y filtro dinámico por categoría
Route::get('/', [ProductoController::class, 'categoria']);
Route::get('/categoria/{nombre?}', [ProductoController::class, 'categoria'])->name('productos.categoria');

// Ruta API que consume tu main.js / api.js
Route::get('/api/productos', [ProductoController::class, 'index']);

// Catálogo de Productos
Route::get('/productos', function () {
    return view('productos'); // resources/views/productos.blade.php
});

// Carrito de compras
Route::get('/carrito', function () {
    return view('carrito'); // resources/views/carrito.blade.php
});

// Dashboard Admin
Route::get('/admin', function () {
    return view('admin.admin'); // resources/views/admin/admin.blade.php
})->name('admin.dashboard');