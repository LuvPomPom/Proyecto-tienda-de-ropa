<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function procesarCompra(Request $request)
    {
        $carritoSesion = session()->get('carrito', []);

        if (empty($carritoSesion)) {
            return redirect()->route('index')->with('error', 'El carrito está vacío.');
        }

        // Validación estricta con los campos mapeados
        $validated = $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email'    => 'required|email|max:150',
            'fec_nac'  => 'required|date',
            'telf'     => 'required|string|max:25',
            'direc'    => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // 1. Insertar el cliente en Supabase
            $cliente = Cliente::create([
                'nombre'   => $validated['nombre'],
                'apellido' => $validated['apellido'],
                'email'    => $validated['email'],
                'fec_nac'  => $validated['fec_nac'],
                'telf'     => $validated['telf'],
                'direc'    => $validated['direc'],
            ]);

            // 2. Insert cabecera de carrito
            $carritoId = DB::table('carrito')->insertGetId([
                'usuario_id' => Auth::id() ?? 1,
            ]);

            $totalAcumulado = 0;

            // 3. Insertar items, actualizar stock
            foreach ($carritoSesion as $idProducto => $item) {
                $producto = Producto::where('id_producto', $idProducto)->lockForUpdate()->first();

                if (!$producto || $producto->stock < $item['cantidad']) {
                    DB::rollBack();
                    return redirect()->route('carrito.index')->with(
                        'error', 
                        'Stock insuficiente para el producto seleccionado.'
                    );
                }

                DB::table('detalle_carrito')->insert([
                    'carrito_id'  => $carritoId,
                    'producto_id' => $idProducto,
                    'cantidad'    => $item['cantidad'],
                ]);

                $producto->stock -= $item['cantidad'];
                $producto->save();

                $totalAcumulado += $item['precio'] * $item['cantidad'];
            }

            // 4. Insertar venta asociada al cliente y al carrito
            DB::table('ventas')->insert([
                'cliente_id'  => $cliente->id,
                'fecha_venta' => now(),
                'total'       => $totalAcumulado,
                'forma_pago'  => $request->input('forma_pago', 1),
                'carrito'     => $carritoId,
            ]);

            DB::commit();

            session()->forget('carrito');

            return redirect()->route('index')->with('success', '¡Compra procesada con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error en Supabase: ' . $e->getMessage());
        }
    }
}