<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Grupo;
use App\Models\Aspecto;
use App\Models\AsignacionAspecto;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:tutor');
    }

    public function index()
    {
        // Verificar si es sábado y está en el horario permitido (8:00am a 11:00am)
        $now = Carbon::now();
        $isSaturday = $now->isSaturday();
        $inTimeRange = $now->between(
            $now->copy()->setHour(8)->setMinute(0),
            $now->copy()->setHour(11)->setMinute(0)
        );

        if (!$isSaturday || !$inTimeRange) {
            return redirect()->route('tutor.dashboard')->with('error', 'Solo puedes pasar asistencia los sábados de 8:00am a 11:00am.');
        }

        // Obtener el grupo del tutor
        $user = Auth::user();
        $grupo = Grupo::where('codigo_tutor', $user->codigo_tutor)
            ->with('estudiantes')
            ->first();

        if (!$grupo) {
            return redirect()->route('tutor.dashboard')->with('error', 'No tienes un grupo asignado.');
        }

        $aspectos = Aspecto::all();

        return view('asistencias.index', compact('grupo', 'aspectos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'asistencias' => 'required|array',
            'asistencias.*.codigo_estudiante' => 'required|exists:estudiantes,codigo',
            'asistencias.*.tipo' => 'required|in:A,I,J',
            'aspectos' => 'nullable|array',
            'aspectos.*.codigo_estudiante' => 'required|exists:estudiantes,codigo',
            'aspectos.*.aspecto_id' => 'required|exists:aspectos,id',
        ]);

        $user = Auth::user();

        // Registrar asistencias
        foreach ($request->asistencias as $asistenciaData) {
            Asistencia::create([
                'fecha' => $request->fecha,
                'codigo_estudiante' => $asistenciaData['codigo_estudiante'],
                'codigo_tutor' => $user->codigo_tutor,
                'tipo' => $asistenciaData['tipo'],
            ]);
        }

        // Registrar aspectos si existen
        if ($request->has('aspectos')) {
            foreach ($request->aspectos as $aspectoData) {
                AsignacionAspecto::create([
                    'aspecto_id' => $aspectoData['aspecto_id'],
                    'fecha' => $request->fecha,
                    'codigo_estudiante' => $aspectoData['codigo_estudiante'],
                    'codigo_tutor' => $user->codigo_tutor,
                ]);
            }
        }

        return redirect()->route('tutor.dashboard')->with('success', 'Asistencias y aspectos registrados exitosamente.');
    }
}
