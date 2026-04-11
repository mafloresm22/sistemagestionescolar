<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personals';
    protected $primaryKey = 'idPersonal';
    protected $fillable = [
        'nombrePersonal',
        'apellidoPersonal',
        'dniPersonal',
        'fechaNacimientoPersonal',
        'generoPersonal',
        'celularPersonal',
        'emailPersonal',
        'profesionPersonal',
        'tipoPersonal',
        'estadoPersonal',
        'fotoPersonal',
        'userID',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formacionAcademica()
    {
        return $this->hasMany(FormacionAcademica::class);
    }

    public function seccionesAulas()
    {
        return $this->hasMany(AsignarSeccionesAulas::class, 'personalID', 'idPersonal');
    }

    public function cursosAsignados()
    {
        return $this->hasMany(AsignarCursosDocentes::class, 'docenteId', 'idPersonal');
    }
}
