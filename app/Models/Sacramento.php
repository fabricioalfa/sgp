<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sacramento extends Model
{
    protected $table = 'sacramentos';
    protected $primaryKey = 'id_sacramento';
    public $timestamps = true;

    protected $fillable = [
        'tipo_sacramento',
        'fecha',
        'hora',
        'lugar',
        'nombre_receptor',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'sexo',
        'id_usuario_registro',
    ];

    // Relaciones con los detalles específicos
    public function bautizo()
    {
        return $this->hasOne(Bautizo::class, 'id_sacramento');
    }

    public function comunion()
    {
        return $this->hasOne(PrimeraComunion::class, 'id_sacramento');
    }

    public function confirmacion()
    {
        return $this->hasOne(Confirmacion::class, 'id_sacramento');
    }

    public function matrimonio()
    {
        return $this->hasOne(Matrimonio::class, 'id_sacramento');
    }
}
