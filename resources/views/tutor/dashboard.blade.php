@extends('layouts.app') 
{{-- Nota: El path original era tutores/dashboard.blade.php, lo he cambiado a tutor/dashboard.blade.php para que coincida con el controlador --}}
@section('title', 'Mi Dashboard - Tutor')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard del Tutor: {{ $tutor->nombres }} {{ $tutor->apellidos }}</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <!-- Sección para Pasar Asistencia -->
    @if (isset($canTakeAttendance)) {{-- Asegurarse que la variable exista --}}
        @if ($canTakeAttendance)
            <div class="mb-3">
                <a href="{{ route('tutor.asistencia.create') }}" class="btn btn-lg btn-success">
                    <i class="fas fa-calendar-check"></i> Pasar Asistencia de Hoy
                </a>
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                <i class="fas fa-info-circle"></i> La opción para pasar asistencia solo está disponible los sábados de 8:00 AM a 11:00 AM.
            </div>
        @endif
    @endif

    <!-- Tarjetas de Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Estudiantes a Cargo</h5>
                            <h2 class="card-text">{{ $totalEstudiantes }}</h2>
                        </div>
                        <i class="fas fa-user-graduate fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Grupos Asignados</h5>
                            <h2 class="card-text">{{ $totalGrupos }}</h2>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Asistencia ({{ $mesActual }})</h5>
                            <h2 class="card-text">{{ $porcentajeAsistencia }}%</h2>
                        </div>
                        <i class="fas fa-chart-line fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>Mis Grupos Asignados <small class="text-muted">(Ordenados por mayor ausentismo en {{ $mesActual }})</small></h4>

            @if($gruposConteoAsistencias->isEmpty())
                <div class="alert alert-info mt-3" role="alert">
                    <i class="fas fa-info-circle"></i> Actualmente no tienes grupos asignados.
                </div>
            @else
                @foreach($gruposConteoAsistencias as $grupo)
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-users"></i> Grupo: {{ $grupo->nombre }}
                                <small class="text-white-50">(Código: {{ $grupo->codigo }})</small>
                                <span class="badge bg-light text-dark float-end mt-1">Ausencias/Justif. este mes: {{ $grupo->inasistencias_justificadas_count }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Nivel:</strong> {{ $grupo->nivel ?? 'No especificado' }} | <strong>Jornada:</strong> {{ $grupo->jornada ?? 'No especificada' }}</p>
                            @if($grupo->estudiantes->isEmpty())
                                <p class="text-muted">Este grupo no tiene estudiantes asignados actualmente.</p>
                            @else
                                <h6 class="card-subtitle mb-2 text-muted">Estudiantes en este grupo ({{ $grupo->estudiantes->count() }}):</h6>
                                <ul class="list-group list-group-flush">
                                    @foreach($grupo->estudiantes as $estudiante)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                <i class="fas fa-user-graduate"></i> {{ $estudiante->nombres }} {{ $estudiante->apellidos }}
                                                <small class="text-muted">(Código: {{ $estudiante->codigo }})</small>
                                            </span>
                                            <a href="{{ route('estudiantes.show', $estudiante->codigo) }}" class="btn btn-sm btn-outline-info" title="Ver Perfil del Estudiante">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection