<?php

use Illuminate\Support\Facades\Route;

// Ruta del Inicio (Tienda pública)
Route::get('/', function () {
    return view('welcome');
});