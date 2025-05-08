<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Misa extends Model
{
    protected $table = 'misas';
    protected $primaryKey = 'id_misa';
    public $timestamps = true;

    protected $fillable = [
        'fecha',
        'hora',
        'tipo_misa',
        'intencion',
        'id_sacerdote',
        'id_usuario_registro',
        'observaciones',
        'estipendio',
        'estado',
    ];

    public function sacerdote()
    {
        return $this->belongsTo(Sacerdote::class, 'id_sacerdote');
    }

    public function secretario()
    {
        return $this->belongsTo(Usuario::class, 'id_secretario');
    }
}
