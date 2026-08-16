<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // O puedes usar tu Modelo si ya tienes uno

class TestController extends Controller
{
    public function guardar(Request $request)
    {
        // 1. Validar que el dato llegó
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // 2. Insertar directamente en la tabla de tu DB en Supabase
        // (Asegúrate de cambiar 'productos' por el nombre real de tu tabla)
        DB::table('producto')->insert([
            'nombre' => $request->input('nombre'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Redirigir de vuelta con un mensaje de éxito
        return back()->with('mensaje', '¡Dato guardado exitosamente en Supabase!');
    }
}