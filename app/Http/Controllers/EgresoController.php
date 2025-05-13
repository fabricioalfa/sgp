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
        // Validaciones
        $request->validate([
            'monto' => 'required|numeric|min:0.01', // Asegura que el monto sea mayor que 0
            'descripcion' => 'nullable|string|max:255', // La descripción es opcional, pero si está, debe ser un texto
            'fecha' => 'required|date', // La fecha es obligatoria
            'categoria' => 'nullable|string|max:100', // La categoría es opcional
            'id_usuario_autorizador' => 'nullable|integer', // El id_autorizador es opcional, pero si está debe ser un entero
        ]);

        // Asignamos el id_usuario_autorizador desde la sesión si no se pasó
        $request->merge([
            'id_usuario_autorizador' => session('usuario')->id_usuario // Usamos session para obtener el id_usuario
        ]);

        // Crear el egreso
        Egreso::create($request->all());

        // Redirigir a la lista de egresos con un mensaje de éxito
        return redirect()->route('egresos.index')->with('success', 'Egreso creado exitosamente.');
    }

    public function edit(Egreso $egreso)
    {
        return view('egresos.edit', compact('egreso'));
    }

    public function update(Request $request, Egreso $egreso)
    {
        // Validaciones
        $request->validate([
            'monto' => 'required|numeric|min:0.01', // Asegura que el monto sea mayor que 0
            'descripcion' => 'nullable|string|max:255', // La descripción es opcional, pero si está, debe ser un texto
            'fecha' => 'required|date', // La fecha es obligatoria
            'categoria' => 'nullable|string|max:100', // La categoría es opcional
            'id_usuario_autorizador' => 'nullable|integer', // El id_autorizador es opcional, pero si está debe ser un entero
        ]);

        // Actualizar el egreso con los datos validados
        $egreso->update($request->all());

        // Redirigir a la lista de egresos con un mensaje de éxito
        return redirect()->route('egresos.index')->with('success', 'Egreso actualizado exitosamente.');
    }

    public function destroy(Egreso $egreso)
    {
        // Eliminar el egreso
        $egreso->delete();

        // Redirigir a la lista de egresos con un mensaje de éxito
        return redirect()->route('egresos.index')->with('success', 'Egreso eliminado exitosamente.');
    }

    public function show(Egreso $egreso)
    {
        // Mostrar los detalles del egreso
        return view('egresos.show', compact('egreso'));
    }

    public function generarInforme(Request $request)
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
