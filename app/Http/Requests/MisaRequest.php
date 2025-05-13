<?php
// app/Http/Requests/MisaRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Models\Misa;
use App\Models\Sacramento;
use Carbon\Carbon;

class MisaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'fecha'         => 'required|date|after_or_equal:today',
            'hora'          => 'required|date_format:H:i',
            'tipo_misa'     => 'required|string|max:100',
            'intencion'     => 'nullable|string|max:500',
            'id_sacerdote'  => 'nullable|exists:sacerdotes,id_sacerdote',
            'observaciones' => 'nullable|string|max:1000',
            'estado'        => 'required|in:programada,celebrada,cancelada',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $tipoKey = strtoupper(trim($this->input('tipo_misa')));

            // Si es misa comunitaria, omitimos validación de choque
            if ($tipoKey === 'MISA DE DIFUNTOS COMUNITARIAS') {
                return;
            }

            $fecha = $this->input('fecha');
            $hora  = $this->input('hora');

            // Verificar solapamiento con otra misa (excluye la actual en update)
            $misaQuery = Misa::where('fecha', $fecha)
                             ->where('hora', $hora);

            if ($this->route('misa')) {
                $misaQuery->where('id_misa', '!=', $this->route('misa')->id_misa);
            }

            $conflictoMisa = $misaQuery->exists();

            // Verificar solapamiento con sacramento
            $conflictoSac = Sacramento::where('fecha', $fecha)
                                      ->where('hora', $hora)
                                      ->exists();

            if ($conflictoMisa || $conflictoSac) {
                $validator->errors()->add(
                    'hora',
                    'Ya existe otra celebración (misa o sacramento) programada el '
                    . Carbon::parse($fecha)->format('d/m/Y')
                    . ' a las ' . $hora . '.'
                );
            }
        });
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'fecha.required'            => 'La fecha de la misa es obligatoria.',
            'fecha.date'                => 'La fecha debe tener un formato válido (YYYY-MM-DD).',
            'fecha.after_or_equal'      => 'La fecha no puede ser anterior a hoy.',
            'hora.required'             => 'La hora de la misa es obligatoria.',
            'hora.date_format'          => 'La hora debe tener el formato HH:MM (ej. 14:30).',
            'tipo_misa.required'        => 'El tipo de misa es obligatorio.',
            'tipo_misa.max'             => 'El tipo de misa no puede exceder los 100 caracteres.',
            'intencion.max'             => 'La intención no puede exceder los 500 caracteres.',
            'id_sacerdote.exists'       => 'El sacerdote seleccionado no existe.',
            'observaciones.max'         => 'Las observaciones no pueden exceder los 1000 caracteres.',
            'estado.required'           => 'El estado de la misa es obligatorio.',
            'estado.in'                 => 'El estado debe ser "programada", "celebrada" o "cancelada".',
        ];
    }
}
