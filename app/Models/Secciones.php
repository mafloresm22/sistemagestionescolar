<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Secciones extends Model
{
    protected $table = 'secciones';
    protected $primaryKey = 'idSeccion';
    protected $fillable = [
        'nombreSeccion',
        'gradoID',
    ];

    public function grados()
    {
        return $this->belongsTo(Grados::class, 'gradoID');
    }

    public function matriculacions()
    {
        return $this->hasMany(Matriculacion::class, 'seccionID', 'idSeccion');
    }
}
