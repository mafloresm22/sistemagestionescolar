<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Matriculacion;
use App\Models\Calificaciones;
use App\Models\Niveles;
use App\Models\Pagos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function index()
    {
        // 1. Estudiantes por Género
        $generos = Estudiante::select('generoEstudiante', DB::raw('count(*) as total'))
            ->groupBy('generoEstudiante')
            ->get();

        // 2. Estado de Matriculación
        $estadosMatricula = Matriculacion::select('estadoMatriculacion', DB::raw('count(*) as total'))
            ->groupBy('estadoMatriculacion')
            ->get();

        // 3. Estudiantes por Nivel
        $estudiantesPorNivel = Matriculacion::join('niveles', 'matriculacions.nivelesID', '=', 'niveles.id')
            ->select('niveles.nombreNivel', DB::raw('count(*) as total'))
            ->groupBy('niveles.nombreNivel')
            ->get();

        // 4. Distribución de Calificaciones (Literales)
        $distribucionNotas = Calificaciones::select('calificacionLiteralCalificaciones', DB::raw('count(*) as total'))
            ->whereNotNull('calificacionLiteralCalificaciones')
            ->groupBy('calificacionLiteralCalificaciones')
            ->orderByRaw("FIELD(calificacionLiteralCalificaciones, 'AD', 'A', 'B', 'C')")
            ->get();

        // 5. Recaudación de Pagos (últimos 6 meses)
        $pagosMensuales = Pagos::select(
                DB::raw('MONTH(fechaPago) as mes'),
                DB::raw('SUM(montoPago) as total')
            )
            ->where('estadoPago', 'Pagado')
            ->where('fechaPago', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Preparar nombres de meses
        $mesesNombres = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];

        $pagosData = $pagosMensuales->map(function($item) use ($mesesNombres) {
            return [
                'mes' => $mesesNombres[$item->mes],
                'total' => $item->total
            ];
        });

        // Totales generales para las tarjetas superiores
        $totalEstudiantes = Estudiante::count();
        $totalMatriculados = Matriculacion::where('estadoMatriculacion', 'Activo')->count();
        $totalIngresos = Pagos::where('estadoPago', 'Pagado')->sum('montoPago');

        return view('admin.reportes.index', compact(
            'generos',
            'estadosMatricula',
            'estudiantesPorNivel',
            'distribucionNotas',
            'pagosData',
            'totalEstudiantes',
            'totalMatriculados',
            'totalIngresos'
        ));
    }
}