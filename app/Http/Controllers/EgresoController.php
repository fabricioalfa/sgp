<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class EgresoController extends Controller
{
    public function index()
    {
        $egresos = Egreso::all();
        return view('egresos.index', compact('egresos'));
    }

    public function create()
    {
        return view('egresos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'categoria' => 'nullable|string|max:100',
            'id_usuario_autorizador' => 'nullable|integer'
        ]);

        // Asignamos el id_usuario_autorizador desde la sesión
        $request->merge([
            'id_usuario_autorizador' => session('usuario')->id_usuario // Usamos session para obtener el id_usuario
        ]);

        Egreso::create($request->all());

        return redirect()->route('egresos.index')->with('success', 'Egreso registrado correctamente.');
    }

    public function show(Egreso $egreso)
    {
        return view('egresos.show', compact('egreso'));
    }

    public function edit(Egreso $egreso)
    {
        return view('egresos.edit', compact('egreso'));
    }

    public function update(Request $request, Egreso $egreso)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'categoria' => 'nullable|string|max:100',
            'id_usuario_autorizador' => 'nullable|integer'
        ]);

        // Asignamos el id_usuario_autorizador desde la sesión
        $request->merge([
            'id_usuario_autorizador' => session('usuario')->id_usuario // Usamos session para obtener el id_usuario
        ]);

        $egreso->update($request->all());

        return redirect()->route('egresos.index')->with('success', 'Egreso actualizado correctamente.');
    }

    public function destroy(Egreso $egreso)
    {
        $egreso->delete();
        return redirect()->route('egresos.index')->with('success', 'Egreso eliminado correctamente.');
    }


    public function generarInforme(Request $request)
    {
        $query = Egreso::query();

        // Filtros por fechas
        if ($request->fecha_inicio) {
            $query->where('fecha', '>=', $request->fecha_inicio);
        }
        if ($request->fecha_fin) {
            $query->where('fecha', '<=', $request->fecha_fin);
        }

        $egresos = $query->get();

        // Generar el PDF
        $pdf = PDF::loadView('egresos.informe', compact('egresos'));
        return $pdf->download('informe_egresos.pdf');
    }
}