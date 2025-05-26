@extends('layouts.app')

@section('title', 'Perfil de Tutor')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Perfil de Tutor</h1>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="bg-light d-flex align-items-center justify-content-center" 
                     style="width: 200px; height: 200px; margin: 0 auto 1rem;">
                    <i class="fas fa-chalkboard-teacher fa-5x text-secondary"></i>
                </div>
                
                <h4>{{ $tutor->nombres }} {{ $tutor->apellidos }}</h4>
                <p class="text-muted">{{ $tutor->codigo }}</p>
                
                <hr>
                
                <div class="text-start">
                    <p><strong>Email:</strong> {{ $tutor->email }}</p>
                    <p><strong>Teléfono:</strong> {{ $tutor->telefono }}</p>
                    <p><strong>Fecha Nacimiento:</strong> 
                        @if($tutor->fecha_nacimiento)
                            {{ $tutor->fecha_nacimiento->format('d/m/Y') }}
                        @endif</p>
                    <p><strong>Fecha Contratación:</strong> 
                        @if($tutor->fecha_contratacion)
                            {{ $tutor->fecha_contratacion->format('d/m/Y') }}
                        @endif</p>
                    <p><strong>Estado:</strong> 
                        <span class="badge bg-{{ $tutor->estado == 'contratado' ? 'success' : 'secondary' }}">
                            {{ ucfirst($tutor->estado) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Grupos a Cargo</h5>
            </div>
            <div class="card-body">
                @if($tutor->grupos->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Grupo</th>
                                <th>Estudiantes</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tutor->grupos as $grupo)
                            <tr>
                                <td>{{ $grupo->nombre }}</td>
                                <td>{{ $grupo->estudiantes->count() }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">El tutor no tiene grupos asignados actualmente.</p>
                @endif
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Estadísticas de Asistencia</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">
                                <h5>Asistencias</h5>
                                    <h2>{{ $totalAsistencias }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger text-white mb-3">
                            <div class="card-body">
                                <h5>Inasistencias</h5>
                                <h2>{{ $totalInasistencias }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-dark mb-3">
                            <div class="card-body">
                                <h5>Justificadas</h5>
                                <h2>{{ $totalJustificadas }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h5 class="mt-4">Últimos Registros</h5>
                @if($asistenciasRecientes->isNotEmpty())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Estudiante</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistenciasRecientes as $asistencia)
                            <tr>
                                <td>{{ $asistencia->fecha->format('d/m/Y') }}</td>
                                <td>{{ $asistencia->estudiante->nombres }}</td>
                                <td>
                                    @if($asistencia->tipo == 'A')
                                    <span class="badge bg-success">Asistió</span>
                                    @elseif($asistencia->tipo == 'J')
                                    <span class="badge bg-warning text-dark">Justificado</span>
                                    @else
                                    <span class="badge bg-danger">Inasistencia</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">No hay registros de asistencia recientes.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection