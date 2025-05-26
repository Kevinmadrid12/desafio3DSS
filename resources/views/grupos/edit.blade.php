@extends('layouts.app')

@section('title', 'Editar Grupo')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Editar Grupo: {{ $grupo->nombre }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('grupos.update', $grupo->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Grupo</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $grupo->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="codigo_tutor" class="form-label">Tutor Asignado</label>
                    <select class="form-select @error('codigo_tutor') is-invalid @enderror" id="codigo_tutor" name="codigo_tutor" required>
                        <option value="">Seleccione un tutor...</option>
                        @foreach($tutores as $tutor)
                            <option value="{{ $tutor->codigo }}" 
                                {{ old('codigo_tutor', $grupo->codigo_tutor) == $tutor->codigo ? 'selected' : '' }}>
                                {{ $tutor->nombres }} {{ $tutor->apellidos }}
                            </option>
                        @endforeach
                    </select>
                    @error('codigo_tutor')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="estudiantes" class="form-label">Estudiantes</label>
                    <p class="text-muted small">Seleccione los estudiantes que pertenecerán a este grupo. Puede seleccionar múltiples estudiantes manteniendo presionada la tecla Ctrl (o Cmd en Mac).</p>
                    <select class="form-select @error('estudiantes') is-invalid @enderror" id="estudiantes" name="estudiantes[]" multiple size="10">
                        @foreach($estudiantes as $estudiante)
                            <option value="{{ $estudiante->codigo }}" 
                                {{ in_array($estudiante->codigo, old('estudiantes', $estudiantesSeleccionados)) ? 'selected' : '' }}>
                                {{ $estudiante->nombres }} {{ $estudiante->apellidos }} ({{ $estudiante->codigo }})
                            </option>
                        @endforeach
                    </select>
                    @error('estudiantes')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                     @error('estudiantes.*') {{-- Para errores de validación en elementos del array --}}
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('grupos.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar Grupo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection