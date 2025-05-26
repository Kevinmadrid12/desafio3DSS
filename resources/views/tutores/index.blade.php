@extends('layouts.app')

@section('title', 'Listado de Tutores')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Listado de Tutores</h1>
        {{-- Aquí podrías añadir un botón para crear nuevo tutor si es necesario --}}
    </div>

    <div class="card">
        <div class="card-body">
            @if($tutores->isEmpty())
                <p class="text-center">No hay tutores registrados.</p>
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
                            @foreach($tutores as $tutor)
                            <tr>
                                <td>{{ $tutor->codigo }}</td>
                                <td>{{ $tutor->nombres }}</td>
                                <td>{{ $tutor->apellidos }}</td>
                                <td>{{ $tutor->email }}</td>
                                <td><span class="badge bg-{{ $tutor->estado === 'contratado' ? 'success' : 'secondary' }}">{{ ucfirst($tutor->estado) }}</span></td>
                                <td>
                                    <a href="{{ route('tutores.show', $tutor->codigo) }}" class="btn btn-sm btn-info" title="Ver Perfil"><i class="fas fa-eye"></i></a>
                                    {{-- Aquí podrías añadir botones para editar/eliminar si es necesario y si el admin tiene permisos --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $tutores->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection