<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matriculacion extends Model
{
    protected $table = 'matriculacions';
    protected $primaryKey = 'idMatriculacion';
    protected $fillable = [
        'fechaMatriculacion',
        'estudianteID',
        'turnoID',
        'gestionID',
        'seccionID',
        'nivelesID',
        'gradosID',
        'observacionesMatriculacion',
        'estadoMatriculacion',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudianteID', 'idEstudiante');
    }

    public function turno()
    {
        return $this->belongsTo(Turnos::class, 'turnoID', 'id');
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'gestionID', 'id');
    }

    public function seccion()
    {
        return $this->belongsTo(Secciones::class, 'seccionID', 'idSeccion');
    }

    public function nivel()
    {
        return $this->belongsTo(Niveles::class, 'nivelesID', 'id');
    }

    public function grado()
    {
        return $this->belongsTo(Grados::class, 'gradosID', 'id');
    }

    public function pagos()
    {
        return $this->hasMany(Pagos::class, 'matriculacionID', 'idMatriculacion');
    }
}
