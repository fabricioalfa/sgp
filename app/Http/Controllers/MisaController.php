<?php
    
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Misa;
    use App\Models\Sacerdote;

    class MisaController extends Controller
    {
        public function index()
        {
            $misas = Misa::with('sacerdote')->orderBy('fecha', 'desc')->get();
            return view('misas.index', compact('misas'));
        }

        public function create()
        {
            $sacerdotes = Sacerdote::all();
            return view('misas.create', compact('sacerdotes'));
        }

        public function store(Request $request)
        {
            $request->validate([
                'fecha' => 'required|date',
                'hora' => 'required',
                'tipo_misa' => 'required|string|max:100',
                'intencion' => 'nullable|string',
                'id_sacerdote' => 'nullable|exists:sacerdotes,id_sacerdote',
                'observaciones' => 'nullable|string',
                'estado' => 'required|in:programada,celebrada,cancelada',
            ]);

            // Asignación automática de estipendio según el tipo de misa
            $estipendios = [
                'MISA DE DIFUNTOS COMUNITARIAS' => 20,
                'MISA DE CUERPO PRESENTE' => 100,
                'MISA DE SALUD Y OTRAS PETICIONES' => 100,
                'MISA DE DEVOCION' => 350,
                'MISA DE FIESTA (preste folclorico)' => 500,
                'MISA DE ANIVERSARIO MATRIMONIAL' => 200,
            ];

            $tipo = strtoupper(trim($request->tipo_misa));
            $estipendio = $estipendios[$tipo] ?? 0;

            Misa::create([
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'tipo_misa' => $request->tipo_misa,
                'intencion' => $request->intencion,
                'id_sacerdote' => $request->id_sacerdote,
                'id_usuario_registro' => session('usuario')->id_usuario,
                'observaciones' => $request->observaciones,
                'estipendio' => $estipendio,
                'estado' => $request->estado,
            ]);

            return redirect()->route('misas.index')->with('success', 'Misa registrada correctamente.');
        }

        public function edit(Misa $misa)
        {
            $sacerdotes = Sacerdote::all();
            return view('misas.edit', compact('misa', 'sacerdotes'));
        }

        public function update(Request $request, Misa $misa)
        {
            $request->validate([
                'fecha' => 'required|date',
                'hora' => 'required',
                'tipo_misa' => 'required|string|max:100',
                'intencion' => 'nullable|string',
                'id_sacerdote' => 'nullable|exists:sacerdotes,id_sacerdote',
                'observaciones' => 'nullable|string',
                'estado' => 'required|in:programada,celebrada,cancelada',
            ]);

            // Recalcular estipendio si se cambia el tipo de misa
            $estipendios = [
                'MISA DE DIFUNTOS COMUNITARIAS' => 20,
                'MISA DE CUERPO PRESENTE' => 100,
                'MISA DE SALUD Y OTRAS PETICIONES' => 100,
                'MISA DE DEVOCION' => 350,
                'MISA DE FIESTA (preste folclorico)' => 500,
                'MISA DE ANIVERSARIO MATRIMONIAL' => 200,
            ];

            $tipo = strtoupper(trim($request->tipo_misa));
            $estipendio = $estipendios[$tipo] ?? 0;

            $misa->update([
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'tipo_misa' => $request->tipo_misa,
                'intencion' => $request->intencion,
                'id_sacerdote' => $request->id_sacerdote,
                'observaciones' => $request->observaciones,
                'estipendio' => $estipendio,
                'estado' => $request->estado,
            ]);

            return redirect()->route('misas.index')->with('success', 'Misa actualizada correctamente.');
        }

        public function destroy(Misa $misa)
        {
            $misa->delete();
            return redirect()->route('misas.index')->with('success', 'Misa eliminada correctamente.');
        }
    }