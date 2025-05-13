<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class PerfilController extends Controller
{
    public function index()
    {
        $usuario = session('usuario');
        return view('perfil.index', compact('usuario'));
    }

    public function showChangePassword()
    {
        return view('perfil.cambiar-contrasena');
    }

    public function updatePassword(Request $request)
    {
        // Validación de campos
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

        // Obtener el usuario desde la sesión
        $usuario = Usuario::find(session('usuario')->id_usuario);

        // Verificar si la contraseña actual es correcta
        if (!Hash::check($request->contrasena_actual, $usuario->contrasena)) {
            return back()->withErrors(['contrasena_actual' => 'La contraseña actual es incorrecta.']);
        }

        // Actualizar la contraseña
        $usuario->contrasena = Hash::make($request->nueva_contrasena);
        $usuario->save();

        // Redirigir con mensaje de éxito
        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}