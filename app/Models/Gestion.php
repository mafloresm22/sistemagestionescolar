<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    protected $table = 'gestions';
    protected $fillable = [
        'nombreGestion',
    ];
    
    public function periodos()
    {
        return $this->hasMany(Periodos::class, 'gestionID');
    }

    public function matriculacions()
    {
        return $this->hasMany(Matriculacion::class, 'gestionID', 'idGestion');
    }

    public function seccionesAulas()
    {
        return $this->hasMany(AsignarSeccionesAulas::class, 'gestionID', 'idGestion');
    }
}
