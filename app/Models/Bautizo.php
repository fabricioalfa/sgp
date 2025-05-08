<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bautizo extends Model
{
    protected $table = 'bautizos';
    protected $primaryKey = 'id_bautizo';
    public $timestamps = true;

    protected $fillable = [
        'id_sacramento', 'iglesia', 'nombre_padre', 'apellido_paterno_padre', 'apellido_materno_padre', 
        'nombre_madre', 'apellido_paterno_madre', 'apellido_materno_madre', 
        'nombre_padrino', 'apellido_paterno_padrino', 'apellido_materno_padrino', 
        'nombre_madrina', 'apellido_paterno_madrina', 'apellido_materno_madrina', 
        'sacerdote_celebrante'
    ];

    public function sacramento()
    {
        return $this->belongsTo(Sacramento::class, 'id_sacramento');
    }
}
