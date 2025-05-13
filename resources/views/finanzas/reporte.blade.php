<!-- resources/views/finanzas/reporte.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Finanzas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        h1 {
            color: #C1440E;
        }
        .container {
            margin-top: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #F4A261;
            color: white;
        }
        .table td {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <h1>Reporte de Finanzas</h1>
    <div class="container">
        <h2>Totales:</h2>
        <p><strong>Total Ingresos:</strong> {{ number_format($totalIngresos, 2) }} Bs</p>
        <p><strong>Total Egresos:</strong> {{ number_format($totalEgresos, 2) }} Bs</p>
        <p><strong>Saldo:</strong> {{ number_format($saldo, 2) }} Bs</p>

        <h2 class="mt-4">Ingresos</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Descripción</th>
                    <th>Tipo de Ingreso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ingresos as $ingreso)
                    <tr>
                        <td>{{ $ingreso->fecha }}</td>
                        <td>{{ number_format($ingreso->monto, 2) }} Bs</td>
                        <td>{{ $ingreso->descripcion }}</td>
                        <td>{{ ucfirst($ingreso->tipo_ingreso) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="mt-4">Egresos</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>
                @foreach($egresos as $egreso)
                    <tr>
                        <td>{{ $egreso->fecha }}</td>
                        <td>{{ number_format($egreso->monto, 2) }} Bs</td>
                        <td>{{ $egreso->descripcion }}</td>
                        <td>{{ $egreso->categoria }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
