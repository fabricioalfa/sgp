<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SacerdoteRequest extends FormRequest
{
    public function authorize()
    {
        return true; // importante
    }

    public function rules()
    {
        return [
            'nombres'           => 'required|string|max:100',
            'apellido_paterno'  => 'nullable|string|max:100',
            'apellido_materno'  => 'nullable|string|max:100',
            'telefono'          => 'nullable|string|max:20',
            'estipendio'        => 'required|numeric|gt:0',
            
        ];
    }
}
