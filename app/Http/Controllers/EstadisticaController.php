<?php
// app/Http/Controllers/EstadisticaController.php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Misa;
use App\Models\Sacramento;
use App\Models\Usuario;
use App\Models\Rrhh;
use App\Models\Actividad;

class EstadisticaController extends Controller
{
    public function index()
    {
        // Agregados financieros
        $totalIngresos   = Ingreso::sum('monto');
        $totalEgresos    = Egreso::sum('monto');
        $balance         = $totalIngresos - $totalEgresos;

        // Conteos de eventos
        $misasCount       = Misa::count();
        $sacramentosCount = Sacramento::count();

        // Otros datos útiles
        $usuariosCount    = Usuario::count();
        $rrhhCount        = Rrhh::count();
        $actividadesCount = Actividad::count();

        return view('estadisticas.index', compact(
            'totalIngresos',
            'totalEgresos',
            'balance',
            'misasCount',
            'sacramentosCount',
            'usuariosCount',
            'rrhhCount',
            'actividadesCount'
        ));
    }
}
