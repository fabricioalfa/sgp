<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SacramentoRequest extends FormRequest
{
    /**
     * Determinar si el usuario está autorizado para hacer esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtener las reglas de validación que se aplican a la solicitud.
     */
    public function rules(): array
    {
        return [
            'tipo_sacramento'    => 'required|in:bautizo,comunion,confirmacion,matrimonio',
            'fecha'              => 'required|date',
            'hora'               => 'required',
            'lugar'              => 'required|string|max:100',
            'iglesia'            => 'required|string|max:100',  // Campo iglesia agregado
            'nombre_receptor'    => 'required|string|max:100',
            'apellido_paterno'   => 'required|string|max:100',
            'apellido_materno'   => 'nullable|string|max:100',
            'fecha_nacimiento'   => 'nullable|date',
            'sexo'               => 'required|in:M,F',
        ];
    }

    /**
     * Mensajes personalizados para los errores de validación.
     */
    public function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'max' => 'Máximo :max caracteres.',
            'in' => 'Valor no permitido.',
            'date' => 'Debe ser una fecha válida.',
        ];
    }
}