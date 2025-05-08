<?php

namespace App\Http\Controllers;

use App\Models\Sacerdote;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'telefono' => 'nullable|string',
            'fecha_ordenacion' => 'nullable|date',
        ]);

        Sacerdote::create($request->all());

        return redirect()->route('sacerdotes.index')->with('success', 'Sacerdote registrado correctamente.');
    }

    public function edit(Sacerdote $sacerdote)
    {
        return view('sacerdotes.edit', compact('sacerdote'));
    }

    public function update(Request $request, Sacerdote $sacerdote)
    {
        $request->validate([
            'nombres' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'telefono' => 'nullable|string',
            'fecha_ordenacion' => 'nullable|date',
        ]);

        $sacerdote->update($request->all());

        return redirect()->route('sacerdotes.index')->with('success', 'Sacerdote actualizado correctamente.');
    }

    public function destroy(Sacerdote $sacerdote)
    {
        $sacerdote->delete();
        return redirect()->route('sacerdotes.index')->with('success', 'Sacerdote eliminado correctamente.');
    }
}