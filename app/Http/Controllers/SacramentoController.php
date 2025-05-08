<?php

namespace App\Http\Controllers;

use App\Models\Sacramento;
use App\Models\Bautizo;
use App\Models\PrimeraComunion;
use App\Models\Confirmacion;
use App\Models\Matrimonio;
use Illuminate\Http\Request;

class SacramentoController extends Controller
{
    // Mostrar todos los sacramentos
    public function index()
    {
        $sacramentos = Sacramento::orderByDesc('fecha')->get();
        return view('sacramentos.index', compact('sacramentos'));
    }

    // Mostrar el formulario de creación
    public function create()
    {
        return view('sacramentos.create');
    }

    // Almacenar un nuevo sacramento
    public function store(Request $request)
    {
        $request->validate([
            'tipo_sacramento' => 'required|in:bautizo,comunion,confirmacion,matrimonio',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'nombre_receptor' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'nullable|string',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|in:M,F',
            'lugar' => 'nullable|string',
        ]);

        // Crear el sacramento
        $sacramento = Sacramento::create([
            'tipo_sacramento' => $request->tipo_sacramento,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'lugar' => $request->lugar,
            'nombre_receptor' => $request->nombre_receptor,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'sexo' => $request->sexo,
            'id_usuario_registro' => session('usuario')->id_usuario,
        ]);

        // Lógica para cada tipo de sacramento
        switch ($request->tipo_sacramento) {
            case 'bautizo':
                Bautizo::create([
                    'id_sacramento' => $sacramento->id_sacramento,
                    'iglesia' => $request->iglesia,
                    'nombre_padre' => $request->nombre_padre,
                    'apellido_paterno_padre' => $request->apellido_paterno_padre,
                    'apellido_materno_padre' => $request->apellido_materno_padre,
                    'nombre_madre' => $request->nombre_madre,
                    'apellido_paterno_madre' => $request->apellido_paterno_madre,
                    'apellido_materno_madre' => $request->apellido_materno_madre,
                    'nombre_padrino' => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina' => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                    'sacerdote_celebrante' => $request->sacerdote_celebrante,
                ]);
                break;

            case 'comunion':
                PrimeraComunion::create([
                    'id_sacramento' => $sacramento->id_sacramento,
                    'iglesia' => $request->iglesia,
                    'nombre_padre' => $request->nombre_padre,
                    'apellido_paterno_padre' => $request->apellido_paterno_padre,
                    'apellido_materno_padre' => $request->apellido_materno_padre,
                    'nombre_madre' => $request->nombre_madre,
                    'apellido_paterno_madre' => $request->apellido_paterno_madre,
                    'apellido_materno_madre' => $request->apellido_materno_madre,
                    'nombre_padrino' => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina' => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                ]);
                break;

            case 'confirmacion':
                Confirmacion::create([
                    'id_sacramento' => $sacramento->id_sacramento,
                    'obispo' => $request->obispo,
                    'nombre_padrino' => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina' => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                ]);
                break;

            case 'matrimonio':
                Matrimonio::create([
                    'id_sacramento' => $sacramento->id_sacramento,
                    'nombre_novio' => $request->nombre_novio,
                    'apellido_paterno_novio' => $request->apellido_paterno_novio,
                    'apellido_materno_novio' => $request->apellido_materno_novio,
                    'nombre_novia' => $request->nombre_novia,
                    'apellido_paterno_novia' => $request->apellido_paterno_novia,
                    'apellido_materno_novia' => $request->apellido_materno_novia,
                    'iglesia' => $request->iglesia,
                    'nombre_testigo1' => $request->nombre_testigo1,
                    'apellido_paterno_testigo1' => $request->apellido_paterno_testigo1,
                    'apellido_materno_testigo1' => $request->apellido_materno_testigo1,
                    'nombre_testigo2' => $request->nombre_testigo2,
                    'apellido_paterno_testigo2' => $request->apellido_paterno_testigo2,
                    'apellido_materno_testigo2' => $request->apellido_materno_testigo2,
                    'nombre_padrino' => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina' => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                ]);
                break;
        }

        return redirect()->route('sacramentos.index')->with('success', 'Sacramento registrado correctamente.');
    }

    public function show($id)
    {
        $sacramento = Sacramento::findOrFail($id);
        return view('sacramentos.show', compact('sacramento'));
    }

    public function edit($id)
    {
        $sacramento = Sacramento::findOrFail($id);
        $bautizo = Bautizo::where('id_sacramento', $sacramento->id_sacramento)->first();
        $comunion = PrimeraComunion::where('id_sacramento', $sacramento->id_sacramento)->first();
        $confirmacion = Confirmacion::where('id_sacramento', $sacramento->id_sacramento)->first();
        $matrimonio = Matrimonio::where('id_sacramento', $sacramento->id_sacramento)->first();

        return view('sacramentos.edit', compact('sacramento', 'bautizo', 'comunion', 'confirmacion', 'matrimonio'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_sacramento' => 'required|in:bautizo,comunion,confirmacion,matrimonio',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'nombre_receptor' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'nullable|string',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|in:M,F',
            'lugar' => 'nullable|string',
        ]);

        $sacramento = Sacramento::findOrFail($id);

        $sacramento->update([
            'tipo_sacramento' => $request->tipo_sacramento,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'lugar' => $request->lugar,
            'nombre_receptor' => $request->nombre_receptor,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'sexo' => $request->sexo,
        ]);

        // Actualizar el sacramento relacionado (dependiendo del tipo)
        switch ($sacramento->tipo_sacramento) {
            case 'bautizo':
                $bautizo = Bautizo::where('id_sacramento', $sacramento->id_sacramento)->first();
                $bautizo->update([
                    'iglesia' => $request->iglesia,
                    'nombre_padre' => $request->nombre_padre,
                    'apellido_paterno_padre' => $request->apellido_paterno_padre,
                    'apellido_materno_padre' => $request->apellido_materno_padre,
                    'nombre_madre' => $request->nombre_madre,
                    'apellido_paterno_madre' => $request->apellido_paterno_madre,
                    'apellido_materno_madre' => $request->apellido_materno_madre,
                    'nombre_padrino' => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina' => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                    'sacerdote_celebrante' => $request->sacerdote_celebrante,
                ]);
                break;

            case 'comunion':
                $comunion = PrimeraComunion::where('id_sacramento', $sacramento->id_sacramento)->first();
                $comunion->update([
                    'iglesia' => $request->iglesia,
                    'nombre_padre' => $request->nombre_padre,
                    'apellido_paterno_padre' => $request->apellido_paterno_padre,
                    'apellido_materno_padre' => $request->apellido_materno_padre,
                    'nombre_madre' => $request->nombre_madre,
                    'apellido_paterno_madre' => $request->apellido_paterno_madre,
                    'apellido_materno_madre' => $request->apellido_materno_madre,
                    'nombre_padrino' => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina' => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                ]);
                break;

            case 'confirmacion':
                $confirmacion = Confirmacion::where('id_sacramento', $sacramento->id_sacramento)->first();
                $confirmacion->update([
                    'obispo' => $request->obispo,
                    'nombre_padrino' => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina' => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                ]);
                break;

            case 'matrimonio':
                $matrimonio = Matrimonio::where('id_sacramento', $sacramento->id_sacramento)->first();
                $matrimonio->update([
                    'nombre_novio' => $request->nombre_novio,
                    'apellido_paterno_novio' => $request->apellido_paterno_novio,
                    'apellido_materno_novio' => $request->apellido_materno_novio,
                    'nombre_novia' => $request->nombre_novia,
                    'apellido_paterno_novia' => $request->apellido_paterno_novia,
                    'apellido_materno_novia' => $request->apellido_materno_novia,
                    'iglesia' => $request->iglesia,
                    'nombre_testigo1' => $request->nombre_testigo1,
                    'apellido_paterno_testigo1' => $request->apellido_paterno_testigo1,
                    'apellido_materno_testigo1' => $request->apellido_materno_testigo1,
                    'nombre_testigo2' => $request->nombre_testigo2,
                    'apellido_paterno_testigo2' => $request->apellido_paterno_testigo2,
                    'apellido_materno_testigo2' => $request->apellido_materno_testigo2,
                    'nombre_padrino' => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina' => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                ]);
                break;
        }

        return redirect()->route('sacramentos.index')->with('success', 'Sacramento actualizado correctamente.');
    }

    public function destroy(Sacramento $sacramento)
    {
        $sacramento->delete();
        return redirect()->route('sacramentos.index')->with('success', 'Sacramento eliminado.');
    }
}
