<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grupo extends Model
{
     use HasFactory, HasRelationships;

    protected $fillable = [
        'nombre',
        'codigo_tutor'
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'codigo_tutor');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'estudiante_grupo', 'grupo_id', 'estudiante_codigo');
    }

    public function asistencias()
    {
        return $this->hasManyDeepFromRelations($this->estudiantes(), (new Estudiante)->asistencias());
    }
}
