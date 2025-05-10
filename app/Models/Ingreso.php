<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    use HasFactory;

    protected $table = 'ingresos';
    protected $primaryKey = 'id_ingreso';
    
    protected $fillable = [
        'monto', 'descripcion', 'fecha', 'tipo_ingreso', 'id_usuario_registro',
    ];

    public $timestamps = true;
}
