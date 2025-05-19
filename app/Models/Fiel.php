<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fiel extends Model
{
    use HasFactory;

    // Definimos la tabla si no sigue la convención
    protected $table = 'fieles';
    // Definimos la clave primaria
    protected $primaryKey = 'id_fieles';

    // Definir los atributos que se pueden llenar
    protected $fillable = [
        'id_sacramento',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'tipo_fiel',
    ];

    // Relación con el modelo Sacramento
    public function sacramento()
    {
        return $this->belongsTo(Sacramento::class, 'id_sacramento');
    }
}
