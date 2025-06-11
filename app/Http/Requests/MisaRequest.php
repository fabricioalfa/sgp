<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Models\Misa;
use App\Models\Sacramento;
use Carbon\Carbon;

class MisaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha'         => 'required|date|after_or_equal:today',
            'hora'          => 'required|date_format:H:i',
            'tipo_misa'     => 'required|string|max:100',
            'intencion'     => 'nullable|string|max:500',
            'lugar'         => 'required|string|max:255',
            'latitud'       => 'nullable|numeric|between:-90,90',
            'longitud'      => 'nullable|numeric|between:-180,180',
            'id_sacerdote'  => 'nullable|exists:sacerdotes,id_sacerdote',
            'observaciones' => 'nullable|string|max:1000',
            'estado'        => 'required|in:programada,celebrada,cancelada',

            // Fiel solicitante
            'fiel_nombres'          => 'required|string|max:150',
            'fiel_apellido_paterno' => 'required|string|max:150',
            'fiel_apellido_materno' => 'required|string|max:150',
            'fiel_correo'           => 'required|email|max:150',
            'fiel_telefono'         => 'required|string|max:50',
        ];
    }

    public function withValidator(Validator $validator): void
{
    $validator->after(function (Validator $validator) {
        $tipoKey = strtoupper(trim($this->input('tipo_misa')));
        $fecha = $this->input('fecha');
        $hora = $this->input('hora');
        $lat = floatval($this->input('latitud'));
        $lng = floatval($this->input('longitud'));
        $sacerdoteId = $this->input('id_sacerdote');

        $latParroquia = -16.513202;
        $lngParroquia = -68.130000;
        $toleranciaCoord = 0.001;
        $toleranciaTiempo = 60; // en minutos
        $idMisaActual = $this->route('misa') ? $this->route('misa')->id_misa : null;

        // Si es misa comunitaria, se permiten choques
        if ($tipoKey === 'MISA DE DIFUNTOS COMUNITARIAS') {
            return;
        }

        // Verificar si ya hay sacramentos en ese horario
        $sacramentoConflict = Sacramento::where('fecha', $fecha)
            ->where('hora', $hora)
            ->exists();

        // Verificar si hay misa ya en ese horario (excepto la misma si estamos editando)
        $misaConflict = Misa::where('fecha', $fecha)
            ->where('hora', $hora)
            ->when($idMisaActual, fn($q) => $q->where('id_misa', '!=', $idMisaActual))
            ->exists();

        if ($misaConflict || $sacramentoConflict) {
            $validator->errors()->add('hora', 'Ya existe otra celebración (misa o sacramento) programada el '
                . Carbon::parse($fecha)->format('d/m/Y') . ' a las ' . $hora . '.');
        }

        // Determinar si la misa es en la parroquia
        $esParroquia = abs($lat - $latParroquia) < $toleranciaCoord && abs($lng - $lngParroquia) < $toleranciaCoord;

        // Restricción parroquia: no puede haber dos misas a la misma hora
        if ($esParroquia) {
            $parroquiaConflict = Misa::where('fecha', $fecha)
                ->where('hora', $hora)
                ->whereRaw('ABS(latitud - ?) < ? AND ABS(longitud - ?) < ?', [$latParroquia, $toleranciaCoord, $lngParroquia, $toleranciaCoord])
                ->when($idMisaActual, fn($q) => $q->where('id_misa', '!=', $idMisaActual))
                ->exists();

            if ($parroquiaConflict) {
                $validator->errors()->add('hora', 'Ya hay una misa en la parroquia programada para ese horario.');
            }
        }

        // Restricción domicilio: el sacerdote no debe tener misas ±1h
        else {
            $conflictoSacerdote = Misa::where('fecha', $fecha)
                ->where('id_sacerdote', $sacerdoteId)
                ->whereRaw("ABS(TIMESTAMPDIFF(MINUTE, hora, ?)) < ?", [$hora, $toleranciaTiempo])
                ->when($idMisaActual, fn($q) => $q->where('id_misa', '!=', $idMisaActual))
                ->exists();

            if ($conflictoSacerdote) {
                $validator->errors()->add('id_sacerdote', 'El sacerdote ya tiene otra misa cerca de ese horario.');
            }

            // Verificar si hay suficientes sacerdotes disponibles
            $totalSacerdotes = \App\Models\Sacerdote::count();
            $ocupados = Misa::where('fecha', $fecha)
                ->whereRaw("ABS(TIMESTAMPDIFF(MINUTE, hora, ?)) < ?", [$hora, $toleranciaTiempo])
                ->distinct('id_sacerdote')
                ->count('id_sacerdote');

            if ($ocupados >= $totalSacerdotes) {
                $validator->errors()->add('id_sacerdote', 'No hay sacerdotes disponibles para este horario.');
            }
        }
    });
}


    public function messages(): array
    {
        return [
            'fecha.required'       => 'La fecha de la misa es obligatoria.',
            'hora.required'        => 'La hora de la misa es obligatoria.',
            'tipo_misa.required'   => 'El tipo de misa es obligatorio.',
            'lugar.required'       => 'El lugar de la misa es obligatorio.',
            'fiel_nombres.required' => 'El nombre del solicitante es obligatorio.',
            'fiel_apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'fiel_apellido_materno.required' => 'El apellido materno es obligatorio.',
            'fiel_correo.required' => 'El correo electrónico del solicitante es obligatorio.',
            'fiel_telefono.required' => 'El teléfono del solicitante es obligatorio.',
            'fecha.date'           => 'La fecha debe ser una fecha válida.',
        ];
    }
}
