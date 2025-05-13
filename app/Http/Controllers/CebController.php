<?php

namespace App\Http\Controllers;

use App\Models\Ceb;
use App\Http\Requests\CebRequest;

class CebController extends Controller
{
    /**
     * Muestra el listado de registros de CEBs.
     */
    public function index()
    {
        $cebs = Ceb::orderBy('nombres_ceb')->get();
        return view('cebs.index', compact('cebs'));
    }

    /**
     * Muestra el formulario para crear un nuevo registro.
     */
    public function create()
    {
        return view('cebs.create');
    }

    /**
     * Almacena un nuevo registro de CEB.
     */
    public function store(CebRequest $request)
    {
        $data = $request->validated();
        $data['id_usuario_registro'] = session('usuario')->id_usuario;

        Ceb::create($data);

        return redirect()
            ->route('cebs.index')
            ->with('success', 'Registro creado exitosamente.');
    }

    /**
     * Muestra un registro específico.
     */
    public function show(Ceb $ceb)
    {
        return view('cebs.show', compact('ceb'));
    }

    /**
     * Muestra el formulario de edición de un registro existente.
     */
    public function edit(Ceb $ceb)
    {
        return view('cebs.edit', compact('ceb'));
    }

    /**
     * Actualiza un registro existente de CEB.
     */
    public function update(CebRequest $request, Ceb $ceb)
    {
        $data = $request->validated();
        $ceb->update($data);

        return redirect()
            ->route('cebs.index')
            ->with('success', 'Registro actualizado exitosamente.');
    }

    /**
     * Elimina un registro de CEB.
     */
    public function destroy(Ceb $ceb)
    {
        $ceb->delete();

        return redirect()
            ->route('cebs.index')
            ->with('success', 'Registro eliminado exitosamente.');
    }
}