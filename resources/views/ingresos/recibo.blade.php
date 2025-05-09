<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Ingreso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header, .footer {
            text-align: center;
        }
        .header h2 {
            margin: 0;
        }
        .footer {
            margin-top: 20px;
        }
        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Recibo de Ingreso</h2>
        <p>Fecha: {{ $ingreso->fecha }}</p>
        <p>Tipo de Ingreso: {{ ucfirst($ingreso->tipo_ingreso) }}</p>
    </div>

    <div class="content">
        <table class="table">
            <tr>
                <th>Descripción</th>
                <td>{{ $ingreso->descripcion }}</td>
            </tr>
            <tr>
                <th>Monto</th>
                <td>{{ $ingreso->monto }} Bs</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Gracias por su contribución</p>
    </div>
</body>
</html>