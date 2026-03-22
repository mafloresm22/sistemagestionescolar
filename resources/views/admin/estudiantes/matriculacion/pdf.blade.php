<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Matrícula - {{ $matriculacion->estudiante->nombreEstudiante }}</title>
    <style>
        @page {
            size: landscape;
            margin: 1cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 14px;
            color: #2c3e50;
            margin: 0;
            padding: 0;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #2980b9;
        }
        .main-table th, .main-table td {
            border: 1px solid #bdc3c7;
            padding: 4px 6px;
            line-height: normal;
        }
        .header-cell {
            background-color: #f4f7f6;
            text-align: center;
            border-bottom: 2px solid #2980b9 !important;
        }
        .header-cell h1 {
            margin: 5px 0;
            color: #2980b9;
            font-size: 22px;
            text-transform: uppercase;
        }
        .section-title {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            text-align: left;
            padding: 5px 15px;
        }
        .label {
            background-color: #ecf0f1;
            font-weight: bold;
            width: 15%;
        }
        .value {
            width: 35%;
        }
        .signature-row td {
            height: 140px;
            vertical-align: bottom;
            text-align: center;
            border: none;
        }
        .signature-line {
            border-top: 1px solid #2c3e50;
            width: 280px;
            margin: 0 auto;
            padding-top: 5px;
            font-weight: bold;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            background-color: #27ae60;
            color: white;
            border-radius: 4px;
            font-weight: bold;
        }
        .footer-info {
            font-size: 10px;
            color: #7f8c8d;
            text-align: right;
            border: none !important;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <table class="main-table">
        <!-- ENCABEZADO -->
        <tr>
            <td class="header-cell" style="width: 15%; border-right: none;">
                @if($configuracion && $configuracion->logoConfiguraciones)
                    <img src="{{ public_path($configuracion->logoConfiguraciones) }}" style="max-height: 60px;">
                @else
                    <div style="font-size: 8px;">SIN LOGO</div>
                @endif
            </td>
            <td colspan="3" class="header-cell" style="border-left: none; text-align: left; padding-left: 20px;">
                <h1 style="margin-bottom: 2px;">{{ $configuracion->nombreConfiguraciones ?? 'SISTEMA DE GESTIÓN ESCOLAR' }}</h1>
                <h2 style="margin: 0; color: #34495e; font-size: 16px; text-transform: uppercase;">Constancia de Matrícula</h2>
                <p style="margin-top: 5px;">{{ $configuracion->descripcionConfiguraciones ?? 'INSTITUCIÓN EDUCATIVA PUBLICA' }} | GESTIÓN ACADÉMICA {{ $matriculacion->gestion->nombreGestion }} | CÓDIGO: {{ $matriculacion->estudiante->dniEstudiante }}</p>
            </td>
        </tr>

        <!-- SECCIÓN ESTUDIANTE -->
        <tr>
            <td colspan="4" class="section-title">I. DATOS PERSONALES DEL ESTUDIANTE</td>
        </tr>
        <tr>
            <td class="label">Nombres:</td>
            <td class="value">{{ $matriculacion->estudiante->nombreEstudiante }}</td>
            <td class="label">Apellidos:</td>
            <td class="value">{{ $matriculacion->estudiante->apellidoEstudiante }}</td>
        </tr>
        <tr>
            <td class="label">DNI / Código:</td>
            <td class="value">{{ $matriculacion->estudiante->dniEstudiante }}</td>
            <td class="label">Género / Edad:</td>
            <td class="value">{{ $matriculacion->estudiante->generoEstudiante == 'M' ? 'Masc.' : 'Fem.' }} | {{ \Carbon\Carbon::parse($matriculacion->estudiante->fechaNacimientoEstudiante)->age }} años</td>
        </tr>
        <tr>
            <td class="label">F. Nacimiento:</td>
            <td class="value">{{ \Carbon\Carbon::parse($matriculacion->estudiante->fechaNacimientoEstudiante)->format('d/m/Y') }}</td>
            <td class="label">Dirección:</td>
            <td class="value">{{ $matriculacion->estudiante->direccionEstudiante }}</td>
        </tr>

        <!-- SECCIÓN ACADÉMICA -->
        <tr>
            <td colspan="4" class="section-title">II. INFORMACIÓN ACADÉMICA Y DE MATRÍCULA</td>
        </tr>
        <tr>
            <td class="label">Nivel / Grado:</td>
            <td class="value">{{ $matriculacion->nivel->nombreNivel }} - {{ $matriculacion->grado->nombreGrado }}</td>
            <td class="label">Sección / Turno:</td>
            <td class="value">{{ $matriculacion->seccion->nombreSeccion ?? 'Única' }} | {{ $matriculacion->turno->nombreTurno }}</td>
        </tr>
        <tr>
            <td class="label">Fecha Registro:</td>
            <td class="value">{{ \Carbon\Carbon::parse($matriculacion->fechaMatriculacion)->format('d/m/Y') }}</td>
            <td class="label">Estado Matrícula:</td>
            <td class="value">
                <span class="status-badge">{{ strtoupper($matriculacion->estadoMatriculacion) }}</span>
            </td>
        </tr>

        <!-- SECCIÓN APODERADO -->
        <tr>
            <td colspan="4" class="section-title">III. DATOS DEL PADRE DE FAMILIA / APODERADO</td>
        </tr>
        @if($matriculacion->estudiante->padreFamilia)
        <tr>
            <td class="label">Apoderado:</td>
            <td class="value">{{ $matriculacion->estudiante->padreFamilia->nombrePadreFamilia }} {{ $matriculacion->estudiante->padreFamilia->apellidoPadreFamilia }}</td>
            <td class="label">DNI Apoderado:</td>
            <td class="value">{{ $matriculacion->estudiante->padreFamilia->dniPadreFamilia }}</td>
        </tr>
        <tr>
            <td class="label">Contacto:</td>
            <td colspan="3" class="value">{{ $matriculacion->estudiante->padreFamilia->celularPadreFamilia }} | {{ $matriculacion->estudiante->padreFamilia->correoPadreFamilia ?? 'Sin correo' }}</td>
        </tr>
        @else
        <tr>
            <td colspan="4" style="text-align: center; color: #e74c3c;"><em>No se registran datos del apoderado vinculado a este estudiante.</em></td>
        </tr>
        @endif

        @if($matriculacion->observacionesMatriculacion)
        <tr>
            <td class="label">Observaciones:</td>
            <td colspan="3">{{ $matriculacion->observacionesMatriculacion }}</td>
        </tr>
        @endif

        <!-- ESPACIO PARA FIRMAS -->
        <tr class="signature-row">
            <td colspan="2">
                <div class="signature-line">FIRMA DEL PADRE / APODERADO</div>
            </td>
            <td colspan="2">
                <div class="signature-line">DIRECCIÓN / SECRETARÍA ACADÉMICA</div>
            </td>
        </tr>

        <tr>
            <td colspan="4" class="footer-info" style="text-align: center;">
                Documento generado automáticamente por el Sistema de Gestión Escolar | Fecha: {{ date('d/m/Y H:i:s') }}
            </td>
        </tr>
    </table>
</body>
</html>
