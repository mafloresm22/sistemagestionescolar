<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsistenciasDetalle extends Model
{
    protected $table = 'asistencias_detalles';
    protected $primaryKey = 'idAsistenciasDetalle';
    protected $fillable = [
        'idAsistenciasDetalle',
        'asistenciaID',
        'estudianteID',
        'estadoAsistenciasDetalle',
    ];

    public function asistencia()
    {
        return $this->belongsTo(Asistencias::class, 'asistenciaID');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudianteID');
    }
}
