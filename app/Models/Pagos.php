<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'idPago';
    protected $fillable = [
        'montoPago',
        'metodoPago',
        'fechaPago',
        'fotoPago',
        'observacionesPago',
        'estadoPago',
        'matriculacionID',
    ];

    public function matriculacion()
    {
        return $this->belongsTo(Matriculacion::class, 'matriculacionID', 'idMatriculacion');
    }
}
