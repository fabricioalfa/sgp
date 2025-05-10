<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    // Mostrar todas las actividades
    public function index()
    {
        $actividades = Actividad::all();
        return view('actividades.index', compact('actividades'));
    }

    // Mostrar formulario para crear una actividad
    public function create()
    {
        return view('actividades.create');
    }

    // Almacenar una nueva actividad
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'responsable' => 'required|string|max:255',
        ]);

        // Asignar el id del usuario que crea la actividad (usando sesión)
        $actividad = Actividad::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'responsable' => $request->responsable,
            'id_usuario_creador' => session('usuario')->id_usuario, // Suponiendo que `session('usuario')` tiene el id del usuario
        ]);

        return redirect()->route('actividades.index')->with('success', 'Actividad registrada correctamente.');
    }

    // Mostrar formulario para editar una actividad
    public function edit(Actividad $actividad)
    {
        return view('actividades.edit', compact('actividad'));
    }

    // Actualizar la actividad
    public function update(Request $request, Actividad $actividad)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'responsable' => 'required|string|max:255',
        ]);

        $actividad->update($request->all());

        return redirect()->route('actividades.index')->with('success', 'Actividad actualizada correctamente.');
    }

    // Eliminar la actividad
    public function destroy(Actividad $actividad)
    {
        $actividad->delete();
        return redirect()->route('actividades.index')->with('success', 'Actividad eliminada correctamente.');
    }
}