<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class IngresoController extends Controller
{
    public function index() {
        $ingresos = Ingreso::all();
        return view('ingresos.index', compact('ingresos'));
    }

    public function create() {
        return view('ingresos.create');
    }

    public function store(Request $request) {
        // Validaciones
        $request->validate([
            'monto' => 'required|numeric|min:0.01',  // Asegura que el monto sea un número mayor a 0
            'descripcion' => 'nullable|string|max:255',  // La descripción es opcional pero si se proporciona debe ser texto
            'fecha' => 'required|date',  // La fecha es obligatoria
            'tipo_ingreso' => 'required|in:donación,misa,sacramento,otro',  // El tipo de ingreso debe ser uno de estos
            'id_usuario_registro' => 'nullable|integer',  // El id_usuario_registro es opcional, pero si está debe ser un entero
        ]);

        // Asignamos el id_usuario_registro desde la sesión si no se pasó
        $request->merge([
            'id_usuario_registro' => session('usuario')->id_usuario // Usamos session para obtener el id_usuario
        ]);

        // Crear el ingreso
        Ingreso::create($request->all());

        // Redirigir a la lista de ingresos con un mensaje de éxito
        return redirect()->route('ingresos.index')->with('success', 'Ingreso creado exitosamente.');
    }

    public function edit(Ingreso $ingreso) {
        return view('ingresos.edit', compact('ingreso'));
    }

    public function update(Request $request, Ingreso $ingreso) {
        // Validaciones
        $request->validate([
            'monto' => 'required|numeric|min:0.01',  // Asegura que el monto sea un número mayor a 0
            'descripcion' => 'nullable|string|max:255',  // La descripción es opcional pero si se proporciona debe ser texto
            'fecha' => 'required|date',  // La fecha es obligatoria
            'tipo_ingreso' => 'required|in:donación,misa,sacramento,otro',  // El tipo de ingreso debe ser uno de estos
            'id_usuario_registro' => 'nullable|integer',  // El id_usuario_registro es opcional, pero si está debe ser un entero
        ]);

        // Actualizar el ingreso con los datos validados
        $ingreso->update($request->all());

        // Redirigir a la lista de ingresos con un mensaje de éxito
        return redirect()->route('ingresos.index')->with('success', 'Ingreso actualizado exitosamente.');
    }

    public function destroy(Ingreso $ingreso) {
        // Eliminar el ingreso
        $ingreso->delete();

        // Redirigir a la lista de ingresos con un mensaje de éxito
        return redirect()->route('ingresos.index')->with('success', 'Ingreso eliminado exitosamente.');
    }

    public function show(Ingreso $ingreso) {
        // Mostrar los detalles del ingreso
        return view('ingresos.show', compact('ingreso'));
    }

    public function generateRecibo($ingresoId)
    {
        // Buscar el ingreso por su ID
        $ingreso = Ingreso::findOrFail($ingresoId);

        // Si no se encuentra el ingreso, redirigir con un error
        if (!$ingreso) {
            return redirect()->route('ingresos.index')->with('error', 'Ingreso no encontrado.');
        }

        // Generar el PDF utilizando la vista 'ingresos.recibo'
        $pdf = PDF::loadView('ingresos.recibo', compact('ingreso'));

        // Mostrar el PDF en el navegador y darle la opción de descarga (streaming)
        return $pdf->stream('recibo_ingreso_'.$ingreso->id_ingreso.'.pdf');
    }
}
