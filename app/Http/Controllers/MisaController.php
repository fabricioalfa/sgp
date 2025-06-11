<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Misa;
use App\Models\Fiel;
use App\Models\Sacerdote;
use App\Models\Egreso;
use App\Models\Sacramento;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\MisaRequest;
use Carbon\Carbon;

class MisaController extends Controller
{
    public function index(Request $request)
    {
        // Marcar misas pasadas como celebradas
        Misa::whereDate('fecha', '<', Carbon::today())
            ->whereNotIn('estado', ['celebrada', 'cancelada'])
            ->update(['estado' => 'celebrada']);

        // Iniciar query con relaciones
        $query = Misa::with('sacerdote')->orderBy('fecha', 'desc');

        // Aplicar filtro de fecha si se enviaron los campos
        if ($request->filled('desde') && $request->filled('hasta')) {
            $query->whereBetween('fecha', [$request->desde, $request->hasta]);
        }

        // Obtener los resultados finales
        $misas = $query->get();

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

        $conflictSac = Sacramento::where('fecha', $data['fecha'])->where('hora', $data['hora'])->exists();
        $conflictMisa = !$isComunitaria && Misa::where('fecha', $data['fecha'])->where('hora', $data['hora'])->exists();

        if ($conflictSac || $conflictMisa) {
            return back()->withInput()->withErrors(['fecha' => 'Ya existe un evento (Misa o Sacramento) en esa fecha y hora.']);
        }

        $estipendios = [
            'MISA DE DIFUNTOS COMUNITARIAS'      => 20,
            'MISA DE CUERPO PRESENTE'            => 100,
            'MISA DE SALUD'                      => 100,
            'MISA DE ALMA'                       => 100,    
            'MISA DE DEVOCION'                   => 350,
            'MISA DE FIESTA (preste folclorico)' => 500,
            'MISA DE ANIVERSARIO MATRIMONIAL'    => 200,
        ];
        $estipendio = $estipendios[$tipoKey] ?? 0;

        $misa = Misa::create(array_merge($data, [
            'id_usuario_registro' => session('usuario')->id_usuario,
            'estipendio'          => $estipendio,
        ]));

        // Insertar fiel asociado a la misa
        Fiel::create([
            'id_misa'           => $misa->id_misa,
            'nombres'           => $data['fiel_nombres'],
            'apellido_paterno'  => $data['fiel_apellido_paterno'],
            'apellido_materno'  => $data['fiel_apellido_materno'],
            'correo_electronico'=> $data['fiel_correo'],
            'telefono'          => $data['fiel_telefono'],
            'tipo_fiel'         => 'creyente',
        ]);

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
        $misa->load('creyente');
        
        $sacerdotes = Sacerdote::all();
        return view('misas.edit', compact('misa', 'sacerdotes'));
    }

    public function update(MisaRequest $request, Misa $misa)
    {
        $data = $request->validated();
        $tipoKey = strtoupper(trim($data['tipo_misa']));
        $isComunitaria = $tipoKey === 'MISA DE DIFUNTOS COMUNITARIAS';

        $conflictSac = Sacramento::where('fecha', $data['fecha'])->where('hora', $data['hora'])->exists();
        $conflictMisa = !$isComunitaria && Misa::where('fecha', $data['fecha'])
            ->where('hora', $data['hora'])->where('id_misa', '!=', $misa->id_misa)->exists();

        if ($conflictSac || $conflictMisa) {
            return back()->withInput()->withErrors(['fecha' => 'Ya existe un evento (Misa o Sacramento) en esa fecha y hora.']);
        }

        $estipendios = [
            'MISA DE DIFUNTOS COMUNITARIAS'      => 20,
            'MISA DE CUERPO PRESENTE'            => 100,
            'MISA DE SALUD'                      => 100,
            'MISA DE ALMA'                       => 100,
            'MISA DE DEVOCION'                   => 350,
            'MISA DE FIESTA (preste folclorico)' => 500,
            'MISA DE ANIVERSARIO MATRIMONIAL'    => 200,
        ];
        $estipendio = $estipendios[$tipoKey] ?? 0;

        $misa->update(array_merge($data, ['estipendio' => $estipendio]));

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

        return redirect()->route('misas.index')->with('success', 'Misa actualizada correctamente.');
    }

    public function destroy(Misa $misa)
    {
        $misa->delete();
        return redirect()->route('misas.index')->with('success', 'Misa eliminada correctamente.');
    }

    public function recibo(Misa $misa)
    {
        $pdf = Pdf::loadView('misas.recibo-pdf', compact('misa'));
        return view('misas.recibo', ['pdf' => $pdf->output()]);
    }
}
