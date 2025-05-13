<?php

// app/Http/Controllers/FinanzasController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Ingreso;
use App\Models\Egreso;
use Carbon\Carbon;

class FinanzasController extends Controller
{
    public function index(Request $request)
    {
        $query = Ingreso::query();
        $queryEgresos = Egreso::query();

        if ($request->fecha_inicio) {
            $query->where('fecha', '>=', $request->fecha_inicio);
            $queryEgresos->where('fecha', '>=', $request->fecha_inicio);
        }

        if ($request->fecha_fin) {
            $query->where('fecha', '<=', $request->fecha_fin);
            $queryEgresos->where('fecha', '<=', $request->fecha_fin);
        }

        $ingresos = $query->get();
        $egresos = $queryEgresos->get();

        $totalIngresos = $ingresos->sum('monto');
        $totalEgresos = $egresos->sum('monto');
        $saldo = $totalIngresos - $totalEgresos;

        // Definir los meses
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        $anioActual = date('Y');

        return view('finanzas.index', compact('ingresos', 'egresos', 'totalIngresos', 'totalEgresos', 'saldo', 'meses', 'anioActual'));
    }

    public function generateReport(Request $request)
    {
        // Filtros (fecha_inicio, fecha_fin, mes, año)
        $query = Ingreso::query();
        $queryEgresos = Egreso::query();

        if ($request->fecha_inicio) {
            $query->where('fecha', '>=', $request->fecha_inicio);
            $queryEgresos->where('fecha', '>=', $request->fecha_inicio);
        }

        if ($request->fecha_fin) {
            $query->where('fecha', '<=', $request->fecha_fin);
            $queryEgresos->where('fecha', '<=', $request->fecha_fin);
        }

        // Obtener los ingresos y egresos después de los filtros
        $ingresos = $query->get();
        $egresos = $queryEgresos->get();

        $totalIngresos = $ingresos->sum('monto');
        $totalEgresos = $egresos->sum('monto');
        $saldo = $totalIngresos - $totalEgresos;

        // Generar el PDF
        $pdf = Pdf::loadView('finanzas.reporte', [
            'ingresos' => $ingresos,
            'egresos' => $egresos,
            'totalIngresos' => $totalIngresos,
            'totalEgresos' => $totalEgresos,
            'saldo' => $saldo
        ]);

        // Descargar el PDF o mostrarlo en el navegador
        return $pdf->download('reporte_finanzas.pdf');
    }

    public function show(Request $request)
    {
        // Definir la consulta base para los ingresos y egresos
        $query = Ingreso::query();
        $queryEgresos = Egreso::query();

        // Filtros por fecha de inicio
        if ($request->fecha_inicio) {
            $query->where('fecha', '>=', $request->fecha_inicio);
            $queryEgresos->where('fecha', '>=', $request->fecha_inicio);
        }

        // Filtros por fecha de fin
        if ($request->fecha_fin) {
            $query->where('fecha', '<=', $request->fecha_fin);
            $queryEgresos->where('fecha', '<=', $request->fecha_fin);
        }

        // Filtros por mes
        if ($request->mes) {
            $query->whereMonth('fecha', '=', $request->mes);
            $queryEgresos->whereMonth('fecha', '=', $request->mes);
        }

        // Filtros por año
        if ($request->anio) {
            $query->whereYear('fecha', '=', $request->anio);
            $queryEgresos->whereYear('fecha', '=', $request->anio);
        }

        // Obtener los registros filtrados
        $ingresos = $query->get();
        $egresos = $queryEgresos->get();

        // Sumar los totales de ingresos y egresos
        $totalIngresos = $ingresos->sum('monto');
        $totalEgresos = $egresos->sum('monto');
        $saldo = $totalIngresos - $totalEgresos;

        // Generar el PDF con los datos obtenidos
        $pdf = Pdf::loadView('finanzas.reporte', compact('ingresos', 'egresos', 'totalIngresos', 'totalEgresos', 'saldo'));

        // Mostrar el PDF en una nueva pestaña (stream)
        return $pdf->stream('reporte_finanzas.pdf');
    }
}
