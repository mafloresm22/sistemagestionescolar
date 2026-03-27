<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aulas extends Model
{
    protected $table = 'aulas';
    protected $primaryKey = 'idAulas';
    protected $fillable = [
        'nombreAula',
        'capacidadAula',
        'estadoAula',
    ];

    public function seccionesAulas()
    {
        return $this->hasMany(AsignarSeccionesAulas::class, 'aulaID', 'idAulas');
    }
}
