<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'correo_electronico' => 'required|email|unique:usuarios,correo_electronico',
            'contrasena' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',      // minúscula
                'regex:/[A-Z]/',      // mayúscula
                'regex:/[0-9]/',      // número
                'regex:/[@$!%*#?&]/'  // especial
            ],
            'nombres' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'nullable',
            'telefono' => 'nullable',
            'rol' => 'required|in:administrador,secretario',
            'estado' => 'required|in:activo,inactivo',
        ]);

        Usuario::create([
            'correo_electronico' => $request->correo_electronico,
            'contrasena' => Hash::make($request->contrasena),
            'nombres' => $request->nombres,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'telefono' => $request->telefono,
            'rol' => $request->rol,
            'estado' => $request->estado,
            'fecha_registro' => now(),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'correo_electronico' => 'required|email|unique:usuarios,correo_electronico,' . $usuario->id_usuario . ',id_usuario',
            'nombres' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'nullable',
            'telefono' => 'nullable',
            'rol' => 'required|in:administrador,secretario',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $usuario->update($request->only([
            'correo_electronico',
            'nombres',
            'apellido_paterno',
            'apellido_materno',
            'telefono',
            'rol',
            'estado',
        ]));

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}
