@extends('layouts.app')

@section('title', 'Perfil de Estudiante')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Perfil de Estudiante</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('reportes.index') }}?codigo_estudiante={{ $estudiante->codigo }}"
           class="btn btn-primary">
            <i class="fas fa-file-pdf"></i> Generar Reporte
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                @if($estudiante->fotografia)
                <img src="{{ asset('storage/' . $estudiante->fotografia) }}"
                     class="img-thumbnail mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded-circle"
                     style="width: 200px; height: 200px; margin: 0 auto 1rem;">
                    <i class="fas fa-user-graduate fa-5x text-secondary"></i>
                </div>
                @endif

                <h4>{{ $estudiante->nombres }} {{ $estudiante->apellidos }}</h4>
                <p class="text-muted">{{ $estudiante->codigo }}</p>

                <div class="d-flex justify-content-center mb-3">
                    <div class="semaforo {{ $semaforo }}"
                         title="Nivel de disciplina: {{ ucfirst($semaforo) }}"
                         data-bs-toggle="tooltip"></div>
                    <span class="align-self-center ms-2">
                        {{ ucfirst($semaforo) }}
                    </span>
                </div>

                <hr>

                <div class="text-start">
                    <p><strong>Email:</strong> {{ $estudiante->email }}</p>
                    <p><strong>Teléfono:</strong> {{ $estudiante->telefono }}</p>
                    <p><strong>Fecha Nacimiento:</strong>
                        {{ $estudiante->fecha_nacimiento ? $estudiante->fecha_nacimiento->format('d/m/Y') : 'N/A' }}</p>
                    <p><strong>Estado:</strong>
                        <span class="badge bg-{{ $estudiante->estado == 'activo' ? 'success' : 'secondary' }}">
                            {{ ucfirst($estudiante->estado) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#gruposTab">Grupos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#asistenciasTab">Asistencias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#aspectosTab">Aspectos</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="gruposTab">
                        <h5 class="card-title">Grupos Asignados</h5>
                        @if($estudiante->grupos->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Grupo</th>
                                        <th>Tutor</th>
                                        {{-- <th>Periodo</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($estudiante->grupos as $grupo)
                                    <tr>
                                        <td>
                                            <a href="{{ route('grupos.show', $grupo->id) }}">{{ $grupo->nombre }}</a>
                                        </td>
                                        <td>
                                            @if($grupo->tutor)
                                            <a href="{{ route('tutores.show', $grupo->tutor->codigo) }}">{{ $grupo->tutor->nombres }} {{ $grupo->tutor->apellidos }}</a>
                                            @else
                                            <span class="text-danger">Sin tutor asignado</span>
                                            @endif
                                        </td>
                                        {{-- <td>Año Actual</td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted">El estudiante no está asignado a ningún grupo actualmente.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="asistenciasTab">
                        <h5 class="card-title">Últimas Asistencias (Últimos 5 registros)</h5>
                        @if($asistencias->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Tutor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($asistencias as $asistencia)
                                    <tr>
                                        <td>{{ $asistencia->fecha ? $asistencia->fecha->format('d/m/Y') : 'N/A' }}</td>
                                        <td>
                                            @if($asistencia->tipo == 'A')
                                            <span class="badge bg-success">Asistió</span>
                                            @elseif($asistencia->tipo == 'J')
                                            <span class="badge bg-warning text-dark">Justificado</span>
                                            @else
                                            <span class="badge bg-danger">Inasistencia</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($asistencia->tutor)
                                            <a href="{{ route('tutores.show', $asistencia->tutor->codigo) }}">{{ $asistencia->tutor->nombres }} {{ $asistencia->tutor->apellidos }}</a>
                                            @else
                                            <span class="text-muted">Desconocido</span>
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

                    <div class="tab-pane fade" id="aspectosTab">
                        <h5 class="card-title">Aspectos Destacados (Últimos 5 registros)</h5>
                        @if($aspectos->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Descripción</th>
                                        <th>Tipo</th>
                                        <th>Tutor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($aspectos as $asignacionAspecto)
                                    <tr>
                                        <td>{{ $asignacionAspecto->fecha ? \Carbon\Carbon::parse($asignacionAspecto->fecha)->format('d/m/Y') : 'N/A' }}</td>
                                        <td>{{ $asignacionAspecto->aspecto->descripcion }}</td>
                                        <td>
                                            @if($asignacionAspecto->aspecto->tipo == 'P')
                                            <span class="badge bg-success">Positivo</span>
                                            @elseif($asignacionAspecto->aspecto->tipo == 'L')
                                            <span class="badge bg-primary">Leve</span>
                                            @elseif($asignacionAspecto->aspecto->tipo == 'G')
                                            <span class="badge bg-warning text-dark">Grave</span>
                                            @else
                                            <span class="badge bg-danger">Muy Grave</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($asignacionAspecto->tutor)
                                            <a href="{{ route('tutores.show', $asignacionAspecto->tutor->codigo) }}">{{ $asignacionAspecto->tutor->nombres }} {{ $asignacionAspecto->tutor->apellidos }}</a>
                                            @else
                                            <span class="text-muted">Desconocido</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted">No hay aspectos registrados recientemente para este estudiante.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Activar tooltips de Bootstrap
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection