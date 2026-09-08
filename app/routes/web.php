<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\EnviosController; // agregué esto att:Mimi
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;

Route::middleware(['auth'])->group(function () {
    // ... tus otras rutas ...
    Route::post('/finalizar-compra', [PedidoController::class, 'procesarCompra'])->name('pedido.procesar');
});




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
Route::get('/', [ProductoController::class, 'categoria'])->name('index');
Route::get('/categoria/{nombre?}', [ProductoController::class, 'categoria'])->name('productos.categoria');

Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');

// Ruta API que consume tu main.js / api.js
Route::get('/api/productos', [ProductoController::class, 'index']);

// Dashboard Admin
Route::get('/admin', function () {
    return view('admin.admin'); // resources/views/admin/admin.blade.php
})->name('admin.dashboard');

// --- RUTAS PROTEGIDAS (REQUIEREN INICIAR SESIÓN) ---
Route::middleware(['auth'])->group(function () {
    
    // Carrito de compras
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::post('/carrito/cantidad/{id}', [CarritoController::class, 'cambiarCantidad'])->name('carrito.cantidad');

    // Envios!!
    Route::get('/envios', [EnviosController::class, 'create'])->name('envios');
    Route::post('/envios', [EnviosController::class, 'store'])->name('envios.store');
});