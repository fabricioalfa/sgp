<?php

namespace App\Http\Controllers;

use App\Models\{Sacramento, Fiel, Misa};
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SacramentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Sacramento::query();

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->input('fecha_inicio'));
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->input('fecha_fin'));
        }

        $sacramentos = $query->orderBy('fecha', 'desc')->get();

        return view('sacramentos.index', compact('sacramentos'));
    }


    public function create()
    {
        return view('sacramentos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_sacramento'  => 'required|in:bautizo,comunion,confirmacion,matrimonio',
            'fecha'            => 'required|date',
            'hora'             => 'required',
            'lugar'            => 'required|string|max:255',
            'iglesia'          => 'required|string|max:255',
            'nombre_receptor'  => 'required|string|max:100',
            'apellido_paterno' => 'nullable|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
        ]);

        $conflictMisa = Misa::where('fecha', $data['fecha'])->where('hora', $data['hora'])->exists();
        $conflictSac  = Sacramento::where('fecha', $data['fecha'])->where('hora', $data['hora'])->exists();

        if ($conflictMisa || $conflictSac) {
            return back()->withInput()->withErrors(['fecha' => 'Ya existe un evento (Misa o Sacramento) en esa fecha y hora.']);
        }

        $data['id_usuario_registro'] = session('usuario')->id_usuario;
        $sacramento = Sacramento::create($data);

        return redirect()->route('sacramentos.familiares.create', $sacramento);
    }

    public function formFamiliares(Sacramento $sacramento)
    {
        $fieles = $sacramento->fieles()->get();
        $modoEdicion = false;
        return view('sacramentos.familiares', compact('sacramento', 'fieles', 'modoEdicion'));
    }

    public function editFamiliares(Sacramento $sacramento)
    {
        $fieles = $sacramento->fieles()->get();
        $modoEdicion = true;
        return view('sacramentos.familiares', compact('sacramento', 'fieles', 'modoEdicion'));
    }

    public function storeFamiliares(Request $request, Sacramento $sacramento)
    {
        $this->guardarFielesYCertificados($request, $sacramento);

        return redirect()->route('sacramentos.recibo', $sacramento);
    }

    public function updateFamiliares(Request $request, Sacramento $sacramento)
    {
        $this->guardarFielesYCertificados($request, $sacramento);

        return redirect()->route('sacramentos.index')->with('success', 'Familiares actualizados.');
    }

    private function guardarFielesYCertificados(Request $request, Sacramento $sacramento)
    {
        $fieles = $request->input('fieles', []);

        if (empty($fieles)) {
            return back()->withErrors(['fieles' => 'Debe registrar al menos un familiar.'])->withInput();
        }

        $validated = $request->validate([
            'fieles.*.nombres'            => 'required|string|max:100',
            'fieles.*.apellido_paterno'   => 'nullable|string|max:100',
            'fieles.*.apellido_materno'   => 'nullable|string|max:100',
            'fieles.*.correo_electronico' => 'nullable|string|email|max:150',
            'fieles.*.telefono'           => 'nullable|string|max:50',
            'fieles.*.tipo_fiel'          => 'required|string',
        ]);

        $sacramento->fieles()->delete();

        foreach ($validated['fieles'] as $fiel) {
            $sacramento->fieles()->create($fiel);
        }

        // Validación de certificados por checkbox
        $tiposRequierenCert = [
            'comunion'     => ['bautizo'],
            'confirmacion' => ['bautizo', 'comunion'],
            'matrimonio'   => ['bautizo', 'comunion', 'confirmacion'],
        ];

        $esperados = $tiposRequierenCert[$sacramento->tipo_sacramento] ?? [];
        $verificados = collect($request->input('verificado_cert', []))->keys()->all();
        $faltantes = array_diff($esperados, $verificados);

        $sacramento->observado = count($faltantes) > 0;
        $sacramento->save();
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
        $sacramento->load('fieles');
        return view('sacramentos.show', compact('sacramento'));
    }

    public function edit(Sacramento $sacramento)
    {
        $sacramento->load('fieles');
        return view('sacramentos.edit', compact('sacramento'));
    }

    public function update(Request $request, Sacramento $sacramento)
    {
        $data = $request->validate([
            'tipo_sacramento'  => 'required|in:bautizo,comunion,confirmacion,matrimonio',
            'fecha'            => 'required|date',
            'hora'             => 'required',
            'lugar'            => 'required|string|max:255',
            'iglesia'          => 'required|string|max:255',
            'nombre_receptor'  => 'required|string|max:100',
            'apellido_paterno' => 'nullable|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
        ]);

        $conflictMisa = Misa::where('fecha', $data['fecha'])
                           ->where('hora', $data['hora'])
                           ->where('id_misa', '!=', $sacramento->id_sacramento)
                           ->exists();

        $conflictSac = Sacramento::where('fecha', $data['fecha'])
                                 ->where('hora', $data['hora'])
                                 ->where('id_sacramento', '!=', $sacramento->id_sacramento)
                                 ->exists();

        if ($conflictMisa || $conflictSac) {
            return back()->withInput()->withErrors(['fecha' => 'Ya existe un evento (Misa o Sacramento) en esa fecha y hora.']);
        }

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
