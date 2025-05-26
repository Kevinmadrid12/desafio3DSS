@extends('layouts.app')

@section('title', 'Listado de Estudiantes')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Listado de Estudiantes</h1>
        {{-- Aquí podrías añadir un botón para crear nuevo estudiante si es necesario --}}
    </div>

    <div class="card">
        <div class="card-body">
            @if($estudiantes->isEmpty())
                <p class="text-center">No hay estudiantes registrados.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Email</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estudiantes as $estudiante)
                            <tr>
                                <td>{{ $estudiante->codigo }}</td>
                                <td>{{ $estudiante->nombres }}</td>
                                <td>{{ $estudiante->apellidos }}</td>
                                <td>{{ $estudiante->email }}</td>
                                <td><span class="badge bg-{{ $estudiante->estado === 'activo' ? 'success' : 'secondary' }}">{{ ucfirst($estudiante->estado) }}</span></td>
                                <td>
                                    <a href="{{ route('estudiantes.show', $estudiante->codigo) }}" class="btn btn-sm btn-info" title="Ver Perfil"><i class="fas fa-eye"></i></a>
                                    {{-- Aquí podrías añadir botones para editar/eliminar si es necesario y si el admin tiene permisos --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $estudiantes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection