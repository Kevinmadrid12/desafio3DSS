<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsignacionAspecto extends Model
{
     use HasFactory;

    protected $fillable = [
        'aspecto_id',
        'fecha',
        'codigo_estudiante',
        'codigo_tutor'
    ];

    protected $casts = [
    'fecha' => 'date',
    ];

    public function aspecto()
    {
        return $this->belongsTo(Aspecto::class, 'aspecto_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'codigo_estudiante');
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'codigo_tutor');
    }
}
