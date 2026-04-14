<?php

namespace App\Http\Controllers;

use App\Models\Pagos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matriculacion;
use App\Models\Estudiante;
use App\Models\Configuraciones;
use Barryvdh\DomPDF\Facade\Pdf;


class PagosController extends Controller
{
    public function index(Request $request)
    {
        $matriculaciones = Matriculacion::with(['estudiante', 'gestion', 'nivel', 'grado', 'turno', 'pagos'])->get();
        $gestiones = $matriculaciones->pluck('gestion.nombreGestion')->unique();
        $rangoGestiones = $gestiones->count() > 1 
            ? $gestiones->min() . ' - ' . $gestiones->max() 
            : ($gestiones->first() ?? 'Sin Gestión');

        $matriculaciones = $matriculaciones->groupBy('estudianteID');
 
        return view('admin.pagos.index', compact('matriculaciones', 'rangoGestiones'));
    }

    public function show(Request $request)
    {
        $idEstudiante = $request->get('idEstudiante');
        if (!$idEstudiante) {
            return redirect()->route('admin.pagos.index')->with('error', 'Seleccione un estudiante');
        }

        $estudiante = Estudiante::findOrFail($idEstudiante);
        $matriculaciones = Matriculacion::with(['gestion', 'nivel', 'grado', 'turno', 'pagos', 'seccion'])
            ->where('estudianteID', $idEstudiante)
            ->latest()
            ->get();
    
        return view('admin.pagos.show', compact('estudiante', 'matriculaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'montoPago' => 'required|numeric',
            'metodoPago' => 'required|string',
            'fechaPago' => 'required|date',
            'matriculacionID' => 'required|exists:matriculacions,idMatriculacion',
            'estadoPago' => 'required|in:Pagado,Pendiente',
            'observacionesPago' => 'nullable|string',
            'fotoPago' => 'nullable|image|max:2048'
        ]);

        $nombreFoto = 'Ninguna';

        if ($request->metodoPago !== 'Efectivo') {
            if ($request->hasFile('fotoPago')) {
                $foto = $request->file('fotoPago');
                $nombreFoto = 'vouch_' . time() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('storage/pagos'), $nombreFoto);
            }
        }

        Pagos::create([
            'montoPago' => $request->montoPago,
            'metodoPago' => $request->metodoPago,
            'fechaPago' => $request->fechaPago,
            'fotoPago' => $nombreFoto,
            'observacionesPago' => $request->observacionesPago,
            'estadoPago' => $request->estadoPago,
            'matriculacionID' => $request->matriculacionID,
        ]);

        return redirect()->back()->with('success', 'Pago registrado correctamente.');
    }

    public function imprimir($idPago)
    {
        $configuracion = Configuraciones::first();
        $pago = Pagos::with(['matriculacion.estudiante', 'matriculacion.gestion', 'matriculacion.grado', 'matriculacion.nivel'])->findOrFail($idPago);
        
        $pdf = Pdf::loadView('admin.pagos.imprimir', compact('pago', 'configuracion'));
        return $pdf->stream('Recibo_Pago_' . $pago->idPago . '.pdf');
    }
}
