<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Tutor;
use App\Models\Grupo;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra el dashboard según el rol del usuario
     */
    public function index()
    {
        return view('dashboard/admin');

    }

    /**
     * Dashboard para administradores
     */
    private function getDashboardData()
    {
        $totalEstudiantes = Estudiante::count();
        $totalTutores = Tutor::where('estado', 'contratado')->count(); 
        $totalGrupos = Grupo::count();

        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();

        $asistenciasMes = Asistencia::whereBetween('fecha', [$inicioMes, $finMes])
            ->get();

        
        $diasClaseMes = $inicioMes->diffInWeekdays($finMes) + 1; 
        $totalPosiblesAsistencias = Estudiante::where('estado', 'activo')->count() * $diasClaseMes; 

        $asistenciasPresentesMes = $asistenciasMes->where('tipo', 'A')->count();

        $porcentajeAsistencia = $totalPosiblesAsistencias > 0
            ? round(($asistenciasPresentesMes / $totalPosiblesAsistencias) * 100, 2)
            : 0;

        $gruposProblema = Grupo::withCount(['asistencias as inasistencias_justificadas_count' => function($query) use ($inicioMes, $finMes) {
                $query->whereBetween('fecha', [$inicioMes, $finMes])
                      ->whereIn('tipo', ['I', 'J']); 
            }])
            ->orderBy('inasistencias_justificadas_count', 'desc') 
            ->get();

        return [
            'totalEstudiantes' => $totalEstudiantes,
            'totalTutores' => $totalTutores,
            'totalGrupos' => $totalGrupos,
            'porcentajeAsistencia' => $porcentajeAsistencia,
            'gruposProblema' => $gruposProblema, 
        ];
    }

    public function adminDashboard()
    {
        $data = $this->getDashboardData();
        return view('dashboard.admin', $data);
    }

    public function exportPdf()
    {
        $data = $this->getDashboardData();
        $data['fechaExportacion'] = Carbon::now()->format('d/m/Y H:i:s');

        $pdf = Pdf::loadView('dashboard.pdf_export', $data);

        return $pdf->download('reporte-dashboard-' . date('Y-m-d_His') . '.pdf');
    }
}
