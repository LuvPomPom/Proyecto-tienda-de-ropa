<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto; // O el modelo que usen para productos

class CarritoController extends Controller
{
    // Mostrar la vista del carrito con los totales
    public function index()
    {
        $carrito = session()->get('carrito', []);
        $total = 0;

        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('carrito', compact('carrito', 'total'));
    }

    // Agregar producto al carrito
    public function agregar(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
        } else {
            $carrito[$id] = [
                "id" => $producto->id,
                "nombre" => $producto->nombre,
                "cantidad" => 1,
                "precio" => $producto->precio,
                "imagen" => $producto->imagen
            ];
        }

        session()->put('carrito', $carrito);
        return redirect()->back()->with('success', 'Producto agregado');
    }

    // Sumar o restar cantidad
    public function cambiarCantidad(Request $request, $id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $operacion = $request->input('operacion'); // 'sumar' o 'restar'

            if ($operacion === 'sumar') {
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