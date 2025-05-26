<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Asistencia;
use App\Models\AsignacionAspecto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EstudianteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin')->only(['index']);
    }

    /**
     * Muestra un listado de todos los estudiantes.
     */
    public function index()
    {
        $estudiantes = Estudiante::orderBy('apellidos')->orderBy('nombres')->paginate(15);
        return view('estudiante.index', compact('estudiantes'));
    }

    /**
     * Muestra el perfil de un estudiante
     */
    public function show($codigo)
    {
        $estudiante = Estudiante::with(['grupos', 'grupos.tutor'])
            ->findOrFail($codigo);

        // Obtener estadísticas recientes
        $asistencias = Asistencia::where('codigo_estudiante', $codigo)
            ->orderBy('fecha', 'desc')
            ->limit(5)
            ->get();

        $aspectos = AsignacionAspecto::with('aspecto')
            ->where('codigo_estudiante', $codigo)
            ->orderBy('fecha', 'desc')
            ->limit(5)
            ->get();

        // Calcular semáforo actual (último trimestre)
        $trimestreActual = $this->getTrimestreActual();
        list($fechaInicio, $fechaFin) = $this->getFechasTrimestre($trimestreActual);

        $aspectosPositivos = AsignacionAspecto::with('aspecto')
            ->where('codigo_estudiante', $codigo)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->whereHas('aspecto', fn($q) => $q->where('tipo', 'P'))
            ->get();

        $aspectosMejorar = AsignacionAspecto::with('aspecto')
            ->where('codigo_estudiante', $codigo)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->whereHas('aspecto', fn($q) => $q->whereIn('tipo', ['L', 'G', 'MG']))
            ->get();

        $asistenciasTrimestre = Asistencia::where('codigo_estudiante', $codigo)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->get();

        $semaforo = $this->calcularSemaforo($aspectosPositivos, $aspectosMejorar, $asistenciasTrimestre);

        return view('estudiante.show', compact(
            'estudiante',
            'asistencias',
            'aspectos',
            'semaforo',
            'trimestreActual'
        ));
    }

    /**
     * Métodos auxiliares reutilizados de ReporteController
     */
    private function getTrimestreActual()
    {
        $mes = Carbon::now()->month;
        return match (true) {
            $mes >= 2 && $mes <= 4 => 1,
            $mes >= 5 && $mes <= 7 => 2,
            default => 3
        };
    }

    private function getFechasTrimestre($trimestre)
    {
        $year = Carbon::now()->year;
        return match ($trimestre) {
            1 => [Carbon::create($year, 2, 1), Carbon::create($year, 4, 30)],
            2 => [Carbon::create($year, 5, 1), Carbon::create($year, 7, 31)],
            3 => [Carbon::create($year, 8, 1), Carbon::create($year, 10, 31)],
        };
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
