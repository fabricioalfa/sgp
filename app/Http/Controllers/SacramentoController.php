<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sacramento;
use App\Models\Bautizo;
use App\Models\PrimeraComunion;
use App\Models\Confirmacion;
use App\Models\Matrimonio;

class SacramentoController extends Controller
{
    // Mostrar todos los sacramentos
    public function index()
    {
        $sacramentos = Sacramento::orderBy('fecha', 'desc')->get();  // Obtener todos los sacramentos
        return view('sacramentos.index', compact('sacramentos'));  // Mostrar vista con todos los sacramentos
    }

    // Mostrar el formulario para crear un nuevo sacramento
    public function create()
    {
        return view('sacramentos.create');  // Mostrar formulario de creación
    }

    // Guardar un nuevo sacramento
    public function store(Request $request)
    {
        // Validación de datos comunes del sacramento
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

        // Guardar sacramento base y asignar el ID del usuario logueado desde la sesión
        $sacramento = Sacramento::create([
            'tipo_sacramento'    => $request->tipo_sacramento,
            'fecha'              => $request->fecha,
            'hora'               => $request->hora,
            'lugar'              => $request->lugar,
            'nombre_receptor'    => $request->nombre_receptor,
            'apellido_paterno'   => $request->apellido_paterno,
            'apellido_materno'   => $request->apellido_materno,
            'fecha_nacimiento'   => $request->fecha_nacimiento,
            'sexo'               => $request->sexo,
            'id_usuario_registro'=> session('usuario')->id_usuario,  // Obtener el ID del usuario logueado
        ]);

        // Almacenar los datos específicos según el tipo de sacramento
        switch ($request->tipo_sacramento) {
            case 'bautizo':
                Bautizo::create([
                    'id_sacramento'      => $sacramento->id_sacramento,
                    'iglesia'            => $request->iglesia,
                    'nombre_padre'       => $request->nombre_padre,
                    'apellido_paterno_padre' => $request->apellido_paterno_padre,
                    'apellido_materno_padre' => $request->apellido_materno_padre,
                    'nombre_madre'       => $request->nombre_madre,
                    'apellido_paterno_madre' => $request->apellido_paterno_madre,
                    'apellido_materno_madre' => $request->apellido_materno_madre,
                    'nombre_padrino'     => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina'     => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                    'sacerdote_celebrante' => $request->sacerdote_celebrante,
                ]);
                break;

            case 'comunion':
                PrimeraComunion::create([
                    'id_sacramento'      => $sacramento->id_sacramento,
                    'iglesia'            => $request->iglesia,
                    'nombre_padre'       => $request->nombre_padre,
                    'apellido_paterno_padre' => $request->apellido_paterno_padre,
                    'apellido_materno_padre' => $request->apellido_materno_padre,
                    'nombre_madre'       => $request->nombre_madre,
                    'apellido_paterno_madre' => $request->apellido_paterno_madre,
                    'apellido_materno_madre' => $request->apellido_materno_madre,
                    'nombre_padrino'     => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina'     => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                ]);
                break;

            case 'confirmacion':
                Confirmacion::create([
                    'id_sacramento'      => $sacramento->id_sacramento,
                    'obispo'             => $request->obispo,
                    'nombre_padrino'     => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina'     => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                ]);
                break;

            case 'matrimonio':
                Matrimonio::create([
                    'id_sacramento'      => $sacramento->id_sacramento,
                    'nombre_novio'       => $request->nombre_novio,
                    'apellido_paterno_novio' => $request->apellido_paterno_novio,
                    'apellido_materno_novio' => $request->apellido_materno_novio,
                    'nombre_novia'       => $request->nombre_novia,
                    'apellido_paterno_novia' => $request->apellido_paterno_novia,
                    'apellido_materno_novia' => $request->apellido_materno_novia,
                    'iglesia'            => $request->iglesia,
                    'nombre_testigo1'    => $request->nombre_testigo1,
                    'apellido_paterno_testigo1' => $request->apellido_paterno_testigo1,
                    'apellido_materno_testigo1' => $request->apellido_materno_testigo1,
                    'nombre_testigo2'    => $request->nombre_testigo2,
                    'apellido_paterno_testigo2' => $request->apellido_paterno_testigo2,
                    'apellido_materno_testigo2' => $request->apellido_materno_testigo2,
                    'nombre_padrino'     => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina'     => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                ]);
                break;
        }

        return redirect()->route('sacramentos.index')->with('success', 'Sacramento registrado correctamente.');
    }

    // Ver los detalles de un sacramento
    public function show(Sacramento $sacramento)
    {
        return view('sacramentos.show', compact('sacramento'));
    }

    // Mostrar el formulario de edición de sacramento
    public function edit(Sacramento $sacramento)
    {
        return view('sacramentos.edit', compact('sacramento'));
    }

    // Actualizar un sacramento
    public function update(Request $request, Sacramento $sacramento)
    {
        // Validación de datos comunes del sacramento
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

        // Actualizar sacramento base
        $sacramento->update([
            'tipo_sacramento'  => $request->tipo_sacramento,
            'fecha'            => $request->fecha,
            'hora'             => $request->hora,
            'lugar'            => $request->lugar,
            'nombre_receptor'  => $request->nombre_receptor,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'sexo'             => $request->sexo,
        ]);

        // Actualizar los datos específicos según el tipo de sacramento
        switch ($request->tipo_sacramento) {
            case 'bautizo':
                // Actualizar los datos de Bautizo
                $sacramento->bautizo()->update([
                    'iglesia'            => $request->iglesia,
                    'nombre_padre'       => $request->nombre_padre,
                    'apellido_paterno_padre' => $request->apellido_paterno_padre,
                    'apellido_materno_padre' => $request->apellido_materno_padre,
                    'nombre_madre'       => $request->nombre_madre,
                    'apellido_paterno_madre' => $request->apellido_paterno_madre,
                    'apellido_materno_madre' => $request->apellido_materno_madre,
                    'nombre_padrino'     => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina'     => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                    'sacerdote_celebrante' => $request->sacerdote_celebrante,
                ]);
                break;

            case 'comunion':
                // Actualizar los datos de Primera Comunión
                $sacramento->comunion()->update([
                    'iglesia'            => $request->iglesia,
                    'nombre_padre'       => $request->nombre_padre,
                    'apellido_paterno_padre' => $request->apellido_paterno_padre,
                    'apellido_materno_padre' => $request->apellido_materno_padre,
                    'nombre_madre'       => $request->nombre_madre,
                    'apellido_paterno_madre' => $request->apellido_paterno_madre,
                    'apellido_materno_madre' => $request->apellido_materno_madre,
                    'nombre_padrino'     => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina'     => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                ]);
                break;

            case 'confirmacion':
                // Actualizar los datos de Confirmación
                $sacramento->confirmacion()->update([
                    'obispo'             => $request->obispo,
                    'nombre_padrino'     => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina'     => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                ]);
                break;

            case 'matrimonio':
                // Actualizar los datos de Matrimonio
                $sacramento->matrimonio()->update([
                    'nombre_novio'       => $request->nombre_novio,
                    'apellido_paterno_novio' => $request->apellido_paterno_novio,
                    'apellido_materno_novio' => $request->apellido_materno_novio,
                    'nombre_novia'       => $request->nombre_novia,
                    'apellido_paterno_novia' => $request->apellido_paterno_novia,
                    'apellido_materno_novia' => $request->apellido_materno_novia,
                    'iglesia'            => $request->iglesia,
                    'nombre_testigo1'    => $request->nombre_testigo1,
                    'apellido_paterno_testigo1' => $request->apellido_paterno_testigo1,
                    'apellido_materno_testigo1' => $request->apellido_materno_testigo1,
                    'nombre_testigo2'    => $request->nombre_testigo2,
                    'apellido_paterno_testigo2' => $request->apellido_paterno_testigo2,
                    'apellido_materno_testigo2' => $request->apellido_materno_testigo2,
                    'nombre_padrino'     => $request->nombre_padrino,
                    'apellido_paterno_padrino' => $request->apellido_paterno_padrino,
                    'apellido_materno_padrino' => $request->apellido_materno_padrino,
                    'nombre_madrina'     => $request->nombre_madrina,
                    'apellido_paterno_madrina' => $request->apellido_paterno_madrina,
                    'apellido_materno_madrina' => $request->apellido_materno_madrina,
                ]);
                break;
        }

        return redirect()->route('sacramentos.index')->with('success', 'Sacramento actualizado correctamente.');
    }

    // Eliminar un sacramento
    public function destroy(Sacramento $sacramento)
    {
        // Eliminar los registros en las tablas hijas primero
        $sacramento->bautizo()->delete();
        $sacramento->comunion()->delete();
        $sacramento->confirmacion()->delete();
        $sacramento->matrimonio()->delete();

        // Finalmente, eliminar el sacramento
        $sacramento->delete();

        return redirect()->route('sacramentos.index')->with('success', 'Sacramento eliminado correctamente.');
    }
}