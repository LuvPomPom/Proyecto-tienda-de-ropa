<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session()->get('carrito', []);
        $total = 0;

        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('carrito', compact('carrito', 'total'));
    }

    public function agregar(Request $request, $id)
    {
        // Eloquent usará 'id_producto' automáticamente gracias al $primaryKey de tu modelo
        $producto = Producto::findOrFail($id);
        $carrito = session()->get('carrito', []);

        $cantidadDeseada = isset($carrito[$id]) ? $carrito[$id]['cantidad'] + 1 : 1;

        if ($cantidadDeseada > $producto->stock) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible.');
        }

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
        } else {
            $carrito[$id] = [
                "id" => $producto->id_producto, // CORREGIDO: Usar id_producto
                "nombre" => $producto->nombre,
                "cantidad" => 1,
                "precio" => $producto->precio,
                "imagen" => $producto->imagen
            ];
        }

        session()->put('carrito', $carrito);
        return redirect()->back()->with('success', 'Producto agregado al carrito.');
    }

    public function cambiarCantidad(Request $request, $id)
    {
        $producto = Producto::find($id);
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $operacion = $request->input('operacion');

            if ($operacion === 'sumar') {
                if ($producto && ($carrito[$id]['cantidad'] + 1) > $producto->stock) {
                    return redirect()->back()->with('error', 'Límite de stock alcanzado.');
                }
                $carrito[$id]['cantidad']++;
            } elseif ($operacion === 'restar') {
                $carrito[$id]['cantidad']--;
                if ($carrito[$id]['cantidad'] <= 0) {
                    unset($carrito[$id]);
                }
            }
            session()->put('carrito', $carrito);
        }

        return redirect()->back();
    }
}