<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Matrícula - {{ $matriculacion->estudiante->nombreEstudiante }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #007bff;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .section-title {
            background-color: #f8f9fa;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 14px;
            border-left: 4px solid #007bff;
            margin-bottom: 10px;
            color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table td {
            padding: 8px;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            color: #555;
            width: 150px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .signature-box {
            margin-top: 80px;
            width: 100%;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            margin: 0 auto;
            text-align: center;
            padding-top: 5px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            font-weight: bold;
            font-size: 10px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SISTEMA DE GESTIÓN ESCOLAR</h1>
        <p>FICHA OFICIAL DE MATRÍCULA - GESTIÓN {{ $matriculacion->gestion->nombreGestion }}</p>
    </div>

    <div class="info-section">
        <div class="section-title">DATOS DEL ESTUDIANTE</div>
        <table>
            <tr>
                <td class="label">Nombres y Apellidos:</td>
                <td>{{ $matriculacion->estudiante->nombreEstudiante }} {{ $matriculacion->estudiante->apellidoEstudiante }}</td>
                <td class="label">DNI / Código:</td>
                <td>{{ $matriculacion->estudiante->dniEstudiante }}</td>
            </tr>
            <tr>
                <td class="label">Fecha de Nacimiento:</td>
                <td>{{ \Carbon\Carbon::parse($matriculacion->estudiante->fechaNacimientoEstudiante)->format('d/m/Y') }}</td>
                <td class="label">Género:</td>
                <td>{{ $matriculacion->estudiante->generoEstudiante }}</td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <div class="section-title">INFORMACIÓN ACADÉMICA</div>
        <table>
            <tr>
                <td class="label">Nivel Educativo:</td>
                <td>{{ $matriculacion->nivel->nombreNivel }}</td>
                <td class="label">Grado:</td>
                <td>{{ $matriculacion->grado->nombreGrado }}</td>
            </tr>
            <tr>
                <td class="label">Sección:</td>
                <td>{{ $matriculacion->seccion->nombreSeccion ?? 'N/A' }}</td>
                <td class="label">Turno:</td>
                <td>{{ $matriculacion->turno->nombreTurno }}</td>
            </tr>
            <tr>
                <td class="label">Fecha Matrícula:</td>
                <td>{{ \Carbon\Carbon::parse($matriculacion->fechaMatriculacion)->format('d/m/Y') }}</td>
                <td class="label">Estado:</td>
                <td><span class="status-badge">{{ strtoupper($matriculacion->estadoMatriculacion) }}</span></td>
            </tr>
        </table>
    </div>

    @if($matriculacion->estudiante->padreFamilia)
    <div class="info-section">
        <div class="section-title">DATOS DEL PADRE / APODERADO</div>
        <table>
            <tr>
                <td class="label">Nombre Apoderado:</td>
                <td>{{ $matriculacion->estudiante->padreFamilia->nombrePadre }} {{ $matriculacion->estudiante->padreFamilia->apellidoPadre }}</td>
                <td class="label">DNI Apoderado:</td>
                <td>{{ $matriculacion->estudiante->padreFamilia->dniPadre }}</td>
            </tr>
            <tr>
                <td class="label">Teléfono:</td>
                <td>{{ $matriculacion->estudiante->padreFamilia->celularPadre }}</td>
                <td class="label">Ocupación:</td>
                <td>{{ $matriculacion->estudiante->padreFamilia->ocupacionPadre }}</td>
            </tr>
        </table>
    </div>
    @endif

    <div class="info-section">
        <div class="section-title">OBSERVACIONES</div>
        <p style="margin-left: 12px;">{{ $matriculacion->observacionesMatriculacion ?? 'Sin observaciones adicionales.' }}</p>
    </div>

    <div class="signature-box">
        <table style="margin-top: 40px;">
            <tr>
                <td style="text-align: center;">
                    <div class="signature-line">
                        Firma del Padre/Apoderado
                    </div>
                </td>
                <td style="text-align: center;">
                    <div class="signature-line">
                        Firma de Secretaría Académica
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Este documento es una constancia oficial de matrícula generada por el Sistema de Gestión Escolar.<br>
        Fecha de impresión: {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>
