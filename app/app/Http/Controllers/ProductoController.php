<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Producto::query();

            if ($request->has('buscar') && !empty($request->buscar)) {
                $buscar = mb_strtolower($request->buscar);
                $query->where('nombre', 'ILIKE', "%{$buscar}%");
            }

            return response()->json($query->get(), 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error en la base de datos',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // 1. Quitamos 'marca_id' de las validaciones
        $validated = $request->validate([
            'nombre'       => 'required|string|max:255',
            'precio'       => 'required|numeric|min:0',
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'categoria_id' => 'required|integer',
            'stock'        => 'required|integer'
        ]);

        // 2. Quitamos 'marca_id' al crear el registro
        $producto = Producto::create([
            'nombre'       => $validated['nombre'],
            'precio'       => $validated['precio'],
            'imagen'       => null,
            'categoria_id' => $validated['categoria_id'],
            'stock'        => $validated['stock']
        ]);

        // Guardar imagen localmente si existe
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = $producto->id_producto . '.' . $extension;
            $file->move(public_path('imgs/productos'), $nombreArchivo);
            $rutaImagen = 'imgs/productos/' . $nombreArchivo;
            
            $producto->update([
                'imagen' => $rutaImagen
            ]);
        }

        return response()->json([
            'success'  => true,
            'message'  => 'Producto e imagen guardados con éxito',
            'producto' => $producto
        ], 201);
    }

    public function categoria($nombre = 'todas')
    {
        $query = Producto::query();

        // Mapeo simple de categorías para calzado
        $categoriasMap = [
            'deportivos' => 1,
            'urbanos'    => 2,
            'formales'   => 3,
        ];

        $nombreLimpio = strtolower($nombre);

        if ($nombreLimpio !== 'todas') {
            if (isset($categoriasMap[$nombreLimpio])) {
                $query->where('categoria_id', $categoriasMap[$nombreLimpio]);
            } elseif (is_numeric($nombre)) {
                $query->where('categoria_id', (int)$nombre);
            }
        }

        try {
            $productos = $query->get();
        } catch (\Exception $e) {
            $productos = collect(); 
        }

        return view('index', [
            'productos'       => $productos,
            'categoriaActual' => $nombre
        ]);
    }
}