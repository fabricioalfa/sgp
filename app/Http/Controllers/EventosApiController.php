<?php

namespace App\Http\Controllers;

use App\Models\Misa;
use App\Models\Sacramento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EventosApiController extends Controller
{
    public function index()
    {
        $misas = Misa::select('fecha', 'hora', 'tipo_misa')
            ->get()
            ->map(function ($misa) {
                return [
                    'title' => 'Misa: ' . ucfirst(strtolower($misa->tipo_misa)),
                    'start' => $misa->fecha . 'T' . $misa->hora,
                    'tipo' => 'misa'
                ];
            });

        $sacramentos = Sacramento::select('fecha', 'hora', 'tipo_sacramento', 'nombre_receptor', 'apellido_paterno')
            ->get()
            ->map(function ($sac) {
                return [
                    'title' => ucfirst($sac->tipo_sacramento) . ': ' . $sac->nombre_receptor . ' ' . $sac->apellido_paterno,
                    'start' => $sac->fecha . 'T' . $sac->hora,
                    'tipo' => 'sacramento'
                ];
            });

        return Response::json($misas->merge($sacramentos));
    }
}
