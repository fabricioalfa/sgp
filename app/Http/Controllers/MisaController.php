<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sacramento;
use App\Models\Bautizo;
use App\Models\PrimeraComunion;
use App\Models\Confirmacion;
use App\Models\Matrimonio;

class SacramentoController extends Controller
{
    public function index()
    {
        $sacramentos = Sacramento::orderBy('fecha', 'desc')->get();
        return view('sacramentos.index', compact('sacramentos'));
    }

    public function create()
    {
        return view('sacramentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_sacramento'    => 'required|in:bautizo,comunion,confirmacion,matrimonio',
            'fecha'              => 'required|date',
            'hora'               => 'required',
            'lugar'              => 'required|string|max:100',
            'nombre_receptor'    => 'required|string|max:100',
            'apellido_paterno'   => 'required|string|max:100',
            'apellido_materno'   => 'nullable|string|max:100',
            'fecha_nacimiento'   => 'nullable|date',
            'sexo'               => 'required|in:M,F'
        ]);

        // Guardar sacramento base y asignar el ID del usuario logueado desde la sesión
        $datos = $request->only([
            'tipo_sacramento', 'fecha', 'hora', 'lugar',
            'nombre_receptor', 'apellido_paterno', 'apellido_materno',
            'fecha_nacimiento', 'sexo'
        ]);
        $datos['id_usuario_registro'] = session('usuario')->id_usuario;

        $sacramento = Sacramento::create($datos);

        // Crear detalle según tipo
        switch ($request->tipo_sacramento) {
            case 'bautizo':
                Bautizo::create(['id_sacramento' => $sacramento->id_sacramento]);
                break;
            case 'comunion':
                PrimeraComunion::create(['id_sacramento' => $sacramento->id_sacramento]);
                break;
            case 'confirmacion':
                Confirmacion::create(['id_sacramento' => $sacramento->id_sacramento]);
                break;
            case 'matrimonio':
                Matrimonio::create(['id_sacramento' => $sacramento->id_sacramento]);
                break;
        }

        return redirect()->route('sacramentos.index')->with('success', 'Sacramento registrado correctamente.');
    }

    public function show(Sacramento $sacramento)
    {
        return view('sacramentos.show', compact('sacramento'));
    }

    public function edit(Sacramento $sacramento)
    {
        return view('sacramentos.edit', compact('sacramento'));
    }

    public function update(Request $request, Sacramento $sacramento)
    {
        $request->validate([
            'tipo_sacramento'    => 'required|in:bautizo,comunion,confirmacion,matrimonio',
            'fecha'              => 'required|date',
            'hora'               => 'required',
            'lugar'              => 'required|string|max:100',
            'nombre_receptor'    => 'required|string|max:100',
            'apellido_paterno'   => 'required|string|max:100',
            'apellido_materno'   => 'nullable|string|max:100',
            'fecha_nacimiento'   => 'nullable|date',
            'sexo'               => 'required|in:M,F'
        ]);

        $sacramento->update($request->only([
            'tipo_sacramento', 'fecha', 'hora', 'lugar',
            'nombre_receptor', 'apellido_paterno', 'apellido_materno',
            'fecha_nacimiento', 'sexo'
        ]));

        return redirect()->route('sacramentos.index')->with('success', 'Sacramento actualizado correctamente.');
    }

    public function destroy(Sacramento $sacramento)
    {
        $sacramento->delete();
        return redirect()->route('sacramentos.index')->with('success', 'Sacramento eliminado correctamente.');
    }
}