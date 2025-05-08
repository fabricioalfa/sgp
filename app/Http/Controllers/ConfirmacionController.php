<?php

namespace App\Http\Controllers;

use App\Models\Confirmacion;
use App\Models\Sacramento;
use Illuminate\Http\Request;

class ConfirmacionController extends Controller
{
    public function index()
    {
        $confirmaciones = Confirmacion::with('sacramento')->get();
        return view('confirmaciones.index', compact('confirmaciones'));
    }

    public function create()
    {
        return view('confirmaciones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'obispo' => 'required|string',
            'nombre_padrino' => 'required|string',
            'apellido_paterno_padrino' => 'required|string',
            'apellido_materno_padrino' => 'required|string',
            'nombre_madrina' => 'required|string',
            'apellido_paterno_madrina' => 'required|string',
            'apellido_materno_madrina' => 'required|string',
        ]);

        // Crear el sacramento
        $sacramento = new Sacramento([
            'tipo_sacramento' => 'confirmacion',
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'lugar' => $request->lugar,
            'nombre_receptor' => $request->nombre_receptor,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'sexo' => $request->sexo,
            'id_usuario_registro' => session('usuario')->id_usuario,
        ]);
        $sacramento->save();

        Confirmacion::create([
            'id_sacramento' => $sacramento->id_sacramento,
            'obispo' => $request->obispo,
            'nombre_padrino' => $request->nombre_padrino,
            'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
            'apellido_materno_padrino' => $request->apellido_materno_padrino,
            'nombre_madrina' => $request->nombre_madrina,
            'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
            'apellido_materno_madrina' => $request->apellido_materno_madrina,
        ]);

        return redirect()->route('confirmaciones.index')->with('success', 'Confirmación registrada correctamente.');
    }

    public function edit($id)
    {
        $confirmacion = Confirmacion::findOrFail($id);
        return view('confirmaciones.edit', compact('confirmacion'));
    }

    public function update(Request $request, $id)
    {
        $confirmacion = Confirmacion::findOrFail($id);

        $request->validate([
            'obispo' => 'required|string',
            'nombre_padrino' => 'required|string',
            'apellido_paterno_padrino' => 'required|string',
            'apellido_materno_padrino' => 'required|string',
            'nombre_madrina' => 'required|string',
            'apellido_paterno_madrina' => 'required|string',
            'apellido_materno_madrina' => 'required|string',
        ]);

        $confirmacion->update($request->all());

        return redirect()->route('confirmaciones.index')->with('success', 'Confirmación actualizada correctamente.');
    }

    public function destroy($id)
    {
        Confirmacion::findOrFail($id)->delete();
        return redirect()->route('confirmaciones.index')->with('success', 'Confirmación eliminada correctamente.');
    }
}
