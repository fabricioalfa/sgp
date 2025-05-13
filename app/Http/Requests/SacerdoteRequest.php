<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SacerdoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Ajusta esta lógica si necesitas verificar roles o permisos
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombres'           => 'required|string|max:100',
            'apellido_paterno'  => 'required|string|max:100',
            'apellido_materno'  => 'required|string|max:100',
            'telefono'          => 'required|string|max:20',
            'fecha_ordenacion'  => 'required|date',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombres.required'           => 'El nombre es obligatorio.',
            'apellido_paterno.required'  => 'El apellido paterno es obligatorio.',
            'apellido_materno.required'  => 'El apellido materno es obligatorio.',
            'telefono.required'          => 'El teléfono es obligatorio.',
            'telefono.max'               => 'El teléfono no puede tener más de 20 caracteres.',
            'fecha_ordenacion.required'  => 'La fecha de ordenación es obligatoria.',
            'fecha_ordenacion.date'      => 'La fecha de ordenación debe ser una fecha válida.',
        ];
    }
}
