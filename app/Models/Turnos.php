<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turnos extends Model
{
    protected $table = 'turnos';
    protected $fillable = [
        'nombreTurno'
    ];
}
