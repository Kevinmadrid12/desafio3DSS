@extends('layouts.app') 

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

    <div class="row">
        <div class="col-md-12">
            <h4>Mis Grupos Asignados</h4>

            @if($grupos->isEmpty())
                <div class="alert alert-info mt-3" role="alert">
                    <i class="fas fa-info-circle"></i> Actualmente no tienes grupos asignados.
                </div>
            @else
                @foreach($grupos as $grupo)
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-users"></i> Grupo: {{ $grupo->nombre }}
                                <small class="text-white-50">(Código: {{ $grupo->codigo }})</small>
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