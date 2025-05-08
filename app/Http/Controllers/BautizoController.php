<?php

namespace App\Http\Controllers;

use App\Models\Bautizo;
use App\Models\Sacramento;
use Illuminate\Http\Request;

class BautizoController extends Controller
{
    public function index()
    {
        $bautizos = Bautizo::with('sacramento')->get();
        return view('bautizos.index', compact('bautizos'));
    }

    public function create()
    {
        return view('bautizos.create');
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
            'sacerdote_celebrante' => 'required|string',
        ]);

        // Crear el bautizo con la relación al sacramento
        $sacramento = new Sacramento([
            'tipo_sacramento' => 'bautizo',
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

        Bautizo::create([
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
            'sacerdote_celebrante' => $request->sacerdote_celebrante,
        ]);

        return redirect()->route('bautizos.index')->with('success', 'Bautizo registrado correctamente.');
    }

    public function edit($id)
    {
        $bautizo = Bautizo::findOrFail($id);
        return view('bautizos.edit', compact('bautizo'));
    }

    public function update(Request $request, $id)
    {
        $bautizo = Bautizo::findOrFail($id);

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
            'sacerdote_celebrante' => 'required|string',
        ]);

        $bautizo->update($request->all());

        return redirect()->route('bautizos.index')->with('success', 'Bautizo actualizado correctamente.');
    }

    public function destroy($id)
    {
        Bautizo::findOrFail($id)->delete();
        return redirect()->route('bautizos.index')->with('success', 'Bautizo eliminado correctamente.');
    }
}
