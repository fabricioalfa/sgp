<?php

namespace App\Http\Controllers;

use App\Models\Sacerdote;
use App\Http\Requests\SacerdoteRequest;

class SacerdoteController extends Controller
{
    /**
     * Mostrar listado completo de sacerdotes.
     */
    public function index()
    {
        // Trae todos los campos: id_sacerdote, nombres, apellidos, teléfono,
        // estipendio, created_at y updated_at
        $sacerdotes = Sacerdote::orderBy('id_sacerdote', 'asc')->get();
        return view('sacerdotes.index', compact('sacerdotes'));
    }

    /**
     * Formulario para crear un nuevo sacerdote.
     */
    public function create()
    {
        return view('sacerdotes.create');
    }

    /**
     * Almacena un nuevo sacerdote en la base de datos.
     */
    public function store(SacerdoteRequest $request)
    {
        Sacerdote::create($request->validated());

        return redirect()
            ->route('sacerdotes.index')
            ->with('success', 'Sacerdote registrado correctamente.');
    }

    /**
     * Muestra los detalles de un sacerdote (opcional).
     */
    public function show(Sacerdote $sacerdote)
    {
        return view('sacerdotes.show', compact('sacerdote'));
    }

    /**
     * Formulario para editar un sacerdote existente.
     */
    public function edit(Sacerdote $sacerdote)
    {
        return view('sacerdotes.edit', compact('sacerdote'));
    }

    /**
     * Actualiza los datos de un sacerdote.
     */
    public function update(SacerdoteRequest $request, Sacerdote $sacerdote)
    {
        $sacerdote->update($request->validated());

        return redirect()
            ->route('sacerdotes.index')
            ->with('success', 'Sacerdote actualizado correctamente.');
    }

    /**
     * Elimina un sacerdote.
     */
    public function destroy(Sacerdote $sacerdote)
    {
        $sacerdote->delete();

        return redirect()
            ->route('sacerdotes.index')
            ->with('success', 'Sacerdote eliminado correctamente.');
    }
}
