<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Iniciar Sesión (Admin y Clientes)
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Valida email y compara la contraseña encriptada
        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();

            // Redirige al panel de admin o a la tienda según su rol
            if (Auth::user()->es_admin) {
                return redirect()->route('admin.dashboard'); 
            }

            return redirect()->route('catalogo');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    // 2. Registrar Usuario Común
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        // Se crea como cliente común (es_admin = false por defecto)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user); // Inicia sesión automáticamente tras registrarse

        return redirect()->route('catalogo');
    }

    // 3. Cerrar Sesión
    public function logout(Request $request)
    {
        Auth::logout(); //
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}