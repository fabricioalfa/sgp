<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Http\Requests\ActividadRequest;

class ActividadController extends Controller
{
    public function index()
    {
        $actividades = Actividad::all();
        return view('actividades.index', compact('actividades'));
    }

    public function create()
    {
        return view('actividades.create');
    }

    public function store(ActividadRequest $request)
    {
        $data = $request->validated();
        $data['id_usuario_creador'] = session('usuario')->id_usuario;

        Actividad::create($data);

        return redirect()
            ->route('actividades.index')
            ->with('success', 'Actividad registrada correctamente.');
    }

    public function edit(Actividad $actividad)
    {
        return view('actividades.edit', compact('actividad'));
    }

    public function update(ActividadRequest $request, Actividad $actividad)
    {
        $actividad->update($request->validated());

        return redirect()
            ->route('actividades.index')
            ->with('success', 'Actividad actualizada correctamente.');
    }

    public function destroy(Actividad $actividad)
    {
        $actividad->delete();

        return redirect()
            ->route('actividades.index')
            ->with('success', 'Actividad eliminada correctamente.');
    }
}
