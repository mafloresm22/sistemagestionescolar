<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PadreFamilia extends Model
{
    protected $table = 'padre_familias';
    protected $primaryKey = 'idPadreFamilia';
    protected $fillable = [
        'nombrePadreFamilia',
        'apellidoPadreFamilia',
        'dniPadreFamilia',
        'fechaNacimientoPadreFamilia',
        'generoPadreFamilia',
        'celularPadreFamilia',
        'correoPadreFamilia',
        'direccionPadreFamilia',
        'estadoPadreFamilia'
    ];

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }
}
