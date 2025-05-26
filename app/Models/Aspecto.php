<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aspecto extends Model
{
     use HasFactory;

    public const TIPO_POSITIVO = 'positivo';
    public const TIPO_A_MEJORAR = 'a_mejorar';


    protected $fillable = [
        'descripcion',
        'tipo'
    ];

    public function asignaciones()
    {
        return $this->hasMany(AsignacionAspecto::class, 'aspecto_id');
    }
}
