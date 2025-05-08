<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rrhh extends Model
{
    protected $table = 'rrhh';
    protected $primaryKey = 'id_personal';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'cargo',
        'fecha_ingreso',
        'fecha_fin',
        'telefono',
        'direccion',
        'sueldo',
        'asignado_por',
        'estado',
        'observaciones',
    ];

    public function asignador()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'asignado_por', 'id_usuario');
    }

}
