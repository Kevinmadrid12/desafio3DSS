<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Estudiante - Trimestre {{ $trimestre }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif; /* DejaVu Sans soporta más caracteres */
            margin: 20px;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #2c3e50;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 10px;
            color: #7f8c8d;
        }
        .student-info {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .student-info p {
            margin: 5px 0;
        }
        .section-title {
            font-size: 16px;
            color: #2980b9;
            margin-top: 25px;
            margin-bottom: 10px;
            border-bottom: 1px solid #bdc3c7;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #ecf0f1;
            font-weight: bold;
        }
        .aspect-P { color: green; }
        .aspect-L { color: #f39c12; } /* Naranja/Amarillo para Leve */
        .aspect-G { color: #e74c3c; } /* Rojo para Grave */
        .aspect-MG { color: #c0392b; font-weight: bold; } /* Rojo oscuro para Muy Grave */

        .attendance-A { color: green; } /* Asistió */
        .attendance-I { color: red; }   /* Inasistencia */
        .attendance-J { color: orange; } /* Justificada */

        .semaforo {
            padding: 10px;
            text-align: center;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 15px;
        }
        .semaforo.azul { background-color: #3498db; color: white; }
        .semaforo.verde { background-color: #2ecc71; color: white; }
        .semaforo.amarillo { background-color: #f1c40f; color: #333; }
        .semaforo.rojo { background-color: #e74c3c; color: white; }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 9px;
            color: #777;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Desempeño Estudiantil</h1>
        <p>Academia Sabatina - Trimestre {{ $trimestre }} ({{ $fechaInicio }} - {{ $fechaFin }})</p>
    </div>

    <div class="student-info">
        <p><strong>Estudiante:</strong> {{ $estudiante->nombres }} {{ $estudiante->apellidos }}</p>
        <p><strong>Código:</strong> {{ $estudiante->codigo }}</p>
        <p><strong>Email:</strong> {{ $estudiante->email }}</p>
    </div>

    <h2 class="section-title">Aspectos Positivos</h2>
    @if($aspectosPositivos->count() > 0)
        <ul>
            @foreach($aspectosPositivos as $ap)
                <li>{{ $ap->aspecto->descripcion }} ({{ \Carbon\Carbon::parse($ap->fecha)->format('d/m/Y') }})</li>
            @endforeach
        </ul>
    @else
        <p>No se registraron aspectos positivos en este trimestre.</p>
    @endif

    <h2 class="section-title">Aspectos a Mejorar</h2>
    @if($aspectosMejorar->count() > 0)
        <ul>
            @foreach($aspectosMejorar as $am)
                <li class="aspect-{{ $am->aspecto->tipo }}">{{ $am->aspecto->descripcion }} (Tipo: {{ $am->aspecto->tipo }}, Fecha: {{ \Carbon\Carbon::parse($am->fecha)->format('d/m/Y') }})</li>
            @endforeach
        </ul>
    @else
        <p>No se registraron aspectos a mejorar en este trimestre.</p>
    @endif

    <h2 class="section-title">Resumen de Asistencias</h2>
    <p>Total Asistencias: <span class="attendance-A">{{ $asistencias->where('tipo', 'A')->count() }}</span></p>
    <p>Total Inasistencias: <span class="attendance-I">{{ $asistencias->where('tipo', 'I')->count() }}</span></p>
    <p>Total Justificadas: <span class="attendance-J">{{ $asistencias->where('tipo', 'J')->count() }}</span></p>

    <h2 class="section-title">Semáforo de Disciplina del Trimestre</h2>
    <div class="semaforo {{ $semaforo }}">
        Nivel: {{ ucfirst($semaforo) }}
    </div>

    {{-- Detalle de Asistencias (Opcional, puede hacer el PDF muy largo) --}}
    {{-- 
    <h2 class="section-title">Detalle de Asistencias del Trimestre</h2>
    @if($asistencias->count() > 0)
        <table>
            <thead>
                <tr><th>Fecha</th><th>Estado</th><th>Tutor</th></tr>
            </thead>
            <tbody>
                @foreach($asistencias as $asistencia)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                    <td class="attendance-{{ $asistencia->tipo }}">{{ $asistencia->tipo }}</td>
                    <td>{{ $asistencia->tutor->nombres ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay registros de asistencia para este trimestre.</p>
    @endif
    --}}

    <div class="footer">
        Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>