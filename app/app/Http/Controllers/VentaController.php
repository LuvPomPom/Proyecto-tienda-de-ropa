<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function finalizarCompra(Request $request)
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->back()->with('error', 'El carrito está vacío');
        }

        // Usamos una transacción para asegurar que se guarde todo o nada
        DB::beginTransaction();

        try {
            // 1. Calcular el total
            $total = 0;
            foreach ($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            // 2. Crear la Venta
            $venta = Venta::create([
                'cliente_id' => Auth::id() ?? null, // Si usás autenticación
                'total' => $total,
                'estado' => 'completada'
            ]);

            // 3. Guardar el detalle de la venta y actualizar el stock
            foreach ($carrito as $id => $item) {
                VentaDetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item['precio'] * $item['cantidad']
                ]);

                // Descontar stock del producto
                $producto = Producto::find($id);
                if ($producto) {
                    $producto->decrement('stock', $item['cantidad']);
                }
            }

            DB::commit();

            // 4. Vaciar la sesión del carrito
            session()->forget('carrito');

            return redirect()->route('inicio')->with('success', '¡Compra realizada con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al procesar la compra: ' . $e->getMessage());
        }
    }
}