<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    public function editar()
    {
        $usuario = session('usuario');
        return view('perfil.editar', compact('usuario'));
    }

    public function actualizar(Request $request)
    {
        $usuario = Usuario::findOrFail(session('usuario')->id_usuario);

        $request->validate([
            'nombre_usuario' => [
                'required',
                Rule::unique('usuarios')->ignore($usuario->id_usuario, 'id_usuario'),
            ],
            'contrasena' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
            'nombres' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'correo_electronico' => 'nullable|email|max:100',
            'telefono' => 'nullable|string|max:20',
        ], [
            'contrasena.regex' => 'La contraseña debe contener al menos una letra mayúscula, una minúscula, un número y un carácter especial.'
        ]);

        $usuario->nombre_usuario     = $request->nombre_usuario;
        $usuario->nombres            = $request->nombres;
        $usuario->apellido_paterno  = $request->apellido_paterno;
        $usuario->apellido_materno  = $request->apellido_materno;
        $usuario->correo_electronico = $request->correo_electronico;
        $usuario->telefono           = $request->telefono;

        if ($request->filled('contrasena')) {
            $usuario->contrasena = Hash::make($request->contrasena);
        }

        $usuario->save();
        session(['usuario' => $usuario]);

        return redirect()->route('panel')->with('success', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'contrasena' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ]
        ], [
            'contrasena.regex' => 'La contraseña debe contener al menos una letra mayúscula, una minúscula, un número y un carácter especial.',
            'contrasena.confirmed' => 'Las contraseñas no coinciden.'
        ]);

        $usuario = Usuario::findOrFail(session('usuario')->id_usuario);
        $usuario->contrasena = Hash::make($request->contrasena);
        $usuario->save();

        return redirect()->route('panel')->with('success', 'Contraseña actualizada correctamente.');
    }
}
