<?php

namespace App\Http\Controllers;

use App\Models\Matrimonio;
use App\Models\Sacramento;
use Illuminate\Http\Request;

class MatrimonioController extends Controller
{
    public function index()
    {
        $matrimonios = Matrimonio::with('sacramento')->get();
        return view('matrimonios.index', compact('matrimonios'));
    }

    public function create()
    {
        return view('matrimonios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_novio' => 'required|string',
            'apellido_paterno_novio' => 'required|string',
            'apellido_materno_novio' => 'required|string',
            'nombre_novia' => 'required|string',
            'apellido_paterno_novia' => 'required|string',
            'apellido_materno_novia' => 'required|string',
            'nombre_testigo1' => 'required|string',
            'apellido_paterno_testigo1' => 'required|string',
            'apellido_materno_testigo1' => 'required|string',
            'nombre_testigo2' => 'required|string',
            'apellido_paterno_testigo2' => 'required|string',
            'apellido_materno_testigo2' => 'required|string',
        ]);

        // Crear el sacramento
        $sacramento = new Sacramento([
            'tipo_sacramento' => 'matrimonio',
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'lugar' => $request->lugar,
            'nombre_receptor' => $request->nombre_novio,
            'apellido_paterno' => $request->apellido_paterno_novio,
            'apellido_materno' => $request->apellido_materno_novio,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'sexo' => 'M',  // En este caso, estamos asumiendo que el novio es hombre
            'id_usuario_registro' => session('usuario')->id_usuario,
        ]);
        $sacramento->save();

        Matrimonio::create([
            'id_sacramento' => $sacramento->id_sacramento,
            'nombre_novio' => $request->nombre_novio,
            'apellido_paterno_novio' => $request->apellido_paterno_novio,
            'apellido_materno_novio' => $request->apellido_materno_novio,
            'nombre_novia' => $request->nombre_novia,
            'apellido_paterno_novia' => $request->apellido_paterno_novia,
            'apellido_materno_novia' => $request->apellido_materno_novia,
            'iglesia' => $request->iglesia,
            'nombre_testigo1' => $request->nombre_testigo1,
            'apellido_paterno_testigo1' => $request->apellido_paterno_testigo1,
            'apellido_materno_testigo1' => $request->apellido_materno_testigo1,
            'nombre_testigo2' => $request->nombre_testigo2,
            'apellido_paterno_testigo2' => $request->apellido_paterno_testigo2,
            'apellido_materno_testigo2' => $request->apellido_materno_testigo2,
            'nombre_padrino' => $request->nombre_padrino,
            'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
            'apellido_materno_padrino' => $request->apellido_materno_padrino,
            'nombre_madrina' => $request->nombre_madrina,
            'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
            'apellido_materno_madrina' => $request->apellido_materno_madrina,
        ]);

        return redirect()->route('matrimonios.index')->with('success', 'Matrimonio registrado correctamente.');
    }

    public function edit($id)
    {
        $matrimonio = Matrimonio::findOrFail($id);
        return view('matrimonios.edit', compact('matrimonio'));
    }

    public function update(Request $request, $id)
    {
        $matrimonio = Matrimonio::findOrFail($id);

        $request->validate([
            'nombre_novio' => 'required|string',
            'apellido_paterno_novio' => 'required|string',
            'apellido_materno_novio' => 'required|string',
            'nombre_novia' => 'required|string',
            'apellido_paterno_novia' => 'required|string',
            'apellido_materno_novia' => 'required|string',
            'nombre_testigo1' => 'required|string',
            'apellido_paterno_testigo1' => 'required|string',
            'apellido_materno_testigo1' => 'required|string',
            'nombre_testigo2' => 'required|string',
            'apellido_paterno_testigo2' => 'required|string',
            'apellido_materno_testigo2' => 'required|string',
        ]);

        $matrimonio->update($request->all());

        return redirect()->route('matrimonios.index')->with('success', 'Matrimonio actualizado correctamente.');
    }

    public function destroy($id)
    {
        Matrimonio::findOrFail($id)->delete();
        return redirect()->route('matrimonios.index')->with('success', 'Matrimonio eliminado correctamente.');
    }
}
