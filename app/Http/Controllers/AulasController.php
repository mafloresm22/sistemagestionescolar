<?php

namespace App\Http\Controllers;

use App\Models\Aulas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AulasController extends Controller
{
    public function index()
    {
        $aulas = Aulas::orderBy('idAulas', 'desc')->get();
        return view('admin.aulas.index', compact('aulas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreAula' => 'required|string|max:255|unique:aulas,nombreAula',
            'capacidadAula' => 'required|integer|min:1',
        ]);

        Aulas::create([
            'nombreAula' => $request->nombreAula,
            'capacidadAula' => $request->capacidadAula,
            'estadoAula' => 'Disponible'
        ]);

        return redirect()->route('admin.aulas.index')->with([
            'mensaje' => 'Aula creada con éxito',
            'icono' => 'success'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombreAula' => 'required|string|max:255',
            'capacidadAula' => 'required|integer|min:1',
            'estadoAula' => 'required|string',
        ]);

        $aula = Aulas::findOrFail($id);
        $aula->update($request->all());

        return redirect()->route('admin.aulas.index')->with([
            'mensaje' => 'Aula actualizada con éxito',
            'icono' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $aula = Aulas::findOrFail($id);
        $aula->delete();

        return redirect()->route('admin.aulas.index')->with([
            'mensaje' => 'Aula eliminada con éxito',
            'icono' => 'success'
        ]);
    }
}
