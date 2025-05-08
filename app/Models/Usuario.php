<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre_usuario',
        'contrasena',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'correo_electronico',
        'telefono',
        'rol',
        'estado',
        'fecha_registro',
    ];

    protected $hidden = ['contrasena'];

    public $timestamps = true;
}
