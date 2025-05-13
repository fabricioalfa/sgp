<?php
// app/Http/Requests/CertificadoRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CertificadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tiposValidos = array_keys(config('certificados'));

        return [
            'tipo'          => ['required', 'string', Rule::in($tiposValidos)],
            // ahora es obligatorio tanto buscar como seleccionar:
            'sacramento_id' => ['required', 'integer', 'exists:sacramentos,id_sacramento'],
        ];
    }

    public function messages(): array
    {
        return [
            'tipo.required'           => 'Debe seleccionar el tipo de certificado.',
            'tipo.in'                 => 'El tipo de certificado seleccionado no es válido.',
            'sacramento_id.required'  => 'Por favor, primero busque y luego seleccione una persona para emitir el certificado.',
            'sacramento_id.integer'   => 'El identificador de la persona debe ser un número.',
            'sacramento_id.exists'    => 'La persona seleccionada no existe en el sistema.',
        ];
    }
}