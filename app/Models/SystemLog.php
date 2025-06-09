<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $table = 'system_logs';
    public $timestamps = false; // solo usamos created_at manualmente

    protected $fillable = [
        'user_id',
        'model',
        'model_id',
        'action',
        'old_values',
        'new_values',
        'created_at',
    ];

    /**
     * Relación con el usuario que generó el log.
     * Fíjate que usamos 'user_id' aquí, no 'usuario_id'.
     */
    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'user_id');
    }
}
