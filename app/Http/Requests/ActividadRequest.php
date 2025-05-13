<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActividadRequest extends FormRequest
{
    public function authorize()
    {
        // Ajusta según tus reglas de autorización
        return true;
    }

    public function rules()
    {
        return [
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'responsable'  => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'titulo.required'       => 'El título es obligatorio.',
            'titulo.max'            => 'El título no puede exceder 255 caracteres.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date'     => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.required'    => 'La fecha de fin es obligatoria.',
            'fecha_fin.date'        => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'responsable.required'  => 'El responsable es obligatorio.',
            'responsable.max'       => 'El nombre del responsable no puede exceder 255 caracteres.',
        ];
    }
}
