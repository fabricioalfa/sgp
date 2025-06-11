<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable, CanResetPassword;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = true;

    protected $fillable = [
        'correo_electronico',
        'contrasena',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'rol',
        'estado',
        'fecha_registro',
    ];

    protected $hidden = [
        'contrasena',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function getAuthIdentifierName()
    {
        return 'correo_electronico';
    }

    public function getEmailForPasswordReset()
    {
        return $this->correo_electronico;
    }
}
