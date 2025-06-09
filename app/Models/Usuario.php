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

    protected $hidden = [
        'contrasena',
    ];

    /**
     * Override to return the password field.
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    /**
     * Override to return the email field for password resets.
     */
    public function getEmailForPasswordReset()
    {
        return $this->correo_electronico;
    }
}
