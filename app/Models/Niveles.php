<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Niveles extends Model
{
    protected $table = 'niveles';
    protected $fillable = [
        'nombreNivel',
    ];

    public function grados()
    {
        return $this->hasMany(Grados::class, 'nivelID');
    }

    public function matriculacions()
    {
        return $this->hasMany(Matriculacion::class, 'nivelesID', 'id');
    }
}
