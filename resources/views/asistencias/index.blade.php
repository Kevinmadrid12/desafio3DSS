@extends('layouts.app')

@section('title', 'Registro de Asistencias')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Registro de Asistencias</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <span class="btn btn-sm btn-outline-secondary disabled">
                <i class="fas fa-calendar-day"></i> {{ now()->format('d/m/Y') }}
            </span>
        </div>
    </div>
</div>

@if($grupo)
<form method="POST" action="{{ route('asistencias.store') }}">
    @csrf
    <input type="hidden" name="fecha" value="{{ now()->format('Y-m-d') }}">
    
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Grupo: {{ $grupo->nombre }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Estudiante</th>
                            <th width="150">Asistencia</th>
                            <th width="250">Aspecto Destacado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupo->estudiantes as $estudiante)
                        <tr>
                            <td>
                                <input type="hidden" name="asistencias[{{ $loop->index }}][codigo_estudiante]" 
                                       value="{{ $estudiante->codigo }}">
                                {{ $estudiante->nombres }} {{ $estudiante->apellidos }}
                            </td>
                            <td>
                                <select name="asistencias[{{ $loop->index }}][tipo]" class="form-select" required>
                                    <option value="A" selected>Asistió</option>
                                    <option value="I">Inasistencia</option>
                                    <option value="J">Justificado</option>
                                </select>
                            </td>
                            <td>
                                <select name="aspectos[{{ $loop->index }}][aspecto_id]" class="form-select">
                                    <option value="">Ninguno</option>
                                    @foreach($aspectos as $aspecto)
                                    <option value="{{ $aspecto->id }}">
                                        {{ $aspecto->descripcion }} ({{ $aspecto->tipo }})
                                    </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="aspectos[{{ $loop->index }}][codigo_estudiante]" 
                                       value="{{ $estudiante->codigo }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar Asistencias
            </button>
        </div>
    </div>
</form>
@else
<div class="alert alert-danger">
    No tienes un grupo asignado para pasar asistencia.
</div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Leyenda de Aspectos</h5>
    </div>
    <div class="card-body">
        <ul class="list-unstyled">
            <li><span class="fw-bold">P:</span> Positivo</li>
            <li><span class="fw-bold">L:</span> Leve</li>
            <li><span class="fw-bold">G:</span> Grave</li>
            <li><span class="fw-bold">MG:</span> Muy Grave</li>
        </ul>
    </div>
</div>
@endsection