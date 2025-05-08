<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use Illuminate\Http\Request;

class EgresoController extends Controller
{
    // Mostrar todos los egresos
    public function index()
    {
        $egresos = Egreso::all();
        return view('finanzas.egresos.index', compact('egresos'));
    }

    // Mostrar el formulario de creación de egreso
    public function create()
    {
        return view('finanzas.egresos.create');
    }

    // Almacenar un nuevo egreso
    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'categoria' => 'required|string',
            'id_usuario_autorizador' => 'required|integer'
        ]);

        Egreso::create($request->all());

        return redirect()->route('finanzas.egresos.index')->with('success', 'Egreso registrado correctamente');
    }

    // Mostrar los detalles de un egreso
    public function show($id)
    {
        $egreso = Egreso::findOrFail($id);
        return view('finanzas.egresos.show', compact('egreso'));
    }

    // Mostrar formulario de edición de un egreso
    public function edit($id)
    {
        $egreso = Egreso::findOrFail($id);
        return view('finanzas.egresos.edit', compact('egreso'));
    }

    // Actualizar un egreso
    public function update(Request $request, $id)
    {
        $request->validate([
            'monto' => 'required|numeric',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'categoria' => 'required|string',
            'id_usuario_autorizador' => 'required|integer'
        ]);

        $egreso = Egreso::findOrFail($id);
        $egreso->update($request->all());

        return redirect()->route('finanzas.egresos.index')->with('success', 'Egreso actualizado correctamente');
    }

    // Eliminar un egreso
    public function destroy($id)
    {
        $egreso = Egreso::findOrFail($id);
        $egreso->delete();

        return redirect()->route('finanzas.egresos.index')->with('success', 'Egreso eliminado correctamente');
    }
}
