<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reporte del Dashboard</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 25px; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 25px; }
        .header h1 { margin: 0; font-size: 20px; color: #1a237e; }
        .header p { margin: 5px 0 0; font-size: 10px; color: #555; }
        .section-title { font-size: 16px; margin-top: 20px; margin-bottom: 10px; border-bottom: 1px solid #7986cb; padding-bottom: 5px; color: #303f9f; }
        .summary-card { border: 1px solid #e8eaf6; background-color: #f8f9fa; padding: 15px; margin-bottom: 15px; border-radius: 4px; }
        .summary-card p { margin: 0 0 8px 0; }
        .summary-card strong { color: #3f51b5; }
        .summary-card .value { font-size: 18px; font-weight: bold; color: #1a237e; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #c5cae9; padding: 10px; text-align: left; }
        th { background-color: #e8eaf6; font-weight: bold; color: #303f9f; }
        .footer { text-align: center; margin-top: 30px; font-size: 9px; color: #777; }
        .progress-container { margin-top: 5px; background-color: #e0e0e0; border-radius: 4px; height: 20px; width: 100%;}
        .progress-bar { background-color: #4CAF50; height: 20px; line-height:20px; color:white; text-align:center; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte del Panel de Administración</h1>
        <p>Generado el: {{ $fechaExportacion }}</p>
    </div>

    <div class="summary-card">
        <p><strong>Total de Estudiantes:</strong> <span class="value">{{ $totalEstudiantes }}</span></p>
        <p><strong>Total de Tutores Activos:</strong> <span class="value">{{ $totalTutores }}</span></p>
        <p><strong>Total de Grupos:</strong> <span class="value">{{ $totalGrupos }}</span></p>
    </div>

    <div class="summary-card">
        <p><strong>Porcentaje de Asistencia Mensual:</strong> <span class="value">{{ $porcentajeAsistencia }}%</span></p>
        <div class="progress-container">
            <div class="progress-bar" style="width: {{ $porcentajeAsistencia }}%;">{{ $porcentajeAsistencia }}%</div>
        </div>
    </div>

    @if($gruposProblema && $gruposProblema->count() > 0)
        <h2 class="section-title">Grupos con Mayor Número de Inasistencias/Justificaciones (Top 5)</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Grupo</th>
                    <th>Nº Inasistencias/Justificadas (Mes Actual)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gruposProblema as $grupo)
                <tr>
                    <td>{{ $grupo->nombre }}</td>
                    <td>{{ $grupo->inasistencias_justificadas_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay datos de grupos con alta inasistencia para mostrar este mes.</p>
    @endif

    <div class="footer">
        Reporte generado automáticamente por el Sistema de Gestión Académica.
    </div>
</body>
</html>