<?php

namespace App\Http\Controllers;

use App\Models\Misa;
use App\Models\Sacerdote;
use App\Models\Egreso;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\MisaRequest;
use Carbon\Carbon;

class MisaController extends Controller
{
    public function index()
    {
        Misa::whereDate('fecha', '<', Carbon::today())
            ->whereNotIn('estado', ['celebrada', 'cancelada'])
            ->update(['estado' => 'celebrada']);

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

    public function store(MisaRequest $request)
    {
        $data = $request->validated();

        $estipendios = [
            'MISA DE DIFUNTOS COMUNITARIAS'      => 20,
            'MISA DE CUERPO PRESENTE'            => 100,
            'MISA DE SALUD Y OTRAS PETICIONES'   => 100,
            'MISA DE DEVOCION'                   => 350,
            'MISA DE FIESTA (preste folclorico)' => 500,
            'MISA DE ANIVERSARIO MATRIMONIAL'    => 200,
        ];

        $tipoKey    = strtoupper(trim($data['tipo_misa']));
        $estipendio = $estipendios[$tipoKey] ?? 0;

        $misa = Misa::create(array_merge($data, [
            'id_usuario_registro' => session('usuario')->id_usuario,
            'estipendio'          => $estipendio,
        ]));

        DB::table('ingresos')->insert([
            'tipo_ingreso'        => 'misa',
            'monto'               => $estipendio,
            'fecha'               => now(),
            'descripcion'         => "Estipendio misa “{$misa->tipo_misa}” del " . now()->format('d/m/Y'),
            'id_usuario_registro' => session('usuario')->id_usuario,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        return redirect()->route('misas.recibo', $misa);
    }

    public function edit(Misa $misa)
    {
        $sacerdotes = Sacerdote::all();
        return view('misas.edit', compact('misa', 'sacerdotes'));
    }

    public function update(MisaRequest $request, Misa $misa)
    {
        $data = $request->validated();

        $estipendios = [
            'MISA DE DIFUNTOS COMUNITARIAS'      => 20,
            'MISA DE CUERPO PRESENTE'            => 100,
            'MISA DE SALUD Y OTRAS PETICIONES'   => 100,
            'MISA DE DEVOCION'                   => 350,
            'MISA DE FIESTA (preste folclorico)' => 500,
            'MISA DE ANIVERSARIO MATRIMONIAL'    => 200,
        ];

        $tipoKey    = strtoupper(trim($data['tipo_misa']));
        $estipendio = $estipendios[$tipoKey] ?? 0;

        $misa->update(array_merge($data, [
            'estipendio' => $estipendio,
        ]));

        if ($data['estado'] === 'cancelada') {
            Egreso::create([
                'tipo_egreso'         => 'misa_cancelada',
                'categoria'           => 'misa',
                'monto'               => $estipendio,
                'fecha'               => now(),
                'descripcion'         => "Egreso por cancelación de misa “{$misa->tipo_misa}”",
                'id_usuario_registro' => session('usuario')->id_usuario,
            ]);
        }

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

    public function recibo(Misa $misa)
    {
        $pdf = Pdf::loadView('misas.recibo-pdf', compact('misa'));
        return view('misas.recibo', ['pdf' => $pdf->output()]);
    }
}
