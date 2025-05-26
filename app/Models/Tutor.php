<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tutor extends Model
{
    use HasFactory;

    protected $table = 'tutores';
    protected $primaryKey = 'codigo';
    public $incrementing = false;
    protected $keytype = 'string';

    protected $fillable = [
        'codigo',
        'nombres',
        'apellidos',
        'dui',
        'email',
        'telefono',
        'fecha_nacimiento',
        'fecha_contratacion',
        'estado'
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_nacimiento' => 'date', 
        'fecha_contratacion' => 'date', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'codigo_tutor');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'codigo_tutor');
    }

    public function aspectosAsignados()
    {
        return $this->hasMany(AsignacionAspecto::class, 'codigo_tutor');
    }
}
