<?php

namespace App\Http\Controllers;

use App\Models\AsignacionAspecto;
use App\Models\Asistencia;
use App\Models\Estudiante; 
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function index()
    {
        $estudiantes = Estudiante::where('estado', 'activo')->get();
        return view('reportes.index', compact('estudiantes'));
    }

    public function generar(Request $request)
    {
        $request->validate([
            'codigo_estudiante' => 'required|exists:estudiantes,codigo',
            'trimestre' => 'required|in:1,2,3',
        ]);

        $estudiante = Estudiante::findOrFail($request->codigo_estudiante);
        
        // Determinar fechas del trimestre
        $year = date('Y');
        $trimestre = $request->trimestre;
        
        if ($trimestre == 1) {
            $fechaInicio = Carbon::create($year, 2, 1); // Febrero
            $fechaFin = Carbon::create($year, 4, 30);   // Abril
        } elseif ($trimestre == 2) {
            $fechaInicio = Carbon::create($year, 5, 1); // Mayo
            $fechaFin = Carbon::create($year, 7, 31);   // Julio
        } else {
            $fechaInicio = Carbon::create($year, 8, 1); // Agosto
            $fechaFin = Carbon::create($year, 10, 31);  // Octubre
        }

        // Obtener datos para el reporte
        $asistencias = Asistencia::where('codigo_estudiante', $estudiante->codigo)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->get();

        $aspectosPositivos = AsignacionAspecto::with('aspecto')
            ->where('codigo_estudiante', $estudiante->codigo)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->whereHas('aspecto', function($query) {
                $query->where('tipo', 'P');
            })
            ->get();

        $aspectosMejorar = AsignacionAspecto::with('aspecto')
            ->where('codigo_estudiante', $estudiante->codigo)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->whereHas('aspecto', function($query) {
                $query->whereIn('tipo', ['L', 'G', 'MG']);
            })
            ->get();

        // Calcular semáforo de disciplina
        $semaforo = $this->calcularSemaforo($aspectosPositivos, $aspectosMejorar, $asistencias);

        $data = [
            'estudiante' => $estudiante,
            'trimestre' => $trimestre,
            'fechaInicio' => $fechaInicio->format('d/m/Y'),
            'fechaFin' => $fechaFin->format('d/m/Y'),
            'aspectosPositivos' => $aspectosPositivos,
            'aspectosMejorar' => $aspectosMejorar,
            'asistencias' => $asistencias,
            'semaforo' => $semaforo,
        ];

        // Generar el PDF con Dompdf
        $pdf = Pdf::loadView('reportes.pdf', $data);
        
        // Descargar el PDF
        return $pdf->download("reporte_{$estudiante->codigo}_trimestre_{$trimestre}.pdf");
        
    }

     private function calcularSemaforo($aspectosPositivos, $aspectosMejorar, $asistencias)
    {
        $countPositivos = $aspectosPositivos->count();
        $countLeves = $aspectosMejorar->where('aspecto.tipo', 'L')->count();
        $countGraves = $aspectosMejorar->where('aspecto.tipo', 'G')->count();
        $countMuyGraves = $aspectosMejorar->where('aspecto.tipo', 'MG')->count();
        $countInasistencias = $asistencias->where('tipo', 'I')->count();
        $countJustificadas = $asistencias->where('tipo', 'J')->count();

        // Reglas del semáforo
        if ($countMuyGraves >= 1) {
            return 'rojo';
        }

        if ($countGraves >= 2) {
            return 'rojo';
        }

        if (($countLeves >= 6 || $countInasistencias >= 4 || ($countLeves + $countInasistencias) >= 6) && $countGraves >= 1) {
            return 'rojo';
        }

        if ($countLeves >= 12 || $countInasistencias >= 8 || ($countLeves + $countInasistencias) >= 12) {
            return 'rojo';
        }

        if ($countGraves >= 1) {
            return 'amarillo';
        }

        if ($countLeves >= 6 || $countInasistencias >= 4 || ($countLeves + $countInasistencias) >= 6) {
            return 'amarillo';
        }

        if ($countPositivos >= 4 && ($countLeves <= 1 || $countInasistencias <= 1)) {
            return 'azul';
        }

        if ($countLeves <= 2 && $countInasistencias <= 2 && ($countLeves + $countInasistencias) <= 2) {
            return 'verde';
        }

        return 'verde'; // Por defecto
    }
}
