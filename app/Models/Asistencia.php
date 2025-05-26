<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asistencia extends Model
{
     use HasFactory;

    public const TIPO_PRESENTE = 'Presente';


    protected $fillable = [
        'fecha',
        'codigo_estudiante',
        'codigo_tutor',
        'tipo'
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha' => 'date', // O 'datetime' si también guardas la hora
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'codigo_estudiante');
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'codigo_tutor');
    }
}
