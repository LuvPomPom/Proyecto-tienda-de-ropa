<?php


namespace App\Http\Controllers;


use App\Models\Cliente;
use Illuminate\Http\Request;


class EnviosController extends Controller
{
    // 1. Muestra la pantalla del formulario
    public function create()
    {
        return view('envios');
    }


    // 2. Recibe y procesa los datos del formulario
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre'   => 'required|string|max:100',
                'apellido' => 'required|string|max:100',
                'cedula'   => 'required|digits_between:7,8',
                'fec_nac'  => 'required|date',
                'telf'     => 'required|string|max:25',
                'direc'    => 'required|string|max:255',
            ]);


            $cliente = Cliente::create([
                'nombre'   => $validated['nombre'],
                'apellido' => $validated['apellido'],
                'cedula'   => $validated['cedula'],
                'fec_nac'  => $validated['fec_nac'],
                'telf'     => $validated['telf'],
                'direc'    => $validated['direc'],
            ]);


            return response()->json([
                'success' => true,
                'message' => 'Cliente guardado con éxito',
                'cliente' => $cliente
            ], 201);


        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Error al procesar la solicitud',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}