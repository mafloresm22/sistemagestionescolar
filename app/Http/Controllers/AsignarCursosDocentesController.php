<?php

namespace App\Http\Controllers;

use App\Models\AsignarCursosDocentes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsignarCursosDocentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asignaciones = AsignarCursosDocentes::with([
            'docente', 'curso', 'gestion', 'nivel', 'grado', 'seccion', 'turno'
        ])->get();

        return view('admin.asignaciones_curso_docente.index', compact('asignaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
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
    public function show(AsignarCursosDocentes $asignarCursosDocentes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AsignarCursosDocentes $asignarCursosDocentes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AsignarCursosDocentes $asignarCursosDocentes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AsignarCursosDocentes $asignarCursosDocentes)
    {
        //
    }
}
