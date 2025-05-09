<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Egreso;
use Illuminate\Http\Request;

class FinanzasController extends Controller
{
    public function index(Request $request) {
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
    
        return view('finanzas.index', compact('ingresos', 'egresos', 'totalIngresos', 'totalEgresos', 'saldo'));
    }
}
