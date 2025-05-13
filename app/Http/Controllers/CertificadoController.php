<?php
// app/Http/Controllers/CertificadoController.php

namespace App\Http\Controllers;

use App\Models\Sacramento;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\CertificadoRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CertificadoController extends Controller
{
    /**
     * Listado de certificados emitidos.
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
     * Formulario para emitir un certificado.
     */
    public function create()
    {
        $tipos       = config('certificados');
        $sacramentos = Sacramento::all();
        return view('certificados.create', compact('tipos', 'sacramentos'));
    }

    /**
     * Valida, registra el ingreso y genera el PDF.
     */

     public function store(CertificadoRequest $request)
     {
         $data = $request->validated();
     
         [$label, $precio] = config('certificados')[$data['tipo']];
     
         // Registrar ingreso
         $ingresoId = DB::table('ingresos')->insertGetId([
             'tipo_ingreso'        => 'certificado',
             'monto'               => $precio,
             'fecha'               => now(),
             'descripcion'         => "Emisión de certificado «{$label}»",
             'id_usuario_registro' => session('usuario')->id_usuario,
             'created_at'          => now(),
             'updated_at'          => now(),
         ]);
     
         // Obtener datos del sacramento
         $sacramento = Sacramento::find($data['sacramento_id']);
     
         // Generar PDF con DomPDF
         $pdf = Pdf::loadView('certificados.pdf', [
             'tipo'       => $label,
             'sacramento' => $sacramento,
             'fecha'      => now()->format('d/m/Y'),
             'usuario'    => session('usuario'),
         ]);
     
         // Definir ruta absoluta donde se guardará el PDF
         $fileName = "certificado_{$data['tipo']}_{$ingresoId}.pdf";
         $absolutePath = storage_path("app/public/certificados");
     
         // Crear el directorio si no existe
         if (!file_exists($absolutePath)) {
             mkdir($absolutePath, 0755, true);
         }
     
         // Guardar el archivo manualmente
         file_put_contents("$absolutePath/$fileName", $pdf->output());
     
         // Generar URL pública del PDF
         $pdfUrl = asset("storage/certificados/$fileName");
     
         // Mostrarlo en vista con iframe
         return view('certificados.descarga', compact('pdfUrl'));
     }
     
     public function eliminarTemporal(Request $request)
    {
        $path = $request->input('path');

        if ($path && str_starts_with($path, 'certificados/') && str_ends_with($path, '.pdf')) {
            $fullPath = storage_path("app/public/{$path}");
            if (file_exists($fullPath)) {
                unlink($fullPath);
                return response()->json(['status' => 'ok']);
            }
        }

        return response()->json(['status' => 'invalid'], 400);
    }

     

}