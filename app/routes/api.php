<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

// Ruta para obtener datos del usuario autenticado
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas de Productos
Route::get('/productos', [ProductoController::class, 'index']);  // Buscar/obtener productos
Route::post('/productos', [ProductoController::class, 'store']); // Guardar nuevo producto