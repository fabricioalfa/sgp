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

        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            $file = $request->file('imagen');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Guardar en public/images/actividades
            $file->move(public_path('images/actividades'), $filename);

            // Guardar la ruta relativa en la base de datos
            $data['imagen'] = 'images/actividades/' . $filename;
        }

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
        $data = $request->validated();

        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            $file = $request->file('imagen');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Guardar en la carpeta correcta
            $file->move(public_path('images/actividades'), $filename);

            // Guardar la ruta en la BD
            $data['imagen'] = 'images/actividades/' . $filename;
        }

        $actividad->update($data);

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

    
    public function portal()
    {
        $actividades = Actividad::orderBy('fecha_inicio', 'desc')->get();
        return view('portal', compact('actividades'));
    }


    public function mostrarPublico(Actividad $actividad)
    {
        return view('actividades.public-show', compact('actividad'));
    }
}
