<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'nombre_usuario' => 'required',
            'contrasena' => 'required',
        ]);

        $usuario = Usuario::where('nombre_usuario', $request->nombre_usuario)->first();

        if ($usuario && Hash::check($request->contrasena, $usuario->contrasena)) {
            session(['usuario' => $usuario]);

            return redirect()->route('panel');
        }

        return back()->withErrors(['nombre_usuario' => 'Credenciales incorrectas']);
    }

    public function panel()
    {
        $usuario = session('usuario');

        if ($usuario->rol === 'administrador') {
            return view('panel.admin');
        }

        return view('panel.secretario');
    }


    public function logout(Request $request) {
        session()->flush();
        return redirect()->route('login');
    }

    //recuperar la contraseña
    public function showResetForm()
    {
        return view('auth.recuperar');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'correo_electronico' => 'required|email',
        ]);

        $usuario = Usuario::where('correo_electronico', $request->correo_electronico)->first();

        if (!$usuario) {
            return back()->with('error', 'No se encontró un usuario con ese correo.');
        }

        $nueva = Str::random(8);
        $usuario->contrasena = Hash::make($nueva);
        $usuario->save();

        return back()->with('success', "Tu nueva contraseña temporal es: {$nueva}");
    }
}
