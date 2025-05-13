<?php

namespace App\Http\Controllers;

use App\Models\Sacerdote;
use App\Http\Requests\SacerdoteRequest;

class SacerdoteController extends Controller
{
    public function index()
    {
        $sacerdotes = Sacerdote::all();
        return view('sacerdotes.index', compact('sacerdotes'));
    }

    public function create()
    {
        return view('sacerdotes.create');
    }

    public function store(SacerdoteRequest $request)
    {
        // Se usa validated() para obtener solo los campos permitidos y validados
        Sacerdote::create($request->validated());

        return redirect()
            ->route('sacerdotes.index')
            ->with('success', 'Sacerdote registrado correctamente.');
    }

    public function edit(Sacerdote $sacerdote)
    {
        return view('sacerdotes.edit', compact('sacerdote'));
    }

    public function update(SacerdoteRequest $request, Sacerdote $sacerdote)
    {
        $sacerdote->update($request->validated());

        return redirect()
            ->route('sacerdotes.index')
            ->with('success', 'Sacerdote actualizado correctamente.');
    }

    public function destroy(Sacerdote $sacerdote)
    {
        $sacerdote->delete();

        return redirect()
            ->route('sacerdotes.index')
            ->with('success', 'Sacerdote eliminado correctamente.');
    }
}
