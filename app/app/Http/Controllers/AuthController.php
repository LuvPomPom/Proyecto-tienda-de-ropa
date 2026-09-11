<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    // log in
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

    
        $usuario = Usuario::where('email', $request->email)
                          ->where('pass', $request->password)
                          ->first();

        if ($usuario) {
            // Logueo de usuario directamente en la sesión
            Auth::login($usuario);
            $request->session()->regenerate();

            // Redirección por Rol (1 = Admin)
            if ($usuario->rol_id == 1) {
                return redirect()->route('admin.dashboard');
            }

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'El correo o la contraseña son incorrectos.'
        ])->withInput();
    }

    // user register
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6'
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'pass' => $request->password,

            // Rol cliente
            'rol_id' => 2,
        ]);

    // automatically log in
        Auth::login($usuario);

        $request->session()->regenerate();

        return redirect('/');
    }


    // log out
    public function logout(Request $request)
    {
        Auth::logout(); //
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}