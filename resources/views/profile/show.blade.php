@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="container-fluid px-4"> 
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Mi Perfil</h1>
        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-edit"></i> Editar Perfil
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    {{-- Placeholder para foto de perfil --}}
                    <div class="bg-light d-flex align-items-center justify-content-center rounded-circle mx-auto mb-3"
                         style="width: 150px; height: 150px;">
                        <i class="fas fa-user fa-5x text-secondary"></i>
                    </div>
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ ucfirst($user->role) }}</p>
                </div>
                <div class="col-md-8">
                    <h5 class="card-title">Información de la Cuenta</h5>
                    <hr>
                    <p><strong>Nombre:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Rol:</strong> {{ ucfirst($user->role) }}</p>
                    <p><strong>Miembro desde:</strong> {{ $user->created_at->format('d/m/Y') }}</p>

                    @if($user->role === 'tutor' && $user->tutor)
                        <h5 class="card-title mt-4">Información de Tutor</h5>
                        <hr>
                        <p><strong>Código de Tutor:</strong> {{ $user->tutor->codigo }}</p>
                        <p><strong>Nombre Completo (Tutor):</strong> {{ $user->tutor->nombres }} {{ $user->tutor->apellidos }}</p>
                        <p><strong>Email (Tutor):</strong> {{ $user->tutor->email }}</p>
                        <p><strong>Teléfono (Tutor):</strong> {{ $user->tutor->telefono }}</p>
                        <p><a href="{{ route('tutores.dashboard') }}" class="btn btn-info btn-sm">Ir a mi Dashboard de Tutor</a></p>
                    @endif

                    <div class="mt-4">
                         <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        {{-- <a href="#" class="btn btn-primary">Cambiar Contraseña</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection