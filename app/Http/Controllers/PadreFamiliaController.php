<?php

namespace App\Http\Controllers;

use App\Models\PadreFamilia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PadreFamiliaController extends Controller
{
    public function index()
    {
        $padres = PadreFamilia::all();
        return view('admin.padrefamilias.index', compact('padres'));
    }

    public function store(Request $request)
    {
        // Verificar si ya existe por DNI antes de validar todo
        $existe = PadreFamilia::where('dniPadreFamilia', $request->dniPadreFamilia)->first();
        if ($existe) {
            return redirect()->back()->with([
                'mensaje' => 'Error: El DNI ' . $request->dniPadreFamilia . ' ya pertenece a ' . $existe->nombrePadreFamilia . ' ' . $existe->apellidoPadreFamilia . '.',
                'icono' => 'error'
            ]);
        }

        $request->validate([
            'nombrePadreFamilia' => 'required|string|max:150',
            'apellidoPadreFamilia' => 'required|string|max:150',
            'dniPadreFamilia' => 'required|numeric',
            'fechaNacimientoPadreFamilia' => 'required|date',
            'generoPadreFamilia' => 'required|string|max:1',
            'celularPadreFamilia' => 'required|numeric',
            'correoPadreFamilia' => 'nullable|max:150',
            'direccionPadreFamilia' => 'required|string|max:255',
        ]);

        $data = $request->all();
        if (empty($data['correoPadreFamilia'])) {
            $data['correoPadreFamilia'] = 'Ninguno';
        }

        PadreFamilia::create($data);

        return redirect()->back()->with([
            'mensaje' => 'Apoderado registrado correctamente',
            'icono' => 'success'
        ]);
    }
    public function update(Request $request, $idPadreFamilia)
    {
        $padreFamilia = PadreFamilia::findOrFail($idPadreFamilia);

        $request->validate([
            'nombrePadreFamilia' => 'required|string|max:150',
            'apellidoPadreFamilia' => 'required|string|max:150',
            'dniPadreFamilia' => 'required|numeric',
            'fechaNacimientoPadreFamilia' => 'required|date',
            'generoPadreFamilia' => 'required|string|max:1',
            'celularPadreFamilia' => 'required|numeric',
            'correoPadreFamilia' => 'nullable|max:150',
            'direccionPadreFamilia' => 'required|string|max:255',
        ]);

        $data = $request->all();
        if (empty($data['correoPadreFamilia'])) {
            $data['correoPadreFamilia'] = 'Ninguno';
        }

        $padreFamilia->update($data);

        return redirect()->back()->with([
            'mensaje' => 'Datos del apoderado actualizados con éxito',
            'icono' => 'success'
        ]);
    }

    public function destroy(Request $request, $idPadreFamilia)
    {
        try {
            $padreFamilia = PadreFamilia::findOrFail($idPadreFamilia);
            
            // Recibimos el estado enviado por JS, por defecto si no hay, asume 'Inactivo'
            $nuevoEstado = $request->input('nuevoEstado', 'Inactivo');
            
            $padreFamilia->estadoPadreFamilia = $nuevoEstado;
            $padreFamilia->save();
            
            $mensajeStr = $nuevoEstado === 'Activo' 
                ? '¡Registro reactivado! El estado del apoderado cambió a Activo.' 
                : '¡Registro inhabilitado! El estado del apoderado cambió a Inactivo.';

            return redirect()->back()->with([
                'mensaje' => $mensajeStr,
                'icono' => 'success'
            ]);
                
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'mensaje' => 'Error al cambiar de estado: ' . $e->getMessage(),
                'icono' => 'error'
            ]);
        }
    }
}
