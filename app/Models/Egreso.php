<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    use HasFactory;

    protected $table = 'egresos';

    protected $fillable = [
        'monto', 'descripcion', 'fecha', 'categoria', 'id_usuario_autorizador'
    ];

    protected $primaryKey = 'id_egreso';

    public $timestamps = true;
}
