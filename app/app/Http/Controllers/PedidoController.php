<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function procesarCompra(Request $request)
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('index')->with('error', 'El carrito está vacío.');
        }

        // 1. Validar los datos de entrada
        $validated = $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula'   => 'required|string|max:8',
            'fec_nac'  => 'required|date',
            'telf'     => 'required|string|max:25',
            'direc'    => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // 2. Registrar el cliente asignando 'cedula' a la columna 'ci' de Supabase
            Cliente::create([
                'nombre'   => $validated['nombre'],
                'apellido' => $validated['apellido'],
                'ci'       => $validated['cedula'], // Mapeo a la columna 'ci'
                'fec_nac'  => $validated['fec_nac'],
                'telf'     => $validated['telf'],
                'direc'    => $validated['direc'],
            ]);

            // 3. Verificar y descontar stock
            foreach ($carrito as $id => $item) {
                $producto = Producto::where('id_producto', $id)->lockForUpdate()->first();

                if (!$producto || $producto->stock < $item['cantidad']) {
                    DB::rollBack();
                    return redirect()->route('carrito.index')->with(
                        'error', 
                        'No hay suficiente stock para el producto: ' . ($producto->nombre ?? 'Seleccionado')
                    );
                }

                $producto->stock -= $item['cantidad'];
                $producto->save();
            }

            DB::commit();

            // 4. Vaciar carrito
            session()->forget('carrito');

            return redirect()->route('index')->with('success', '¡Gracias por su compra! El envío ha sido registrado y el stock actualizado.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al procesar el pedido: ' . $e->getMessage());
        }
    }
}