<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignarCursosDocentes extends Model
{
    protected $table = 'asignar_cursos_docentes';
    
    // Es importante definir la clave primaria si no es 'id'
    protected $primaryKey = 'idAsignarCursoDocente';

    protected $fillable = [
        'docenteId',
        'cursoID',
        'nivelID',
        'gestionID',
        'gradoID',
        'turnoID',
        'seccionID',
        'fechaAsignarCursoDocente',
        'estadoAsignarCursoDocente'
    ];

    public function docente()
    {
        return $this->belongsTo(Personal::class, 'docenteId', 'idPersonal');
    }

    public function curso()
    {
        return $this->belongsTo(Cursos::class, 'cursoID', 'idCurso');
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'gestionID', 'id');
    }

    public function nivel()
    {
        return $this->belongsTo(Niveles::class, 'nivelID', 'id');
    }

    public function grado()
    {
        return $this->belongsTo(Grados::class, 'gradoID', 'id');
    }

    public function seccion()
    {
        return $this->belongsTo(Secciones::class, 'seccionID', 'idSeccion');
    }

    public function turno()
    {
        return $this->belongsTo(Turnos::class, 'turnoID', 'id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencias::class, 'asignarCursoDocenteID');
    }
}
