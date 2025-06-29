<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo por Misa</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 40px;
            font-size: 14px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            height: 80px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            color: #444;
            margin-top: 10px;
        }
        .section {
            margin-top: 20px;
        }
        .label {
            font-weight: bold;
        }
        .box {
            border: 1px solid #ccc;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature {
            width: 45%;
            text-align: center;
        }
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #000;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('images/logo-arquidiocesis.png') }}" alt="Logo" class="logo">
        <div class="title">Recibo por Misa</div>
    </header>

    <div class="section box">
        <div><span class="label">Fecha de emisión:</span> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
        <div><span class="label">Intención:</span> {{ $misa->intencion }}</div>
        <div><span class="label">Fecha de la misa:</span> {{ \Carbon\Carbon::parse($misa->fecha)->format('d/m/Y') }}</div>
        <div><span class="label">Hora:</span> {{ $misa->hora }}</div>
        <div><span class="label">Lugar:</span> {{ $misa->lugar }}</div>
        <div><span class="label">Monto pagado:</span> Bs {{ number_format($misa->estipendio, 2, ',', '.') }}</div>
    </div>

    <div style="margin-top: 60px; text-align: center;">
    <div style="border: 1px dashed #aaa; height: 100px; width: 300px; margin: 0 auto; border-radius: 6px;">
        <p style="margin-top: 70px; font-size: 12px; color: #666;">Sello de la Parroquia</p>
    </div>
</div>

</body>
</html>
