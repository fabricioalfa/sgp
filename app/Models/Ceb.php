<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ceb extends Model
{
    protected $table = 'cebs';
    protected $primaryKey = 'id_ceb';
    public $timestamps = true;

    protected $fillable = [
        'nombres_ceb',
        'apellido_pat_ceb',
        'apellido_mat_ceb',
        'responsable',
        'ceb',
        'telefono',
      ];
}
