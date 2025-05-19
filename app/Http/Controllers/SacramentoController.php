<?php

namespace App\Http\Controllers;

use App\Models\Sacramento;
use App\Models\Fiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SacramentoController extends Controller
{
    public function index()
    {
        $sacramentos = Sacramento::orderBy('fecha', 'desc')->get();
        return view('sacramentos.index', compact('sacramentos'));
    }

    public function create()
    {
        return view('sacramentos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_sacramento'    => 'required|in:bautizo,comunion,confirmacion,matrimonio',
            'fecha'              => 'required|date',
            'hora'               => 'required',
            'lugar'              => 'required|string|max:255',
            'iglesia'            => 'required|string|max:255',
            'nombre_receptor'    => 'required|string|max:100',
            'apellido_paterno'   => 'nullable|string|max:100',
            'apellido_materno'   => 'nullable|string|max:100',
            'fecha_nacimiento'   => 'required|date',
            'sexo'               => 'required|in:M,F',
        ]);

        $data['id_usuario_registro'] = session('usuario')->id_usuario;

        $sacramento = Sacramento::create($data);

        return redirect()->route('sacramentos.fieles', $sacramento);
    }

    public function fielesForm(Sacramento $sacramento)
    {
        return view('sacramentos.fieles', compact('sacramento'));
    }

    public function storeFieles(Request $request, Sacramento $sacramento)
    {
        $validated = $request->validate([
            'fieles.*.nombres'           => 'required|string|max:100',
            'fieles.*.apellido_paterno' => 'nullable|string|max:100',
            'fieles.*.apellido_materno' => 'nullable|string|max:100',
            'fieles.*.tipo_fiel'        => 'required|in:padrino,madrina,testigo,padre,madre',
        ]);

        foreach ($validated['fieles'] as $fiel) {
            $sacramento->fieles()->create($fiel);
        }

        return redirect()->route('sacramentos.recibo', $sacramento);
    }

    public function mostrarRecibo(Sacramento $sacramento)
    {
        $fieles = $sacramento->fieles;

        if (in_array($sacramento->tipo_sacramento, ['bautizo', 'matrimonio'])) {
            $pdf = Pdf::loadView('sacramentos.recibo_pdf', compact('sacramento', 'fieles'));
            return view('sacramentos.descarga', ['pdf' => $pdf->output()]);
        }

        return redirect()->route('sacramentos.index');
    }

    public function show(Sacramento $sacramento)
    {
        return view('sacramentos.show', compact('sacramento'));
    }

    public function edit(Sacramento $sacramento)
    {
        return view('sacramentos.edit', compact('sacramento'));
    }

    public function update(Request $request, Sacramento $sacramento)
    {
        $data = $request->validate([
            'tipo_sacramento'    => 'required|in:bautizo,comunion,confirmacion,matrimonio',
            'fecha'              => 'required|date',
            'hora'               => 'required',
            'lugar'              => 'required|string|max:255',
            'iglesia'            => 'required|string|max:255',
            'nombre_receptor'    => 'required|string|max:100',
            'apellido_paterno'   => 'nullable|string|max:100',
            'apellido_materno'   => 'nullable|string|max:100',
            'fecha_nacimiento'   => 'required|date',
            'sexo'               => 'required|in:M,F',
        ]);

        $sacramento->update($data);

        return redirect()->route('sacramentos.index')->with('success', 'Sacramento actualizado correctamente.');
    }

    public function destroy(Sacramento $sacramento)
    {
        $sacramento->fieles()->delete();
        $sacramento->delete();

        return redirect()->route('sacramentos.index')->with('success', 'Sacramento eliminado correctamente.');
    }
}
