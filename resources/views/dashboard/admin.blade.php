@extends('layouts.app')

@section('title', 'Dashboard - Administrador')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Panel de Administración</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.dashboard.export.pdf') }}" class="btn btn-sm btn-outline-secondary">Exportar PDF</a>        
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <a href="{{ route('estudiantes.index') }}" class="text-decoration-none">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Estudiantes</h5>
                            <h2 class="mb-0">{{ $totalEstudiantes }}</h2>
                        </div>
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('tutores.index') }}" class="text-decoration-none">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Tutores Activos</h5>
                            <h2 class="mb-0">{{ $totalTutores }}</h2>
                        </div>
                        <i class="fas fa-chalkboard-teacher fa-3x"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('grupos.index') }}" class="text-decoration-none">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Grupos</h5>
                            <h2 class="mb-0">{{ $totalGrupos }}</h2>
                        </div>
                        <i class="fas fa-layer-group fa-3x"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Asistencia Mensual</h5>
            </div>
            <div class="card-body">
                <div class="text-center py-4">
                    <h3>{{ $porcentajeAsistencia }}%</h3>
                    <div class="progress mt-3">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ $porcentajeAsistencia }}%" 
                             aria-valuenow="{{ $porcentajeAsistencia }}" 
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-2 mb-0">Porcentaje de asistencia este mes</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Grupos con Menor Asistencia</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($gruposProblema as $grupo)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('grupos.show', $grupo->id) }}" class="text-decoration-none text-dark">
                                {{ $grupo->nombre }}
                            </a>
                            {{-- La propiedad para el conteo de asistencias/inasistencias podría variar según tu lógica en getDashboardData --}}
                            {{-- Asumiendo que es 'inasistencias_justificadas_count' o similar, o 'asistencias_count' si es un conteo general --}}
                            <span class="badge bg-danger rounded-pill">{{ $grupo->inasistencias_justificadas_count ?? $grupo->asistencias_count ?? 0 }} inasistencias/just.</span>
                        </li>
                    @empty
                    <li class="list-group-item">No hay datos disponibles</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection