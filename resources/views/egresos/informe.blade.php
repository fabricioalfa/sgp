<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Egresos</title>
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
        <h2>Informe de Egresos</h2>
        <p>Fecha de inicio: {{ $fechaInicio->format('d-m-Y') }}</p>
        <p>Fecha de fin: {{ $fechaFin->format('d-m-Y') }}</p>
    </div>

    <div class="content">
        @if($egresos->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Categoría</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($egresos as $egreso)
                        <tr>
                            <td>{{ $egreso->fecha }}</td>
                            <td>Bs {{ number_format($egreso->monto, 2) }}</td>
                            <td>{{ $egreso->categoria }}</td>
                            <td>{{ $egreso->descripcion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No se encontraron egresos para este rango de fechas.</p>
        @endif
    </div>

    <div class="footer">
        <p>Gracias por su atención</p>
    </div>
</body>
</html>