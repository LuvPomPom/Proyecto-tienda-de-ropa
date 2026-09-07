<?php


namespace App\Http\Controllers;


use App\Models\Producto;
use Illuminate\Http\Request;


class ProductoController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'       => 'required|string|max:255',
            'precio'       => 'required|numeric|min:0',
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'categoria_id' => 'required|integer',
            'stock'        => 'required|integer|min:0'
        ]);


        $producto = Producto::create([
            'nombre'       => $validated['nombre'],
            'precio'       => $validated['precio'],
            'imagen'       => null,
            'categoria_id' => $validated['categoria_id'],
            'stock'        => $validated['stock']
        ]);


        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = $producto->id_producto . '.' . $extension;
            $file->move(public_path('imgs/productos'), $nombreArchivo);
           
            $producto->update([
                'imagen' => 'imgs/productos/' . $nombreArchivo
            ]);
        }


        return redirect()->back()->with('success', 'Producto creado con éxito');
    }


    // --- MÉTODO PARA ACTUALIZAR PRECIO Y DATOS DEL PRODUCTO ---
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);


        $validated = $request->validate([
            'nombre'       => 'required|string|max:255',
            'precio'       => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'categoria_id' => 'required|integer',
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);


        // Actualizar datos básicos en la base de datos
        $producto->update([
            'nombre'       => $validated['nombre'],
            'precio'       => $validated['precio'],
            'stock'        => $validated['stock'],
            'categoria_id' => $validated['categoria_id'],
        ]);


        return redirect()->back()->with('success', 'Producto actualizado con éxito');
    }


    public function categoria($nombre = 'todas')
    {
        $query = Producto::query();


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