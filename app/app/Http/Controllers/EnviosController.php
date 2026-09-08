<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;

class EnviosController extends Controller
{
    public function create()
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('index')->with('error', 'El carrito está vacío.');
        }

        return view('envios');
    }

    public function store(Request $request)
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('index')->with('error', 'El carrito está vacío.');
        }

        $validated = $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula'   => 'required|string|max:8',
            'fec_nac'  => 'required|date',
            'telf'     => 'required|string|max:25',
            'direc'    => 'required|string|max:255',
        ]);

        // 1. Guardar datos del cliente
        Cliente::create([
            'nombre'   => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'cedula'   => $validated['cedula'],
            'fec_nac'  => $validated['fec_nac'],
            'telf'     => $validated['telf'],
            'direc'    => $validated['direc'],
        ]);

        // 2. Descontar stock figurativo de cada producto en el carrito
        foreach ($carrito as $id => $item) {
            $producto = Producto::find($id);
            if ($producto) {
                $producto->stock = max(0, $producto->stock - $item['cantidad']);
                $producto->save();
            }
        }

        // 3. Vaciar el carrito de la sesión
        session()->forget('carrito');

        // 4. Redirigir a la raíz (/) con mensaje de agradecimiento
        return redirect()->route('index')->with('success', '¡Gracias por su compra! El envío ha sido registrado con éxito.');
    }
}