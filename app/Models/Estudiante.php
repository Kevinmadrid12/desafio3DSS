<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estudiante extends Model
{
    use HasFactory;

    protected $primaryKey = 'codigo';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'codigo',
        'nombres',
        'apellidos',
        'dui',
        'email',
        'telefono',
        'fecha_nacimiento',
        'fotografia',
        'estado'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_nacimiento' => 'date', 
    ];

    public function grupos()
    {
        return $this->belongsToMany(
            Grupo::class,
            'estudiante_grupo',    
            'estudiante_codigo',   
            'grupo_id',            
            'codigo',              
            'id'                   
        );
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'codigo_estudiante', 'codigo');
    }

    public function aspectos()
    {
        return $this->hasMany(AsignacionAspecto::class, 'codigo_estudiante');
    }
}
