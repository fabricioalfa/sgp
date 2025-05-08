<?php

namespace App\Http\Controllers;

use App\Models\Rrhh;
use Illuminate\Http\Request;

class RrhhController extends Controller
{
    public function index()
    {
        $rrhh = Rrhh::all();
        return view('rrhh.index', compact('rrhh'));
    }

    public function create()
    {
        return view('rrhh.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'cargo' => 'required|string',
            'fecha_ingreso' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_ingreso',
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
            'sueldo' => 'nullable|numeric',
            'estado' => 'required|in:activo,inactivo',
        ]);

        Rrhh::create([
            'nombres' => $request->nombres,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'cargo' => $request->cargo,
            'fecha_ingreso' => $request->fecha_ingreso,
            'fecha_fin' => $request->fecha_fin,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'sueldo' => $request->sueldo,
            'estado' => $request->estado,
            'observaciones' => $request->observaciones,
            'asignado_por' => session('usuario')->id_usuario,
        ]);

        return redirect()->route('rrhh.index')->with('success', 'Personal registrado correctamente.');
    }

    public function edit(Rrhh $rrhh)
    {
        return view('rrhh.edit', compact('rrhh'));
    }

    public function update(Request $request, Rrhh $rrhh)
    {
        $request->validate([
            'nombres' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'cargo' => 'required|string',
            'fecha_ingreso' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_ingreso',
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
            'sueldo' => 'nullable|numeric',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $rrhh->update([
            'nombres' => $request->nombres,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'cargo' => $request->cargo,
            'fecha_ingreso' => $request->fecha_ingreso,
            'fecha_fin' => $request->fecha_fin,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'sueldo' => $request->sueldo,
            'estado' => $request->estado,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('rrhh.index')->with('success', 'Datos actualizados correctamente.');
    }

    public function destroy(Rrhh $rrhh)
    {
        $rrhh->delete();
        return redirect()->route('rrhh.index')->with('success', 'Registro eliminado correctamente.');
    }

    // Removed the asignador method as it belongs to the Rrhh model

}
