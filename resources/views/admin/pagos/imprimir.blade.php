<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago - {{ $pago->idPago }}</title>
    <style>
        @page {
            size: a5;
            margin: 0.5cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 10px;
        }
        .receipt-container {
            border: 2px solid #0d49a2;
            padding: 15px;
            border-radius: 10px;
            position: relative;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0d49a2;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .logo {
            max-height: 50px;
            margin-bottom: 5px;
        }
        .school-name {
            font-size: 14px;
            font-weight: bold;
            color: #0d49a2;
            text-transform: uppercase;
            margin: 0;
        }
        .receipt-title {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
            color: #333;
        }
        .receipt-number {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #e74c3c;
            font-size: 14px;
            font-weight: bold;
            border: 2px solid #e74c3c;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 5px;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            width: 30%;
            color: #555;
        }
        .value {
            width: 70%;
            border-bottom: 1px dotted #ccc;
        }
        .amount-section {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 10px;
            margin: 15px 0;
            text-align: right;
            border-radius: 5px;
        }
        .amount-text {
            font-size: 18px;
            font-weight: bold;
            color: #27ae60;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
        }
        .signature-box {
            margin-top: 40px;
            display: inline-block;
            width: 200px;
            border-top: 1px solid #333;
            padding-top: 5px;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            color: rgba(0, 0, 0, 0.05);
            z-index: -1;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="watermark">PAGADO</div>
        
        <div class="header">
            @if($configuracion && $configuracion->logoConfiguraciones)
                <img src="{{ public_path($configuracion->logoConfiguraciones) }}" class="logo">
            @endif
            <p class="school-name">{{ $configuracion->nombreConfiguraciones ?? 'SISTEMA DE GESTIÓN ESCOLAR' }}</p>
            <p style="margin: 2px 0;">{{ $configuracion->direccionConfiguraciones ?? '' }}</p>
            <div class="receipt-title">RECIBO DE PAGO</div>
        </div>

        <div class="receipt-number">
            N° {{ str_pad($pago->idPago, 6, '0', STR_PAD_LEFT) }}
        </div>

        <table class="info-table">
            <tr>
                <td class="label">ESTUDIANTE:</td>
                <td class="value">{{ $pago->matriculacion->estudiante->nombreEstudiante }} {{ $pago->matriculacion->estudiante->apellidoEstudiante }}</td>
            </tr>
            <tr>
                <td class="label">DNI:</td>
                <td class="value">{{ $pago->matriculacion->estudiante->dniEstudiante }}</td>
            </tr>
            <tr>
                <td class="label">GESTIÓN / GRADO:</td>
                <td class="value">{{ $pago->matriculacion->gestion->nombreGestion }} - {{ $pago->matriculacion->grado->nombreGrado }} ({{ $pago->matriculacion->nivel->nombreNivel }})</td>
            </tr>
            <tr>
                <td class="label">FECHA DE PAGO:</td>
                <td class="value">{{ \Carbon\Carbon::parse($pago->fechaPago)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">MÉTODO PAGO:</td>
                <td class="value">{{ $pago->metodoPago }}</td>
            </tr>
            @if($pago->observacionesPago)
            <tr>
                <td class="label">OBSERVACIONES:</td>
                <td class="value">{{ $pago->observacionesPago }}</td>
            </tr>
            @endif
        </table>

        <div class="amount-section">
            <span style="font-size: 12px; margin-right: 10px;">TOTAL PAGADO:</span>
            <span class="amount-text">S/. {{ number_format($pago->montoPago, 2) }}</span>
        </div>

        <div class="footer">
            <p style="font-style: italic; color: #7f8c8d; margin-bottom: 20px;">
                "Educación con Valores y Excelencia Académica"
            </p>
            
            <div style="width: 100%; margin-top: 30px;">
                <div style="float: left; width: 45%; text-align: center;">
                    <div class="signature-box">Firma del Cajero / Admin</div>
                </div>
                <div style="float: right; width: 45%; text-align: center;">
                    <div class="signature-box">Firma del Padre / Apoderado</div>
                </div>
                <div style="clear: both;"></div>
            </div>

            <p style="font-size: 8px; color: #aaa; margin-top: 30px;">
                Generado el {{ date('d/m/Y H:i:s') }} | Sistema de Gestión Escolar
            </p>
        </div>
    </div>
</body>
</html>
