<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Estudiante;
use App\Models\Aspecto;
use App\Models\Asistencia;
use App\Models\AsignacionAspecto;
use App\Models\Tutor;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Verifica si la ventana de tiempo para tomar asistencia está actualmente abierta.
     * (Sábados de 8:00 AM a 11:00 AM)
     * @return bool
     */
    public static function isAttendanceWindowOpen(): bool
    {
        $now = Carbon::now();
        // Saturday is day 6 of the week (ISO standard, Monday is 1)
        return ($now->dayOfWeekIso == 6 && $now->hour >= 8 && $now->hour < 11);
    }

    /**
     * Show the form for creating a new attendance record.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tutor = Auth::user()->tutor;
        if (!$tutor) {
            return redirect('/')->with('error', 'No se encontró el perfil de tutor.');
        }

        $estudiantes = Estudiante::whereHas('grupos', function ($query) use ($tutor) {
            $query->where('codigo_tutor', $tutor->codigo);
        })
        ->orderBy('apellidos')
        ->orderBy('nombres')
        ->get();

        $aspectosPositivos = Aspecto::where('tipo', Aspecto::TIPO_POSITIVO)->orderBy('descripcion')->get();
        $aspectosMejorar = Aspecto::where('tipo', Aspecto::TIPO_A_MEJORAR)->orderBy('descripcion')->get();
        $fechaHoy = Carbon::today();


        return view('tutor.attendance.create', compact('tutor', 'estudiantes', 'aspectosPositivos', 'aspectosMejorar', 'fechaHoy'));
    }

    /**
     * Store a newly created attendance record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $tutor = Auth::user()->tutor;
        if (!$tutor) {
            return redirect()->route('tutor.asistencia.create')->with('error', 'Acción no autorizada.');
        }

        $request->validate([
            'estudiantes' => 'sometimes|array',
            'estudiantes.*.asistio' => 'nullable|string|in:1', 
            'estudiantes.*.aspectos_positivos' => 'sometimes|array',
            'estudiantes.*.aspectos_positivos.*' => 'nullable|integer|exists:aspectos,id',
            'estudiantes.*.aspectos_mejorar' => 'sometimes|array',
            'estudiantes.*.aspectos_mejorar.*' => 'nullable|integer|exists:aspectos,id',
            'fecha_asistencia' => 'required|date_format:Y-m-d',
        ]);

        $fechaAsistencia = Carbon::parse($request->input('fecha_asistencia'))->toDateString();
        $fechaHoy = Carbon::today()->toDateString();

        if ($fechaAsistencia !== $fechaHoy) {
             return redirect()->route('tutor.asistencia.create')->with('error', 'La asistencia solo se puede registrar para el día de hoy.');
        }


        DB::beginTransaction();
        try {
            $submittedEstudiantes = $request->input('estudiantes', []);

            foreach ($submittedEstudiantes as $estudianteCodigo => $data) {
                
                if (isset($data['asistio']) && $data['asistio'] == '1') {
                    Asistencia::updateOrCreate(
                        [
                            'fecha' => $fechaHoy,
                            'codigo_estudiante' => $estudianteCodigo,
                        ],
                        [
                            'codigo_tutor' => $tutor->codigo,
                            'tipo' => Asistencia::TIPO_PRESENTE
                        ]
                    );
                } else {
                
                }

                foreach ($data['aspectos_positivos'] ?? [] as $aspectoId) {
                    if (!empty($aspectoId)) {
                        AsignacionAspecto::firstOrCreate(
                            [
                                'aspecto_id' => $aspectoId,
                                'fecha' => $fechaHoy,
                                'codigo_estudiante' => $estudianteCodigo,
                                'codigo_tutor' => $tutor->codigo
                            ]
                        );
                    }
                }

                foreach ($data['aspectos_mejorar'] ?? [] as $aspectoId) {
                     if (!empty($aspectoId)) {
                        AsignacionAspecto::firstOrCreate(
                            [
                                'aspecto_id' => $aspectoId,
                                'fecha' => $fechaHoy,
                                'codigo_estudiante' => $estudianteCodigo,
                                'codigo_tutor' => $tutor->codigo
                            ]
                        );
                    }
                }
            }

            DB::commit();
            return redirect()->route('tutor.asistencia.create')->with('success', 'Asistencia y aspectos guardados correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tutor.asistencia.create')->with('error', 'Error al guardar la información. Intente nuevamente.');
        }
    }
}
