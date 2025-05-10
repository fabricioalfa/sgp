<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


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


    public function generateInforme(Request $request)
    {
        // Validar las fechas proporcionadas
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        // Convertir las fechas de inicio y fin a formato Carbon para una mejor manipulación
        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);

        // Obtener todos los egresos dentro del rango de fechas
        $egresos = Egreso::whereBetween('fecha', [$fechaInicio, $fechaFin])->get();

        // Si no hay egresos para las fechas seleccionadas
        if ($egresos->isEmpty()) {
            return redirect()->route('egresos.index')->with('error', 'No hay egresos para este rango de fechas.');
        }

        // Generar el informe en PDF utilizando la vista 'egresos.informe'
        $pdf = PDF::loadView('egresos.informe', compact('egresos', 'fechaInicio', 'fechaFin'));

        // Mostrar el PDF en el navegador
        return $pdf->stream('informe_egresos_'.$fechaInicio->format('Y-m-d').'_'.$fechaFin->format('Y-m-d').'.pdf');
    }
}