<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grados extends Model
{
    protected $table = 'grados';
    protected $fillable = [
        'nombreGrado',
        'nivelID',
    ];

    public function nivel()
    {
        return $this->belongsTo(Niveles::class, 'nivelID');
    }

    public function secciones()
    {
        return $this->hasMany(Secciones::class, 'gradoID');
    }
}
