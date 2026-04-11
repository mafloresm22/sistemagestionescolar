<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cursos extends Model
{
    protected $table = 'cursos';
    protected $primaryKey = 'idCurso';
    protected $fillable = [
        'codigoCurso',
        'nombreCurso',
        'descripcionCurso',
        'estado',
        'gradoID',
        'nivelID',
    ];

    public function grado()
    {
        return $this->belongsTo(Grados::class, 'gradoID');
    }

    public function nivel()
    {
        return $this->belongsTo(Niveles::class, 'nivelID');
    }

    public function cursosAsignados()
    {
        return $this->hasMany(AsignarCursosDocentes::class, 'cursoID', 'idCurso');
    }
}
