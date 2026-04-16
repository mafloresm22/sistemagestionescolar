<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Asistencia - {{ $asistencia->fechaAsistencias }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #004a99;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #004a99;
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0;
            color: #666;
        }
        .info-section {
            width: 100%;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 4px;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            color: #004a99;
            width: 120px;
        }
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .attendance-table th {
            background-color: #004a99;
            color: white;
            padding: 8px;
            text-align: left;
            text-transform: uppercase;
            font-size: 10px;
        }
        .attendance-table td {
            padding: 7px;
            border-bottom: 1px solid #eee;
        }
        .attendance-table tr:nth-child(even) {
            background-color: #fcfcfc;
        }
        .status {
            font-weight: bold;
            text-align: center;
            padding: 3px 6px;
            border-radius: 3px;
        }
        .status-presente { color: #28a745; }
        .status-falta { color: #dc3545; }
        .status-tarde { color: #ffc107; }
        .status-justificado { color: #6c757d; }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #999;
        }
        .signature-area {
            margin-top: 50px;
            width: 100%;
        }
        .signature-box {
            width: 45%;
            text-align: center;
            display: inline-block;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 80%;
            margin: 0 auto 5px;
        }
        .summary {
            margin-top: 20px;
            float: right;
            width: 200px;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #fff;
        }
        .summary table {
            width: 100%;
        }
        .summary td {
            padding: 2px 0;
        }
        .summary .count {
            text-align: right;
            font-weight: bold;
        }
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Control de Asistencia Escolar</h1>
        <p>{{ $asistencia->asignarCursoDocente->gestion->nombreGestion ?? 'Gestión Escolar' }}</p>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="label">Fecha:</td>
                <td>{{ \Carbon\Carbon::parse($asistencia->fechaAsistencias)->translatedFormat('d F Y') }}</td>
                <td class="label">Docente:</td>
                <td>{{ $asistencia->asignarCursoDocente->docente->nombrePersonal }} {{ $asistencia->asignarCursoDocente->docente->apellidoPersonal }}</td>
            </tr>
            <tr>
                <td class="label">Curso:</td>
                <td>{{ $asistencia->asignarCursoDocente->curso->nombreCurso }}</td>
                <td class="label">Grado / Sección:</td>
                <td>{{ $asistencia->asignarCursoDocente->grado->nombreGrado }} "{{ $asistencia->asignarCursoDocente->seccion->nombreSeccion }}"</td>
            </tr>
            <tr>
                <td class="label">Nivel:</td>
                <td>{{ $asistencia->asignarCursoDocente->nivel->nombreNivel }}</td>
                <td class="label">Turno:</td>
                <td>{{ $asistencia->asignarCursoDocente->turno->nombreTurno }}</td>
            </tr>
            <tr>
                <td class="label">Aula:</td>
                <td>{{ $aulaAsignada->aula->nombreAula ?? 'N/A' }}</td>
                <td class="label">Observaciones:</td>
                <td>{{ $asistencia->observacionAsistencias }}</td>
            </tr>
        </table>
    </div>

    <table class="attendance-table">
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th style="width: 80px;">DNI</th>
                <th>Apellidos y Nombres</th>
                <th style="width: 100px; text-align: center;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asistencia->asistenciasDetalles as $index => $detalle)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detalle->estudiante->dniEstudiante }}</td>
                <td>{{ $detalle->estudiante->apellidoEstudiante }}, {{ $detalle->estudiante->nombreEstudiante }}</td>
                <td class="status status-{{ strtolower($detalle->estadoAsistenciasDetalle) }}">
                    {{ $detalle->estadoAsistenciasDetalle }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <table>
            <tr>
                <td>Presentes:</td>
                <td class="count">{{ $asistencia->asistenciasDetalles->where('estadoAsistenciasDetalle', 'Presente')->count() }}</td>
            </tr>
            <tr>
                <td>Faltas:</td>
                <td class="count">{{ $asistencia->asistenciasDetalles->where('estadoAsistenciasDetalle', 'Falta')->count() }}</td>
            </tr>
            <tr>
                <td>Tardanzas:</td>
                <td class="count">{{ $asistencia->asistenciasDetalles->where('estadoAsistenciasDetalle', 'Tarde')->count() }}</td>
            </tr>
            <tr>
                <td>Justificados:</td>
                <td class="count">{{ $asistencia->asistenciasDetalles->where('estadoAsistenciasDetalle', 'Justificado')->count() }}</td>
            </tr>
            <tr style="border-top: 1px solid #ddd;">
                <td style="font-weight: bold; padding-top: 5px;">Total Alumnos:</td>
                <td class="count" style="padding-top: 5px;">{{ $asistencia->asistenciasDetalles->count() }}</td>
            </tr>
        </table>
    </div>

    <div class="clear"></div>

    <div class="signature-area">
        <div class="signature-box" style="float: left;">
            <div class="signature-line"></div>
            <p>Firma del Docente</p>
            <p>{{ $asistencia->asignarCursoDocente->docente->nombrePersonal }} {{ $asistencia->asignarCursoDocente->docente->apellidoPersonal }}</p>
        </div>
        <div class="signature-box" style="float: right;">
            <div class="signature-line"></div>
            <p>V°B° Dirección / Coordinación</p>
        </div>
    </div>

    <div class="clear"></div>

    <div class="footer">
        <p>Documento generado por el Sistema de Gestión Escolar el {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
