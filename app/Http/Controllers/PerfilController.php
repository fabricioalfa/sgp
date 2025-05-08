<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class PerfilController extends Controller
{
    public function showChangePassword()
    {
        return view('perfil.cambiar-contrasena');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'contrasena_actual' => 'required',
            'nueva_contrasena' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',      // minúscula
                'regex:/[A-Z]/',      // mayúscula
                'regex:/[0-9]/',      // número
                'regex:/[@$!%*#?&]/', // especial
                'confirmed'
            ],
        ]);

        $usuario = Usuario::find(session('usuario')->id_usuario);

        if (!Hash::check($request->contrasena_actual, $usuario->contrasena)) {
            return back()->withErrors(['contrasena_actual' => 'La contraseña actual es incorrecta.']);
        }

        $usuario->contrasena = Hash::make($request->nueva_contrasena);
        $usuario->save();

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}
