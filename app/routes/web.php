<?php

use App\Http\Controllers\TestController;   //esta linea es tambien para el formularioLeandro
use Illuminate\Support\Facades\Route;


// Ruta POST para recibir el formulario que dijo Leandro
Route::post('/guardar-dato', [TestController::class, 'guardar']);




// Ruta principal (Home / Index)
Route::get('/', function () {
    return view('index'); // Apunta a resources/views/index.blade.php
});

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