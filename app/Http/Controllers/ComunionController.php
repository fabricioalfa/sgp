<?php

namespace App\Http\Controllers;

use App\Models\PrimeraComunion;
use App\Models\Sacramento;
use Illuminate\Http\Request;

class ComunionController extends Controller
{
    public function index()
    {
        $comuniones = PrimeraComunion::with('sacramento')->get();
        return view('comuniones.index', compact('comuniones'));
    }

    public function create()
    {
        return view('comuniones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'iglesia' => 'required|string',
            'nombre_padre' => 'required|string',
            'apellido_paterno_padre' => 'required|string',
            'apellido_materno_padre' => 'required|string',
            'nombre_madre' => 'required|string',
            'apellido_paterno_madre' => 'required|string',
            'apellido_materno_madre' => 'required|string',
            'nombre_padrino' => 'required|string',
            'apellido_paterno_padrino' => 'required|string',
            'apellido_materno_padrino' => 'required|string',
            'nombre_madrina' => 'required|string',
            'apellido_paterno_madrina' => 'required|string',
            'apellido_materno_madrina' => 'required|string',
        ]);

        // Crear el sacramento
        $sacramento = new Sacramento([
            'tipo_sacramento' => 'comunion',
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

        PrimeraComunion::create([
            'id_sacramento' => $sacramento->id_sacramento,
            'iglesia' => $request->iglesia,
            'nombre_padre' => $request->nombre_padre,
            'apellido_paterno_padre' => $request->apellido_paterno_padre,
            'apellido_materno_padre' => $request->apellido_materno_padre,
            'nombre_madre' => $request->nombre_madre,
            'apellido_paterno_madre' => $request->apellido_paterno_madre,
            'apellido_materno_madre' => $request->apellido_materno_madre,
            'nombre_padrino' => $request->nombre_padrino,
            'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
            'apellido_materno_padrino' => $request->apellido_materno_padrino,
            'nombre_madrina' => $request->nombre_madrina,
            'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
            'apellido_materno_madrina' => $request->apellido_materno_madrina,
        ]);

        return redirect()->route('comuniones.index')->with('success', 'Primera Comunión registrada correctamente.');
    }

    public function edit($id)
    {
        $comunion = PrimeraComunion::findOrFail($id);
        return view('comuniones.edit', compact('comunion'));
    }

    public function update(Request $request, $id)
    {
        $comunion = PrimeraComunion::findOrFail($id);

        $request->validate([
            'iglesia' => 'required|string',
            'nombre_padre' => 'required|string',
            'apellido_paterno_padre' => 'required|string',
            'apellido_materno_padre' => 'required|string',
            'nombre_madre' => 'required|string',
            'apellido_paterno_madre' => 'required|string',
            'apellido_materno_madre' => 'required|string',
            'nombre_padrino' => 'required|string',
            'apellido_paterno_padrino' => 'required|string',
            'apellido_materno_padrino' => 'required|string',
            'nombre_madrina' => 'required|string',
            'apellido_paterno_madrina' => 'required|string',
            'apellido_materno_madrina' => 'required|string',
        ]);

        $comunion->update($request->all());

        return redirect()->route('comuniones.index')->with('success', 'Primera Comunión actualizada correctamente.');
    }

    public function destroy($id)
    {
        PrimeraComunion::findOrFail($id)->delete();
        return redirect()->route('comuniones.index')->with('success', 'Primera Comunión eliminada correctamente.');
    }
}
