<?php

namespace App\Http\Controllers;

use App\Models\FormacionAcademica;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Personal;

class FormacionAcademicaController extends Controller
{
    public function index($idFormacionAcademica)
    {
        $personal = Personal::find($idFormacionAcademica);
        $formacionAcademica = FormacionAcademica::where('personalID', $idFormacionAcademica)->get();
        return view('admin.formacion_academica.index', compact('formacionAcademica', 'personal'));
    }

    public function store(Request $request, $idFormacionAcademica)
    {
        $request->validate([
            'tituloFormacionAcademica' => 'required|string|max:255',
            'nivelFormacionAcademica' => 'required|string|max:255',
            'anioFormacionAcademica' => 'required|integer|min:1950|max:'.(date('Y') + 1),
            'institucionFormacionAcademica' => 'required|string|max:255',
            'archivoFormacionAcademica' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            // Verificación de duplicados
            $existe = FormacionAcademica::where('personalID', $idFormacionAcademica)
                ->where('tituloFormacionAcademica', $request->tituloFormacionAcademica)
                ->where('nivelFormacionAcademica', $request->nivelFormacionAcademica)
                ->where('institucionFormacionAcademica', $request->institucionFormacionAcademica)
                ->first();

            if ($existe) {
                return redirect()->back()
                    ->with('mensaje', 'Esta formación académica ya se encuentra registrada para este personal.')
                    ->with('icono', 'error')
                    ->withInput();
            }

            $formacion = new FormacionAcademica();
            $formacion->tituloFormacionAcademica = $request->tituloFormacionAcademica;
            $formacion->nivelFormacionAcademica = $request->nivelFormacionAcademica;
            $formacion->anioFormacionAcademica = $request->anioFormacionAcademica;
            $formacion->institucionFormacionAcademica = $request->institucionFormacionAcademica;
            $formacion->personalID = $idFormacionAcademica;

            if ($request->hasFile('archivoFormacionAcademica')) {
                $file = $request->file('archivoFormacionAcademica');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/formacion_academica/'), $filename);
                $formacion->archivoFormacionAcademica = 'uploads/formacion_academica/' . $filename;
            }

            $formacion->save();

            return redirect()->route('admin.formacionAcademica.index', $idFormacionAcademica)
                ->with('mensaje', 'Formación Académica registrada con éxito.')
                ->with('icono', 'success');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('mensaje', 'Error al registrar: ' . $e->getMessage())
                ->with('icono', 'error')
                ->withInput();
        }
    }

    public function show($id)
    {
        $formacion = FormacionAcademica::findOrFail($id);
        return response()->json($formacion);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tituloFormacionAcademica' => 'required|string|max:255',
            'nivelFormacionAcademica' => 'required|string|max:255',
            'anioFormacionAcademica' => 'required|integer|min:1950|max:'.(date('Y') + 1),
            'institucionFormacionAcademica' => 'required|string|max:255',
            'archivoFormacionAcademica' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            $formacion = FormacionAcademica::findOrFail($id);

            // Verificación de duplicados (excluyendo el actual)
            $existe = FormacionAcademica::where('personalID', $formacion->personalID)
                ->where('tituloFormacionAcademica', $request->tituloFormacionAcademica)
                ->where('nivelFormacionAcademica', $request->nivelFormacionAcademica)
                ->where('institucionFormacionAcademica', $request->institucionFormacionAcademica)
                ->where('idFormacionAcademica', '!=', $id)
                ->first();

            if ($existe) {
                return redirect()->back()
                    ->with('mensaje', 'Esta formación académica ya se encuentra registrada para este personal.')
                    ->with('icono', 'error')
                    ->withInput();
            }

            $formacion->tituloFormacionAcademica = $request->tituloFormacionAcademica;
            $formacion->nivelFormacionAcademica = $request->nivelFormacionAcademica;
            $formacion->anioFormacionAcademica = $request->anioFormacionAcademica;
            $formacion->institucionFormacionAcademica = $request->institucionFormacionAcademica;

            if ($request->hasFile('archivoFormacionAcademica')) {
                // Eliminar archivo anterior si existe
                if ($formacion->archivoFormacionAcademica && file_exists(public_path($formacion->archivoFormacionAcademica))) {
                    unlink(public_path($formacion->archivoFormacionAcademica));
                }

                $file = $request->file('archivoFormacionAcademica');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/formacion_academica/'), $filename);
                $formacion->archivoFormacionAcademica = 'uploads/formacion_academica/' . $filename;
            }

            $formacion->save();

            return redirect()->route('admin.formacionAcademica.index', $formacion->personalID)
                ->with('mensaje', 'Formación Académica actualizada con éxito.')
                ->with('icono', 'success');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('mensaje', 'Error al actualizar: ' . $e->getMessage())
                ->with('icono', 'error')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $formacion = FormacionAcademica::findOrFail($id);
            $personalID = $formacion->personalID;

            // Eliminar archivo si existe
            if ($formacion->archivoFormacionAcademica && file_exists(public_path($formacion->archivoFormacionAcademica))) {
                unlink(public_path($formacion->archivoFormacionAcademica));
            }

            $formacion->delete();

            return redirect()->route('admin.formacionAcademica.index', $personalID)
                ->with('mensaje', 'Formación Académica eliminada correctamente.')
                ->with('icono', 'success');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('mensaje', 'Error al eliminar: ' . $e->getMessage())
                ->with('icono', 'error');
        }
    }

}
