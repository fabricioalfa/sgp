<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ceb extends Model
{
    protected $table = 'cebs';
    protected $primaryKey = 'id_ceb';
    public $timestamps = true;

    protected $fillable = [
        'responsable',
        'nombres_responsable',
        'apellido_paterno_responsable',
        'apellido_materno_responsable',
        'telefono',
        'eb',   //nombre de la ceb a la que pertence
        'id_usuario_registro',
    ];
}
