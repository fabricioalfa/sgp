<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sacramento;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadoController extends Controller
{
    /**
     * 1) Listado de certificados emitidos
     */
    public function index()
    {
        $ingresos = DB::table('ingresos')
            ->where('tipo_ingreso', 'certificado')
            ->orderBy('fecha', 'desc')
            ->get();

        return view('certificados.index', compact('ingresos'));
    }

    /**
     * 2) Formulario para emitir un certificado
     */
    public function create()
    {
        $tipos       = config('certificados');
        $sacramentos = Sacramento::all();  // cargamos TODO de golpe
        return view('certificados.create', compact('tipos', 'sacramentos'));
    }

    /**
     * 3) Valida, registra el ingreso y genera el PDF
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo'          => 'required|in:' . implode(',', array_keys(config('certificados'))),
            'sacramento_id' => 'nullable|exists:sacramentos,id_sacramento',
        ]);

        [$label, $precio] = config('certificados')[$request->tipo];

        // Grabar ingreso
        $ingresoId = DB::table('ingresos')->insertGetId([
            'tipo_ingreso'        => 'certificado',
            'monto'               => $precio,
            'fecha'               => now(),
            'descripcion'         => "Emisión de certificado “{$label}”",
            'id_usuario_registro' => session('usuario')->id_usuario,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        // Cargar sacramento si aplicó
        $sacramento = $request->sacramento_id
            ? Sacramento::find($request->sacramento_id)
            : null;

        // Generar PDF
        $pdf = Pdf::loadView('certificados.pdf', [
            'tipo'       => $label,
            'sacramento' => $sacramento,
            'fecha'      => now()->format('d/m/Y'),
            'usuario'    => session('usuario'),
        ]);

        return $pdf->stream("certificado_{$request->tipo}_{$ingresoId}.pdf");
    }
}