<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sacramento;
use App\Models\Bautizo;
use App\Models\PrimeraComunion;
use App\Models\Confirmacion;
use App\Models\Matrimonio;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SacramentoController extends Controller
{
    /**
     * Mostrar todos los sacramentos
     */
    public function index()
    {
        $sacramentos = Sacramento::orderBy('fecha', 'desc')->get();
        return view('sacramentos.index', compact('sacramentos'));
    }

    /**
     * Formulario de creación de sacramento
     */
    public function create()
    {
        return view('sacramentos.create');
    }

    /**
     * Guardar nuevo sacramento con verificación de conflictos de horario
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo_sacramento'    => 'required|in:bautizo,comunion,confirmacion,matrimonio',
            'fecha'              => 'required|date',
            'hora'               => 'required',
            'lugar'              => 'required|string|max:100',
            'nombre_receptor'    => 'required|string|max:100',
            'apellido_paterno'   => 'required|string|max:100',
            'apellido_materno'   => 'nullable|string|max:100',
            'fecha_nacimiento'   => 'nullable|date',
            'sexo'               => 'required|in:M,F',
        ]);

        $fecha = $request->fecha;
        $hora  = $request->hora;

        // Conflicto con misa
        $conflictoMisa = DB::table('misas')
            ->where('fecha', $fecha)
            ->where('hora', $hora)
            ->exists();

        // Conflicto con otro sacramento
        $conflictoSac = Sacramento::where('fecha', $fecha)
            ->where('hora', $hora)
            ->exists();

        if ($conflictoMisa || $conflictoSac) {
            return back()
                ->withInput()
                ->withErrors([
                    'hora' => "Ya existe una celebración (misa o sacramento) el "
                             . Carbon::parse($fecha)->format('d/m/Y')
                             . " a las $hora."
                ]);
        }

        // Crear sacramento base
        $sacramento = Sacramento::create([
            'tipo_sacramento'     => $request->tipo_sacramento,
            'fecha'               => $fecha,
            'hora'                => $hora,
            'lugar'               => $request->lugar,
            'nombre_receptor'     => $request->nombre_receptor,
            'apellido_paterno'    => $request->apellido_paterno,
            'apellido_materno'    => $request->apellido_materno,
            'fecha_nacimiento'    => $request->fecha_nacimiento,
            'sexo'                => $request->sexo,
            'id_usuario_registro' => session('usuario')->id_usuario,
        ]);

        // Crear registro específico según tipo
        switch ($request->tipo_sacramento) {
            case 'bautizo':
                Bautizo::create(array_merge(
                    ['id_sacramento' => $sacramento->id_sacramento],
                    $request->only([
                        'iglesia',
                        'nombre_padre', 'apellido_paterno_padre', 'apellido_materno_padre',
                        'nombre_madre', 'apellido_paterno_madre', 'apellido_materno_madre',
                        'nombre_padrino', 'apellido_paterno_padrino', 'apellido_materno_padrino',
                        'nombre_madrina', 'apellido_paterno_madrina', 'apellido_materno_madrina',
                        'sacerdote_celebrante'
                    ])
                ));
                break;

            case 'comunion':
                PrimeraComunion::create(array_merge(
                    ['id_sacramento' => $sacramento->id_sacramento],
                    $request->only([
                        'iglesia',
                        'nombre_padre', 'apellido_paterno_padre', 'apellido_materno_padre',
                        'nombre_madre', 'apellido_paterno_madre', 'apellido_materno_madre',
                        'nombre_padrino', 'apellido_paterno_padrino', 'apellido_materno_padrino',
                        'nombre_madrina', 'apellido_paterno_madrina', 'apellido_materno_madrina'
                    ])
                ));
                break;

            case 'confirmacion':
                Confirmacion::create(array_merge(
                    ['id_sacramento' => $sacramento->id_sacramento],
                    $request->only([
                        'obispo',
                        'nombre_padrino', 'apellido_paterno_padrino', 'apellido_materno_padrino',
                        'nombre_madrina', 'apellido_paterno_madrina', 'apellido_materno_madrina'
                    ])
                ));
                break;

            case 'matrimonio':
                Matrimonio::create(array_merge(
                    ['id_sacramento' => $sacramento->id_sacramento],
                    $request->only([
                        'nombre_novio', 'apellido_paterno_novio', 'apellido_materno_novio',
                        'nombre_novia', 'apellido_paterno_novia', 'apellido_materno_novia',
                        'iglesia',
                        'nombre_testigo1', 'apellido_paterno_testigo1', 'apellido_materno_testigo1',
                        'nombre_testigo2', 'apellido_paterno_testigo2', 'apellido_materno_testigo2',
                        'nombre_padrino', 'apellido_paterno_padrino', 'apellido_materno_padrino',
                        'nombre_madrina', 'apellido_paterno_madrina', 'apellido_materno_madrina'
                    ])
                ));
                break;
        }

        return redirect()
            ->route('sacramentos.index')
            ->with('success', 'Sacramento registrado correctamente.');
    }

    /**
     * Mostrar un sacramento
     */
    public function show(Sacramento $sacramento)
    {
        return view('sacramentos.show', compact('sacramento'));
    }

    /**
     * Formulario de edición de sacramento
     */
    public function edit(Sacramento $sacramento)
    {
        return view('sacramentos.edit', compact('sacramento'));
    }

    /**
     * Actualizar sacramento con verificación de conflictos de horario
     */
    public function update(Request $request, Sacramento $sacramento)
    {
        $request->validate([
            'tipo_sacramento'    => 'required|in:bautizo,comunion,confirmacion,matrimonio',
            'fecha'              => 'required|date',
            'hora'               => 'required',
            'lugar'              => 'required|string|max:100',
            'nombre_receptor'    => 'required|string|max:100',
            'apellido_paterno'   => 'required|string|max:100',
            'apellido_materno'   => 'nullable|string|max:100',
            'fecha_nacimiento'   => 'nullable|date',
            'sexo'               => 'required|in:M,F',
        ]);

        $fecha = $request->fecha;
        $hora  = $request->hora;

        // Conflicto con misa
        $conflictoMisa = DB::table('misas')
            ->where('fecha', $fecha)
            ->where('hora', $hora)
            ->exists();

        // Conflicto con otro sacramento distinto al actual
        $conflictoSac = Sacramento::where('fecha', $fecha)
            ->where('hora', $hora)
            ->where('id_sacramento', '!=', $sacramento->id_sacramento)
            ->exists();

        if ($conflictoMisa || $conflictoSac) {
            return back()
                ->withInput()
                ->withErrors([
                    'hora' => "Ya existe una celebración (misa o sacramento) en esa fecha y hora."
                ]);
        }

        // Actualizar sacramento base
        $sacramento->update($request->only([
            'tipo_sacramento',
            'fecha',
            'hora',
            'lugar',
            'nombre_receptor',
            'apellido_paterno',
            'apellido_materno',
            'fecha_nacimiento',
            'sexo',
        ]));

        // Actualizar datos específicos
        switch ($request->tipo_sacramento) {
            case 'bautizo':
                $sacramento->bautizo()->update($request->only([
                    'iglesia',
                    'nombre_padre', 'apellido_paterno_padre', 'apellido_materno_padre',
                    'nombre_madre', 'apellido_paterno_madre', 'apellido_materno_madre',
                    'nombre_padrino', 'apellido_paterno_padrino', 'apellido_materno_padrino',
                    'nombre_madrina', 'apellido_paterno_madrina', 'apellido_materno_madrina',
                    'sacerdote_celebrante'
                ]));
                break;

            case 'comunion':
                $sacramento->comunion()->update($request->only([
                    'iglesia',
                    'nombre_padre', 'apellido_paterno_padre', 'apellido_materno_padre',
                    'nombre_madre', 'apellido_paterno_madre', 'apellido_materno_madre',
                    'nombre_padrino', 'apellido_paterno_padrino', 'apellido_materno_padrino',
                    'nombre_madrina', 'apellido_paterno_madrina', 'apellido_materno_madrina'
                ]));
                break;

            case 'confirmacion':
                $sacramento->confirmacion()->update($request->only([
                    'obispo',
                    'nombre_padrino', 'apellido_paterno_padrino', 'apellido_materno_padrino',
                    'nombre_madrina', 'apellido_paterno_madrina', 'apellido_materno_madrina'
                ]));
                break;

            case 'matrimonio':
                $sacramento->matrimonio()->update($request->only([
                    'nombre_novio', 'apellido_paterno_novio', 'apellido_materno_novio',
                    'nombre_novia', 'apellido_paterno_novia', 'apellido_materno_novia',
                    'iglesia',
                    'nombre_testigo1', 'apellido_paterno_testigo1', 'apellido_materno_testigo1',
                    'nombre_testigo2', 'apellido_paterno_testigo2', 'apellido_materno_testigo2',
                    'nombre_padrino', 'apellido_paterno_padrino', 'apellido_materno_padrino',
                    'nombre_madrina', 'apellido_paterno_madrina', 'apellido_materno_madrina'
                ])); 
                break;
        }

        return redirect()
            ->route('sacramentos.index')
            ->with('success', 'Sacramento actualizado correctamente.');
    }

    /**
     * Eliminar sacramento y sus registros asociados
     */
    public function destroy(Sacramento $sacramento)
    {
        $sacramento->bautizo()->delete();
        $sacramento->comunion()->delete();
        $sacramento->confirmacion()->delete();
        $sacramento->matrimonio()->delete();
        $sacramento->delete();

        return redirect()
            ->route('sacramentos.index')
            ->with('success', 'Sacramento eliminado correctamente.');
    }
}