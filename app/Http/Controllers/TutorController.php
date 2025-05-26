<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\Grupo;
use App\Models\Asistencia;
use Carbon\Carbon;

class TutorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin')->only(['index']);
    }

    /**
     * Muestra un listado de todos los tutores.
     */
    public function index()
    {
        $tutores = \App\Models\Tutor::with('user')->paginate(10); 
        return view('tutores.index', compact('tutores'));
    }

    /**
     * Muestra el perfil de un tutor
     */
    public function show(Tutor $tutor)
    {
        $totalAsistencias = $tutor->asistencias()->where('tipo', 'A')->count();

        $totalInasistencias = $tutor->asistencias()->where('tipo', 'I')->count();

        $totalJustificadas = $tutor->asistencias()->where('tipo', 'J')->count();

        $asistenciasRecientes = $tutor->asistencias()
                                    ->with('estudiante') 
                                    ->orderBy('fecha', 'desc')
                                    ->limit(5) 
                                    ->get();

        return view('tutores.show', [
            'tutor' => $tutor,
            'totalAsistencias' => $totalAsistencias,       
            'totalInasistencias' => $totalInasistencias,  
            'totalJustificadas' => $totalJustificadas,     
            'asistenciasRecientes' => $asistenciasRecientes, 
        ]);
    }

    /**
     * Muestra el dashboard específico para tutores
     */
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'tutor' || !$user->tutor) {
            return redirect()->route('login')->with('error', 'Acceso no autorizado o perfil de tutor no encontrado.');
        }

        $tutor = $user->tutor;
        $dashboardData = $this->getTutorDashboardData($tutor);

        return view('tutor.dashboard', array_merge(compact('tutor'), $dashboardData));
    }

    private function getTutorDashboardData(Tutor $tutor)
    {
        $totalGrupos = $tutor->grupos()->count();

        $estudiantesDelTutorIds = [];
        $tutor->grupos()->with('estudiantes:codigo')->get()->each(function ($grupo) use (&$estudiantesDelTutorIds) {
            foreach ($grupo->estudiantes as $estudiante) {
                $estudiantesDelTutorIds[$estudiante->codigo] = true;
            }
        });
        $totalEstudiantes = count($estudiantesDelTutorIds);
        $codigosEstudiantesDelTutor = array_keys($estudiantesDelTutorIds);

        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();

        $asistenciasMesTutor = Asistencia::whereIn('codigo_estudiante', $codigosEstudiantesDelTutor)
            ->whereBetween('fecha', [$inicioMes, $finMes])
            ->get();

        $diasClaseMes = 0; 
        $currentDay = $inicioMes->copy();
        while ($currentDay->lte($finMes)) {
            if ($currentDay->isSaturday()) { $diasClaseMes++; }
            $currentDay->addDay();
        }

        $totalPosiblesAsistencias = $totalEstudiantes * $diasClaseMes;
        $asistenciasPresentesMes = $asistenciasMesTutor->where('tipo', 'A')->count();
        $porcentajeAsistencia = $totalPosiblesAsistencias > 0 ? round(($asistenciasPresentesMes / $totalPosiblesAsistencias) * 100, 2) : 0;

        $gruposConteoAsistencias = $tutor->grupos()
            ->withCount(['asistencias as inasistencias_justificadas_count' => function($query) use ($inicioMes, $finMes) {
                $query->whereBetween('fecha', [$inicioMes, $finMes])->whereIn('tipo', ['I', 'J']);
            }])
            ->with('estudiantes') 
            ->orderBy('inasistencias_justificadas_count', 'desc')
            ->get();

        return [
            'totalEstudiantes' => $totalEstudiantes,
            'totalGrupos' => $totalGrupos,
            'porcentajeAsistencia' => $porcentajeAsistencia,
            'gruposConteoAsistencias' => $gruposConteoAsistencias, 
            'mesActual' => Carbon::now()->translatedFormat('F Y'),
        ];
    }
}
