<?php

use App\Http\Controllers\ProductoController; // <-- Importante: agregamos esta línea
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

// Ruta POST para recibir el formulario que dijo Leandro
Route::post('/guardar-dato', [TestController::class, 'guardar']);

// Ruta principal y filtro dinámico por categoría (reemplaza la ruta '/' anterior)
Route::get('/', [ProductoController::class, 'categoria']);
Route::get('/categoria/{nombre?}', [ProductoController::class, 'categoria'])->name('productos.categoria');

// Catálogo de Productos
Route::get('/productos', function () {
    return view('productos'); // Apunta a resources/views/productos.blade.php
});

// Carrito de compras
Route::get('/carrito', function () {
    return view('carrito'); // Apunta a resources/views/carrito.blade.php
});

// Dashboard Admin
Route::get('/admin', function () {
    return view('admin.admin'); // Apunta a resources/views/admin/admin.blade.php
});

Route::get('/login', function () {
    return view('admin.login'); // Quería ver si funcionaba o algo KDJSKDJSK
});