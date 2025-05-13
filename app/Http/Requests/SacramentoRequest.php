<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SacramentoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tipo_sacramento'    => 'required|in:bautizo,comunion,confirmacion,matrimonio',
            'fecha'              => 'required|date',
            'hora'               => 'required|date_format:H:i',
            'lugar'              => 'required|string|max:100',
            'nombre_receptor'    => 'required|string|max:100',
            'apellido_paterno'   => 'required|string|max:100',
            'apellido_materno'   => 'required|string|max:100',
            'fecha_nacimiento'   => 'required|date',
            'sexo'               => 'required|in:M,F',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'in' => 'El valor seleccionado no es válido.',
            'date_format' => 'El formato de hora debe ser HH:mm.',
        ];
    }
}
