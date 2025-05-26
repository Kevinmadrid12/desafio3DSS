@extends('layouts.app')

@section('title', 'Gestión de Grupos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Gestión de Grupos</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('grupos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Grupo
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tutor</th>
                <th>Estudiantes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grupos as $grupo)
            <tr>
                <td>{{ $grupo->id }}</td>
                <td>{{ $grupo->nombre }}</td>
                <td>
                    @if($grupo->tutor)
                    {{ $grupo->tutor->nombres }} {{ $grupo->tutor->apellidos }}
                    @else
                    <span class="text-danger">Sin tutor asignado</span>
                    @endif
                </td>
                <td>{{ $grupo->estudiantes->count() }}</td>
                <td>
                    <a href="{{ route('grupos.edit', $grupo->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('grupos.destroy', $grupo->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                onclick="return confirm('¿Estás seguro de eliminar este grupo?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection