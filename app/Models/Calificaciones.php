<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificaciones extends Model
{
    protected $table = 'calificaciones';
    protected $primaryKey = 'idCalificacion';
    protected $fillable = [
        'asignarCursoDocenteID',
        'matriculacionID',
        'periodoID',
        'calificacionCalificaciones',
        'calificacionLiteralCalificaciones',
        'fechaRegistroCalificaciones',
        'estadoCalificaciones',
    ];

    public function asignarCursoDocente()
    {
        return $this->belongsTo(AsignarCursosDocentes::class, 'asignarCursoDocenteID');
    }

    public function matriculacion()
    {
        return $this->belongsTo(Matriculacion::class, 'matriculacionID');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodos::class, 'periodoID');
    }
}
