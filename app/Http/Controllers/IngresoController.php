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
        $request->validate([
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'tipo_ingreso' => 'required|in:donación,misa,sacramento,otro',
            'id_usuario_registro' => 'nullable|integer'
        ]);

        // Asignamos el id_usuario_registro desde la sesión
        $request->merge([
            'id_usuario_registro' => session('usuario')->id_usuario // Usamos session para obtener el id_usuario
        ]);

        Ingreso::create($request->all());
        return redirect()->route('ingresos.index')->with('success', 'Ingreso creado.');
    }

    public function edit(Ingreso $ingreso) {
        return view('ingresos.edit', compact('ingreso'));
    }

    public function update(Request $request, Ingreso $ingreso) {
        $request->validate([
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'tipo_ingreso' => 'required|in:donación,misa,sacramento,otro',
            'id_usuario_registro' => 'nullable|integer'
        ]);

        $ingreso->update($request->all());
        return redirect()->route('ingresos.index')->with('success', 'Ingreso actualizado.');
    }

    public function destroy(Ingreso $ingreso) {
        $ingreso->delete();
        return redirect()->route('ingresos.index')->with('success', 'Ingreso eliminado.');
    }

    public function show(Ingreso $ingreso) {
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