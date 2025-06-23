<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'actividades';
    // Clave primaria
    protected $primaryKey = 'id_actividad';
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'fecha_inicio',
        'fecha_fin',
        'responsable',
        'id_usuario_creador'
    ];

    // Relación con el usuario que crea la actividad
    public function creador()
    {
        return $this->belongsTo(User::class, 'id_usuario_creador');
    }
}