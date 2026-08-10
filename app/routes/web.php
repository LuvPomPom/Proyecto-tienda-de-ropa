<?php

use Illuminate\Support\Facades\Route;

// Ruta del Inicio (Tienda pública)
Route::get('/', function () {
    return view('welcome');
});


//RUTA PARA EL PANEL DE ADMIN:
Route::get('/admin', function () {
    return view('admin.admin'); // Carga resources/views/admin/admin.blade.php
});