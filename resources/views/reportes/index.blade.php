@extends('layouts.app')

@section('title', 'Generar Reportes')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Generar Reportes Trimestrales</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('reportes.generar') }}">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="codigo_estudiante" class="form-label">Estudiante</label>
                    <select class="form-select" id="codigo_estudiante" name="codigo_estudiante" required>
                        <option value="">Seleccione un estudiante...</option>
                        @foreach($estudiantes as $estudiante)
                        <option value="{{ $estudiante->codigo }}">
                            {{ $estudiante->nombres }} {{ $estudiante->apellidos }} ({{ $estudiante->codigo }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="trimestre" class="form-label">Trimestre</label>
                    <select class="form-select" id="trimestre" name="trimestre" required>
                        <option value="1">Primer Trimestre (Febrero - Abril)</option>
                        <option value="2">Segundo Trimestre (Mayo - Julio)</option>
                        <option value="3">Tercer Trimestre (Agosto - Octubre)</option>
                    </select>
                </div>
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-file-pdf"></i> Generar Reporte
                </button>
            </div>
        </form>
    </div>
</div>
@endsection