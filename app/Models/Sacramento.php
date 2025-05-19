<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Fiel;


class Sacramento extends Model {

    protected $table = 'sacramentos';
    protected $primaryKey = 'id_sacramento';
    public $timestamps = true;

    protected $fillable = [
        'tipo_sacramento', 'fecha', 'hora', 'lugar', 'iglesia', 'nombre_receptor',
        'apellido_paterno', 'apellido_materno', 'fecha_nacimiento', 'sexo', 'id_usuario_registro'
    ];

    public function fieles() {
        return $this->hasMany(Fiel::class, 'id_sacramento');
    }
}
