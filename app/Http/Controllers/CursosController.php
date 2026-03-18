<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\Niveles;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    public function index(Request $request)
    {
        $niveles = Niveles::all();

        if ($request->ajax()) {
            $nivelId = $request->nivel_id;
            $cursos = Cursos::whereHas('grado', function($q) use ($nivelId) {
                $q->where('nivelID', $nivelId);
            })
            ->where('estado', 'Activo') // Solo mostrar activos
            ->with('grado')
            ->get();

            return response()->json($cursos);
        }

        return view('admin.cursos.index', compact('niveles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreCurso' => 'required|string|max:100',
            'descripcionCurso' => 'nullable|string|max:255',
            'gradoID' => 'required',
            'nivelID' => 'required|exists:niveles,id',
        ]);

        try {
            $gradosIDs = [];
            if ($request->gradoID === 'all') {
                $gradosIDs = \App\Models\Grados::where('nivelID', $request->nivelID)->pluck('id')->toArray();
            } else {
                $gradosIDs[] = $request->gradoID;
            }

            if (empty($gradosIDs)) {
                return redirect()->back()
                    ->with('mensaje', 'No se encontraron grados para este nivel.')
                    ->with('icono', 'warning');
            }

            $creados = 0;
            $errores = 0;

            foreach ($gradosIDs as $gid) {
                // Verificar si ya existe para este grado concreto
                $existe = Cursos::where('nombreCurso', $request->nombreCurso)
                               ->where('gradoID', $gid)
                               ->first();

                if ($existe) {
                    $errores++;
                    continue; // Skip if exists
                }

                // Generación de código único
                $prefijo = strtoupper(substr(trim($request->nombreCurso), 0, 3));
                $ultimoCurso = Cursos::orderBy('idCurso', 'desc')->first();
                $nuevoId = ($ultimoCurso ? $ultimoCurso->idCurso : 0) + 1;
                $codigoAuto = $prefijo . '-' . str_pad($nuevoId, 3, '0', STR_PAD_LEFT);

                Cursos::create([
                    'codigoCurso' => $codigoAuto,
                    'nombreCurso' => $request->nombreCurso,
                    'descripcionCurso' => $request->descripcionCurso ?? 'NINGUNO',
                    'gradoID' => $gid,
                    'nivelID' => $request->nivelID,
                    'estado' => 'Activo',
                ]);
                $creados++;
            }

            if ($creados > 0) {
                $msg = ($request->gradoID === 'all') 
                    ? "Se han registrado $creados cursos para todos los grados del nivel."
                    : "El curso se ha registrado correctamente.";
                
                return redirect()->route('admin.cursos.index')
                    ->with('mensaje', $msg . ($errores > 0 ? " ($errores ya existían)" : ""))
                    ->with('icono', 'success');
            } else {
                return redirect()->back()
                    ->with('mensaje', 'El curso ya se encontraba registrado en los grados seleccionados.')
                    ->with('icono', 'warning');
            }

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('mensaje', 'Error al registrar el curso: ' . $e->getMessage())
                ->with('icono', 'error');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombreCurso' => 'required|string|max:100',
            'descripcionCurso' => 'nullable|string|max:255',
            'gradoID' => 'required|exists:grados,id',
        ]);

        try {
            $curso = Cursos::findOrFail($id);

            $existe = Cursos::where('nombreCurso', $request->nombreCurso)
                            ->where('gradoID', $request->gradoID)
                            ->where('idCurso', '!=', $id)
                            ->first();

            if ($existe) {
                return redirect()->back()
                    ->with('mensaje', 'Ya existe otro curso con el nombre "' . $request->nombreCurso . '" para este grado.')
                    ->with('icono', 'warning');
            }

            $curso->update([
                'nombreCurso' => $request->nombreCurso,
                'descripcionCurso' => $request->descripcionCurso ?? 'NINGUNO',
            ]);

            return redirect()->route('admin.cursos.index')
                ->with('mensaje', 'El curso se ha actualizado correctamente.')
                ->with('icono', 'success');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('mensaje', 'Error al actualizar el curso: ' . $e->getMessage())
                ->with('icono', 'error');
        }
    }

    public function destroy($id)
    {
        try {
            $curso = Cursos::findOrFail($id);
            
            $curso->update([
                'estado' => 'Inactivo'
            ]);

            return redirect()->route('admin.cursos.index')
                ->with('mensaje', 'El curso se ha desactivado correctamente.')
                ->with('icono', 'success');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('mensaje', 'Error al desactivar el curso: ' . $e->getMessage())
                ->with('icono', 'error');
        }
    }
}
