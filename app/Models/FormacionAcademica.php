<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormacionAcademica extends Model
{
    protected $table = 'formacion_academicas';
    protected $primaryKey = 'idFormacionAcademica';
    protected $fillable = [
        'tituloFormacionAcademica',
        'nivelFormacionAcademica',
        'anioFormacionAcademica',
        'institucionFormacionAcademica',
        'archivoFormacionAcademica',
        'personalID',
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }
}
