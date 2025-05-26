@extends('layouts.app') 

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Toma de Asistencia y Aspectos</h1>
    <p class="mb-2"><strong>Tutor:</strong> {{ $tutor->nombres }} {{ $tutor->apellidos }}</p>
    <p class="mb-4"><strong>Fecha:</strong> {{ $fechaHoy->format('d/m/Y') }} (Sábado)</p>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Por favor corrige los siguientes errores:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if($estudiantes->isEmpty())
        <p class="text-gray-700">No tiene estudiantes asignados a sus grupos.</p>
    @else
        <form action="{{ route('tutor.asistencia.store') }}" method="POST">
            @csrf
            <input type="hidden" name="fecha_asistencia" value="{{ $fechaHoy->toDateString() }}">

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Estudiante</th>
                            <th class="py-2 px-4 border-b text-center">Asistió</th>
                            <th class="py-2 px-4 border-b text-left">Aspectos Positivos</th>
                            <th class="py-2 px-4 border-b text-left">Aspectos a Mejorar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estudiantes as $estudiante)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b">{{ $estudiante->apellidos }}, {{ $estudiante->nombres }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <input type="checkbox" name="estudiantes[{{ $estudiante->codigo }}][asistio]" value="1" class="form-checkbox h-5 w-5 text-blue-600">
                            </td>
                            <td class="py-2 px-4 border-b">
                                @if($aspectosPositivos->isNotEmpty())
                                    <select multiple name="estudiantes[{{ $estudiante->codigo }}][aspectos_positivos][]" class="form-multiselect block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-24">
                                        {{-- <option value="">Seleccionar...</option> --}}
                                        @foreach($aspectosPositivos as $aspecto)
                                            <option value="{{ $aspecto->id }}">{{ $aspecto->descripcion }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="text-gray-500 text-sm">No hay aspectos positivos definidos.</span>
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b">
                                @if($aspectosMejorar->isNotEmpty())
                                    <select multiple name="estudiantes[{{ $estudiante->codigo }}][aspectos_mejorar][]" class="form-multiselect block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-24">
                                        {{-- <option value="">Seleccionar...</option> --}}
                                        @foreach($aspectosMejorar as $aspecto)
                                            <option value="{{ $aspecto->id }}">{{ $aspecto->descripcion }}</option>
                                        @endforeach
                                    </select>
                                @else
                                     <span class="text-gray-500 text-sm">No hay aspectos a mejorar definidos.</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Guardar Asistencia y Aspectos
                </button>
            </div>
        </form>
    @endif
</div>
@endsection
