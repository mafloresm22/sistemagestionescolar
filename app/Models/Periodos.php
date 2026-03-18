<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodos extends Model
{
   protected $table = 'periodos';
   protected $fillable = [
       'nombrePeriodo',
       'gestionID',
   ];
   public function gestion()
   {
       return $this->belongsTo(Gestion::class, 'gestionID');
   }
}
