@extends('layouts.app')

@section('title', 'Editar Mi Perfil')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Editar Mi Perfil</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <hr>
                <p class="text-muted">Dejar en blanco si no desea cambiar la contraseña.</p>

                <div class="mb-3">
                    <label for="password" class="form-label">Nueva Contraseña</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Confirmar Nueva Contraseña</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                </div>

                {{-- Si necesitas editar campos específicos del rol (ej. datos del tutor), los añadirías aquí --}}
                {{-- Por ejemplo, si el usuario es tutor y quieres permitir editar su teléfono de la tabla tutores --}}
                {{-- @if($user->role === 'tutor' && $user->tutor)
                <div class="mb-3">
                    <label for="tutor_telefono" class="form-label">Teléfono (Tutor)</label>
                    <input id="tutor_telefono" type="text" class="form-control @error('tutor_telefono') is-invalid @enderror" name="tutor_telefono" value="{{ old('tutor_telefono', $user->tutor->telefono) }}">
                    @error('tutor_telefono')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @endif --}}

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection