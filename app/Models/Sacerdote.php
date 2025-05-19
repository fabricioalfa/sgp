<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sacerdote extends Model
{
    protected $table = 'sacerdotes';
    protected $primaryKey = 'id_sacerdote';
    public $timestamps = true;

    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'estipendio'
    ];
}
