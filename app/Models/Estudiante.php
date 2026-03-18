<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiantes';
    protected $primaryKey = 'idEstudiante';
    protected $fillable = [
        'nombreEstudiante',
        'apellidoEstudiante',
        'dniEstudiante',
        'fechaNacimientoEstudiante',
        'generoEstudiante',
        'celularEstudiante',
        'correoEstudiante',
        'direccionEstudiante',
        'fotoEstudiante',
        'estadoEstudiante',
        'padreFamiliaID',
        'userID'
    ];

    public function padreFamilia()
    {
        return $this->belongsTo(PadreFamilia::class, 'padreFamiliaID');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
