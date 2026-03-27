<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignarSeccionesAulas extends Model
{
    protected $table = 'asignar_secciones_aulas';
    protected $primaryKey = 'idAsignarSeccionAula';
    protected $fillable = [
        'aulaID',
        'seccionID',
        'gestionID',
        'turnoID',
        'personalID',
        'observacionesAsignarSeccionAula',
        'estadoAsignarSeccionAula',
    ];

    public function aula()
    {
        return $this->belongsTo(Aulas::class, 'aulaID', 'idAulas');
    }

    public function seccion()
    {
        return $this->belongsTo(Secciones::class, 'seccionID', 'idSeccion');
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'gestionID', 'idGestion');
    }

    public function turno()
    {
        return $this->belongsTo(Turnos::class, 'turnoID', 'idTurno');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personalID', 'idPersonal');
    }
}
