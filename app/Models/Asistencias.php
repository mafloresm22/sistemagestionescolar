<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencias extends Model
{
    protected $table = 'asistencias';
    protected $primaryKey = 'idAsistencia';
    protected $fillable = [
        'idAsistencia',
        'fechaAsistencias',
        'asignarCursoDocenteID',
        'observacionAsistencias',
    ];

    public function asignarCursoDocente()
    {
        return $this->belongsTo(AsignarCursosDocentes::class, 'asignarCursoDocenteID');
    }

    public function asistenciasDetalles()
    {
        return $this->hasMany(AsistenciasDetalle::class, 'asistenciaID');
    }
}
