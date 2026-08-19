<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::query();

        if ($request->has('buscar') && !empty($request->buscar)) {
            $buscar = mb_strtolower($request->buscar);
            $query->whereRaw('LOWER(nombre) LIKE ?', ["%{$buscar}%"]);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'   => 'required|string|max:255',
            'precio'   => 'required|numeric|min:0',
            'marca_id' => 'required|integer',
            'imagen'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Acepta fotos
            'categoria_id' => 'required|integer',
            'stock' => 'required|integer'
        ]);

$producto = Producto::create([
            'nombre'   => $validated['nombre'],
            'precio'   => $validated['precio'],
            'marca_id' => $validated['marca_id'],
            'imagen'   => null,
            'categoria_id' => $validated['categoria_id'],
            'stock' => $validated['stock']
        ]);

        // Si enviaron una foto, la guarda en la carpeta public/imgs
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


// NUEVO MÉTODO: Para cargar la vista web con las categorías
  public function categoria($nombre = 'todas')
{
    $query = Producto::query();

    // Mapeo exacto basado en la tabla public.categorias de Supabase
    $categoriasMap = [
        'hombre'     => 1,
        'mujer'      => 2,
        'unisex'     => 3,
        'calzado'    => 4,
        'ropa'       => 5,
        'accesorios' => 6,
    ];

    $nombreLimpio = strtolower($nombre);

    if ($nombreLimpio !== 'todas') {
        if (isset($categoriasMap[$nombreLimpio])) {
            $query->where('categoria_id', $categoriasMap[$nombreLimpio]);
        } elseif (is_numeric($nombre)) {
            $query->where('categoria_id', $nombre);
        }
    }

    $productos = $query->get();

    return view('index', [
        'productos'       => $productos,
        'categoriaActual' => $nombre
    ]);
}

}