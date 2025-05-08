<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Confirmacion extends Model
{
    protected $table = 'confirmaciones';

    protected $fillable = [
        'id_sacramento', 'obispo', 'nombre_padrino', 'apellido_paterno_padrino', 'apellido_materno_padrino',
        'nombre_madrina', 'apellido_paterno_madrina', 'apellido_materno_madrina'
    ];

    public function sacramento()
    {
        return $this->belongsTo(Sacramento::class, 'id_sacramento');
    }
}
