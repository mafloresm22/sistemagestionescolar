<?php

namespace App\Http\Controllers;

use App\Models\Pagos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matriculacion;

class PagosController extends Controller
{
    public function index(Request $request)
    {
        $idMatriculacion = $request->get('idMatriculacion');
        if ($idMatriculacion) {
            $matriculacion = Matriculacion::with(['estudiante', 'gestion', 'nivel', 'grado'])->findOrFail($idMatriculacion);
            $pagos = Pagos::where('matriculacionID', $idMatriculacion)->orderBy('fechaPago', 'desc')->get();
        
            return view('admin.pagos.index', compact('matriculacion', 'pagos'));
        } else {
            $matriculaciones = Matriculacion::with(['estudiante', 'gestion', 'nivel', 'grado', 'turno'])->get();
            return view('admin.pagos.index', compact('matriculaciones'));
        }
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pagos $pagos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pagos $pagos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pagos $pagos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pagos $pagos)
    {
        //
    }
}
