@extends('layouts.app')

@section('title', 'Detalles del Grupo')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detalles del Grupo: {{ $grupo->nombre }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            @can('admin')
            <a href="{{ route('grupos.edit', $grupo->id) }}" class="btn btn-sm btn-outline-secondary me-2">
                <i class="fas fa-edit"></i> Editar Grupo
            </a>
            <form action="{{ route('grupos.destroy', $grupo->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este grupo? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash"></i> Eliminar Grupo
                </button>
            </form>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Información del Grupo</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $grupo->nombre }}</p>
                    <p>
                        <strong>Tutor:</strong>
                        @if($grupo->tutor)
                            <a href="{{ route('tutores.show', $grupo->tutor->codigo) }}">
                                {{ $grupo->tutor->nombres }} {{ $grupo->tutor->apellidos }}
                            </a>
                        @else
                            <span class="text-danger">No asignado</span>
                        @endif
                    </p>
                    <p><strong>Total Estudiantes:</strong> {{ $grupo->estudiantes->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Estudiantes en este Grupo</h5>
                </div>
                <div class="card-body">
                    @if($grupo->estudiantes->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grupo->estudiantes as $estudiante)
                                    <tr>
                                        <td>{{ $estudiante->codigo }}</td>
                                        <td>{{ $estudiante->nombres }}</td>
                                        <td>{{ $estudiante->apellidos }}</td>
                                        <td>
                                            <a href="{{ route('estudiantes.show', $estudiante->codigo) }}" class="btn btn-sm btn-info" title="Ver Perfil"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No hay estudiantes asignados a este grupo.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('grupos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al Listado de Grupos
        </a>
    </div>
</div>
@endsection