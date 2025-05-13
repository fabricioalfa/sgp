<!-- resources/views/misas/recibo-pdf.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Misa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #C1440E;
            font-size: 24px;
        }

        .details {
            margin-bottom: 20px;
        }

        .details th,
        .details td {
            padding: 8px;
            text-align: left;
        }

        .details th {
            background-color: #F4A261;
            color: white;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Recibo de Misa</h1>
        <p>Fecha: {{ \Carbon\Carbon::parse($misa->fecha)->format('d/m/Y') }}</p>
        <p>Hora: {{ $misa->hora }}</p>
    </div>

    <table class="details" width="100%">
        <tr>
            <th>Tipo de Misa</th>
            <td>{{ $misa->tipo_misa }}</td>
        </tr>
        <tr>
            <th>Intención</th>
            <td>{{ $misa->intencion ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Sacerdote</th>
            <td>{{ $misa->sacerdote->nombres }}</td>
        </tr>
        <tr>
            <th>Estado</th>
            <td>{{ $misa->estado }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Gracias por su apoyo.</p>
    </div>

</body>
</html>