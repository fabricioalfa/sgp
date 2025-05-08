<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use Illuminate\Http\Request;

class IngresoController extends Controller
{
    // Mostrar todos los ingresos
    public function index()
    {
        $ingresos = Ingreso::all();
        return view('finanzas.ingresos.index', compact('ingresos'));
    }

    // Mostrar el formulario de creación de ingreso
    public function create()
    {
        return view('finanzas.ingresos.create');
    }

    // Almacenar un nuevo ingreso
    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'tipo_ingreso' => 'required|string',
            'id_usuario_registro' => 'required|integer'
        ]);

        Ingreso::create($request->all());

        return redirect()->route('finanzas.ingresos.index')->with('success', 'Ingreso registrado correctamente');
    }

    // Mostrar los detalles de un ingreso
    public function show($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        return view('finanzas.ingresos.show', compact('ingreso'));
    }

    // Mostrar formulario de edición de un ingreso
    public function edit($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        return view('finanzas.ingresos.edit', compact('ingreso'));
    }

    // Actualizar un ingreso
    public function update(Request $request, $id)
    {
        $request->validate([
            'monto' => 'required|numeric',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'tipo_ingreso' => 'required|string',
            'id_usuario_registro' => 'required|integer'
        ]);

        $ingreso = Ingreso::findOrFail($id);
        $ingreso->update($request->all());

        return redirect()->route('finanzas.ingresos.index')->with('success', 'Ingreso actualizado correctamente');
    }

    // Eliminar un ingreso
    public function destroy($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->delete();

        return redirect()->route('finanzas.ingresos.index')->with('success', 'Ingreso eliminado correctamente');
    }
}
