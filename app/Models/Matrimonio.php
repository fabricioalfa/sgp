<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matrimonio extends Model
{
    protected $table = 'matrimonios';

    protected $fillable = [
        'id_sacramento', 'nombre_novio', 'apellido_paterno_novio', 'apellido_materno_novio',
        'nombre_novia', 'apellido_paterno_novia', 'apellido_materno_novia', 'iglesia',
        'nombre_testigo1', 'apellido_paterno_testigo1', 'apellido_materno_testigo1',
        'nombre_testigo2', 'apellido_paterno_testigo2', 'apellido_materno_testigo2',
        'nombre_padrino', 'apellido_paterno_padrino', 'apellido_materno_padrino',
        'nombre_madrina', 'apellido_paterno_madrina', 'apellido_materno_madrina'
    ];

    public function sacramento()
    {
        return $this->belongsTo(Sacramento::class, 'id_sacramento');
    }
}
