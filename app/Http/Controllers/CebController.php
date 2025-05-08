<?php

namespace App\Http\Controllers;

use App\Models\Ceb;
use Illuminate\Http\Request;

class CebController extends Controller
{
    /**
     * Muestra el listado de personas en CEBs
     */
    public function index()
    {
        $cebs = Ceb::orderBy('nombres_ceb')->get();
        return view('cebs.index', compact('cebs'));
    }

    /**
     * Muestra el formulario de creación
     */
    public function create()
    {
        return view('cebs.create');
    }

    /**
     * Almacena un nuevo registro
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombres_ceb' => 'required|string|max:100',
            'apellido_pat_ceb' => 'nullable|string|max:100',
            'apellido_mat_ceb' => 'nullable|string|max:100',
            'responsable' => 'required|in:SI,NO',
            'ceb' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20'
        ]);

        $registro = new Ceb();
        $registro->nombres_ceb = $request->nombres_ceb;
        $registro->apellido_pat_ceb = $request->apellido_pat_ceb;
        $registro->apellido_mat_ceb = $request->apellido_mat_ceb;
        $registro->responsable = $request->responsable;
        $registro->ceb = $request->ceb;
        $registro->telefono = $request->telefono;
        $registro->id_usuario_registro = session('usuario')->id_usuario;

        $registro->save();

        return redirect()->route('cebs.index')->with('success', 'Registro creado exitosamente.');
    }

    /**
     * Muestra un registro específico
     */
    public function show(Ceb $ceb)
    {
        return view('cebs.show', compact('ceb'));
    }

    /**
     * Muestra el formulario de edición
     */
    public function edit(Ceb $ceb)
    {
        return view('cebs.edit', compact('ceb'));
    }

    /**
     * Actualiza un registro existente
     */
    public function update(Request $request, Ceb $ceb)
    {
        $request->validate([
            'nombres_ceb' => 'required|string|max:100',
            'apellido_pat_ceb' => 'nullable|string|max:100',
            'apellido_mat_ceb' => 'nullable|string|max:100',
            'responsable' => 'required|in:SI,NO',
            'ceb' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20'
        ]);

        $ceb->nombres_ceb = $request->nombres_ceb;
        $ceb->apellido_pat_ceb = $request->apellido_pat_ceb;
        $ceb->apellido_mat_ceb = $request->apellido_mat_ceb;
        $ceb->responsable = $request->responsable;
        $ceb->ceb = $request->ceb;
        $ceb->telefono = $request->telefono;
        
        $ceb->save();

        return redirect()->route('cebs.index')->with('success', 'Registro actualizado exitosamente.');
    }

    /**
     * Elimina un registro
     */
    public function destroy(Ceb $ceb)
    {
        $ceb->delete();
        return redirect()->route('cebs.index')->with('success', 'Registro eliminado exitosamente.');
    }
}