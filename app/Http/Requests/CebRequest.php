<?php
// app/Http/Requests/CebRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CebRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres_ceb'      => 'required|string|max:100',
            'apellido_pat_ceb' => 'required|string|max:100',
            'apellido_mat_ceb' => 'required|string|max:100',
            'responsable'      => 'required|in:SI,NO',
            'ceb'              => 'required|string|max:100',
            'telefono' => 'nullable|digits_between:6,20',
        ];
    }

    public function messages(): array
    {
        return [
            'nombres_ceb.required'      => 'El nombre del CEB es obligatorio.',
            'nombres_ceb.max'           => 'El nombre no puede exceder 100 caracteres.',
            'apellido_pat_ceb.string'   => 'El apellido paterno debe ser una cadena de texto.',
            'apellido_mat_ceb.string'   => 'El apellido materno debe ser una cadena de texto.',
            'apellido_pat_ceb.max'      => 'El apellido paterno no puede exceder 100 caracteres.',
            'apellido_mat_ceb.max'      => 'El apellido materno no puede exceder 100 caracteres.',
            'responsable.required'      => 'Debe indicar si es responsable (SI/NO).',
            'responsable.in'            => 'El campo responsable debe ser “SI” o “NO”.',
            'ceb.required'              => 'El nombre de la CEB es obligatorio.',
            'ceb.max'                   => 'El nombre de la CEB no puede exceder 100 caracteres.',
            'telefono.digits_between' => 'El teléfono debe tener entre 6 y 20 dígitos.',

        ];
    }
}