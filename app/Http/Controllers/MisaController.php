<?php

namespace App\Http\Controllers;

use App\Models\Misa;
use App\Models\Sacerdote;
use App\Models\Egreso;
use App\Models\Sacramento;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\MisaRequest;
use Carbon\Carbon;

class MisaController extends Controller
{
    public function index()
    {
        // Marcar misas pasadas como celebradas
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
        $tipoKey = strtoupper(trim($data['tipo_misa']));
        $isComunitaria = $tipoKey === 'MISA DE DIFUNTOS COMUNITARIAS';

        // Verificar solapamiento con Sacramento siempre
        $conflictSac = Sacramento::where('fecha', $data['fecha'])
                                 ->where('hora', $data['hora'])
                                 ->exists();

        // Verificar solapamiento con otra Misa solo si NO es comunitaria
        $conflictMisa = false;
        if (! $isComunitaria) {
            $conflictMisa = Misa::where('fecha', $data['fecha'])
                                ->where('hora', $data['hora'])
                                ->exists();
        }

        if ($conflictSac || $conflictMisa) {
            return back()
                ->withInput()
                ->withErrors(['fecha' => 'Ya existe un evento (Misa o Sacramento) en esa fecha y hora.']);
        }

        // Calcular estipendio según tipo de misa
        $estipendios = [
            'MISA DE DIFUNTOS COMUNITARIAS'      => 20,
            'MISA DE CUERPO PRESENTE'            => 100,
            'MISA DE SALUD Y OTRAS PETICIONES'   => 100,
            'MISA DE DEVOCION'                   => 350,
            'MISA DE FIESTA (preste folclorico)' => 500,
            'MISA DE ANIVERSARIO MATRIMONIAL'    => 200,
        ];
        $estipendio = $estipendios[$tipoKey] ?? 0;

        // Crear nueva misa
        $misa = Misa::create(array_merge($data, [
            'id_usuario_registro' => session('usuario')->id_usuario,
            'estipendio'          => $estipendio,
        ]));

        // Solo insertar ingreso si el monto es mayor a 0
        if ($estipendio > 0) {
            DB::table('ingresos')->insert([
                'tipo_ingreso'        => 'misa',
                'monto'               => $estipendio,
                'fecha'               => now(),
                'descripcion'         => "Estipendio misa “{$misa->tipo_misa}” del " . now()->format('d/m/Y'),
                'id_usuario_registro' => session('usuario')->id_usuario,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

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
        $tipoKey = strtoupper(trim($data['tipo_misa']));
        $isComunitaria = $tipoKey === 'MISA DE DIFUNTOS COMUNITARIAS';

        // Verificar solapamiento con Sacramento siempre
        $conflictSac = Sacramento::where('fecha', $data['fecha'])
                                 ->where('hora', $data['hora'])
                                 ->exists();

        // Verificar solapamiento con otra Misa solo si NO es comunitaria (excluyendo esta)
        $conflictMisa = false;
        if (! $isComunitaria) {
            $conflictMisa = Misa::where('fecha', $data['fecha'])
                                ->where('hora', $data['hora'])
                                ->where('id_misa', '!=', $misa->id_misa)
                                ->exists();
        }

        if ($conflictSac || $conflictMisa) {
            return back()
                ->withInput()
                ->withErrors(['fecha' => 'Ya existe un evento (Misa o Sacramento) en esa fecha y hora.']);
        }

        // Recalcular estipendio
        $estipendios = [
            'MISA DE DIFUNTOS COMUNITARIAS'      => 20,
            'MISA DE CUERPO PRESENTE'            => 100,
            'MISA DE SALUD Y OTRAS PETICIONES'   => 100,
            'MISA DE DEVOCION'                   => 350,
            'MISA DE FIESTA (preste folclorico)' => 500,
            'MISA DE ANIVERSARIO MATRIMONIAL'    => 200,
        ];
        $estipendio = $estipendios[$tipoKey] ?? 0;

        // Actualizar datos de la misa
        $misa->update(array_merge($data, [
            'estipendio' => $estipendio,
        ]));

        // Si cambió el estado a cancelada, registrar egreso por la misa cancelada
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
