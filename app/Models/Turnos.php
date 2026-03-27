<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turnos extends Model
{
    protected $table = 'turnos';
    protected $fillable = [
        'nombreTurno'
    ];

    public function matriculacions()
    {
        return $this->hasMany(Matriculacion::class, 'turnoID', 'idTurno');
    }

    public function seccionesAulas()
    {
        return $this->hasMany(AsignarSeccionesAulas::class, 'turnoID', 'idTurno');
    }
}
