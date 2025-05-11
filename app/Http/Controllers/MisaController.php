<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Misa;
use App\Models\Sacerdote;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MisaController extends Controller
{
    public function index()
    {
        $misas = Misa::with('sacerdote')
            ->orderBy('fecha', 'desc')
            ->get();

        return view('misas.index', compact('misas'));
    }

    public function create()
    {
        $sacerdotes = Sacerdote::all();
        return view('misas.create', compact('sacerdotes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha'        => 'required|date',
            'hora'         => 'required',
            'tipo_misa'    => 'required|string|max:100',
            'intencion'    => 'nullable|string',
            'id_sacerdote' => 'nullable|exists:sacerdotes,id_sacerdote',
            'observaciones'=> 'nullable|string',
            'estado'       => 'required|in:programada,celebrada,cancelada',
        ]);

        // 0) Restricción: no duplicar fecha+hora
        $existe = Misa::where('fecha', $request->fecha)
                    ->where('hora', $request->hora)
                    ->where('estado', '!=', 'cancelada') // opcional: permitir sobreescribir canceladas
                    ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors([
                    'hora' => 'Ya hay una misa registrada en ' 
                            . \Carbon\Carbon::parse($request->fecha)->format('d/m/Y')
                            . ' a las ' . $request->hora . '.'
                ]);
        }

        // 1) Definir montos
        $estipendios = [
            'MISA DE DIFUNTOS COMUNITARIAS'      => 20,
            'MISA DE CUERPO PRESENTE'            => 100,
            'MISA DE SALUD Y OTRAS PETICIONES'   => 100,
            'MISA DE DEVOCION'                   => 350,
            'MISA DE FIESTA (preste folclorico)' => 500,
            'MISA DE ANIVERSARIO MATRIMONIAL'    => 200,
        ];

        $tipo       = strtoupper(trim($request->tipo_misa));
        $estipendio = $estipendios[$tipo] ?? 0;

        // 2) Crear misa
        $misa = Misa::create([
            'fecha'               => $request->fecha,
            'hora'                => $request->hora,
            'tipo_misa'           => $request->tipo_misa,
            'intencion'           => $request->intencion,
            'id_sacerdote'        => $request->id_sacerdote,
            'id_usuario_registro' => session('usuario')->id_usuario,
            'observaciones'       => $request->observaciones,
            'estipendio'          => $estipendio,
            'estado'              => $request->estado,
        ]);

        // 3) Registrar ingreso
        DB::table('ingresos')->insert([
            'tipo_ingreso'        => 'misa',
            'monto'               => $estipendio,
            'fecha'               => now(),
            'descripcion'         => "Estipendio misa “{$misa->tipo_misa}” del " 
                                    . now()->format('d/m/Y'),
            'id_usuario_registro' => session('usuario')->id_usuario,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        return redirect()
            ->route('misas.index')
            ->with('success', 'Misa registrada y estipendio ingresado correctamente.');
    }

    public function edit(Misa $misa)
    {
        $sacerdotes = Sacerdote::all();
        return view('misas.edit', compact('misa', 'sacerdotes'));
    }

    public function update(Request $request, Misa $misa)
    {
        $request->validate([
            'fecha'        => 'required|date',
            'hora'         => 'required',
            'tipo_misa'    => 'required|string|max:100',
            'intencion'    => 'nullable|string',
            'id_sacerdote' => 'nullable|exists:sacerdotes,id_sacerdote',
            'observaciones'=> 'nullable|string',
            'estado'       => 'required|in:programada,celebrada,cancelada',
        ]);

        // Recalcular estipendio
        $estipendios = [
            'MISA DE DIFUNTOS COMUNITARIAS'      => 20,
            'MISA DE CUERPO PRESENTE'            => 100,
            'MISA DE SALUD Y OTRAS PETICIONES'   => 100,
            'MISA DE DEVOCION'                   => 350,
            'MISA DE FIESTA (preste folclorico)' => 500,
            'MISA DE ANIVERSARIO MATRIMONIAL'    => 200,
        ];

        $tipo       = strtoupper(trim($request->tipo_misa));
        $estipendio = $estipendios[$tipo] ?? 0;

        $misa->update([
            'fecha'          => $request->fecha,
            'hora'           => $request->hora,
            'tipo_misa'      => $request->tipo_misa,
            'intencion'      => $request->intencion,
            'id_sacerdote'   => $request->id_sacerdote,
            'observaciones'  => $request->observaciones,
            'estipendio'     => $estipendio,
            'estado'         => $request->estado,
        ]);

        return redirect()
            ->route('misas.index')
            ->with('success', 'Misa actualizada correctamente.');
    }

    public function destroy(Misa $misa)
    {
        $misa->delete();
        return redirect()
            ->route('misas.index')
            ->with('success', 'Misa eliminada correctamente.');
    }
}