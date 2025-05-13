<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PanelController extends Controller
{
    // Mostrar el panel principal y la información del perfil de usuario
    public function index()
    {
        // Obtenemos el usuario de la sesión (asumimos que tienes la sesión de usuario en 'usuario')
        $usuario = session('usuario');

        // Si no hay un usuario en la sesión, redirigir al login
        if (!$usuario) {
            return redirect()->route('login');
        }

        // Pasamos la variable usuario a la vista del panel
        return view('panel.index', compact('usuario'));
    }

    // Mostrar la vista para cambiar la contraseña
    public function showChangePassword()
    {
        return view('panel.cambiar-contrasena');
    }

    // Actualizar la contraseña del usuario
    public function updatePassword(Request $request)
    {
        // Validación de la nueva contraseña
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

        // Buscar el usuario actual
        $usuario = Usuario::find(session('usuario')->id_usuario);

        // Verificar si la contraseña actual es correcta
        if (!Hash::check($request->contrasena_actual, $usuario->contrasena)) {
            return back()->withErrors(['contrasena_actual' => 'La contraseña actual es incorrecta.']);
        }

        // Actualizar la contraseña
        $usuario->contrasena = Hash::make($request->nueva_contrasena);
        $usuario->save();

        // Redirigir de vuelta con un mensaje de éxito
        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}