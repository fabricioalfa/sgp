<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Recibo Sacramento</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            margin: 40px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        header img {
            height: 80px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
            text-transform: uppercase;
            color: #444;
        }
        .section {
            margin-top: 15px;
        }
        .label {
            font-weight: bold;
        }
        .box {
            border: 1px solid #ccc;
            padding: 12px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        .fieles-list {
            margin-top: 5px;
        }
        .footer {
            margin-top: 60px;
            text-align: center;
        }
        .seal-box {
            border: 1px dashed #aaa;
            height: 100px;
            width: 300px;
            margin: 0 auto;
            border-radius: 6px;
        }
        .seal-text {
            margin-top: 70px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('images/logo-arquidiocesis.png') }}" alt="Logo">
        <div class="title">Recibo de Sacramento - {{ strtoupper($sacramento->tipo_sacramento) }}</div>
    </header>

    <div class="section box">
        <div><span class="label">Receptor:</span> {{ $sacramento->nombre_receptor }} {{ $sacramento->apellido_paterno }} {{ $sacramento->apellido_materno }}</div>
        <div><span class="label">Fecha del Sacramento:</span> {{ \Carbon\Carbon::parse($sacramento->fecha)->format('d/m/Y') }} a las {{ $sacramento->hora }}</div>
        <div><span class="label">Lugar:</span> {{ $sacramento->lugar }} | Iglesia: {{ $sacramento->iglesia }}</div>
        <div><span class="label">Fecha de nacimiento:</span> {{ \Carbon\Carbon::parse($sacramento->fecha_nacimiento)->format('d/m/Y') }} | Sexo: {{ ucfirst($sacramento->sexo) }}</div>
    </div>

    <div class="section">
        <span class="label">Fieles Asociados:</span>
        <ul class="fieles-list">
            @foreach($fieles as $fiel)
                <li>{{ ucfirst($fiel->tipo_fiel) }}: {{ $fiel->nombres }} {{ $fiel->apellido_paterno }} {{ $fiel->apellido_materno }}</li>
            @endforeach
        </ul>
    </div>

    <div class="section" style="text-align: right;">
        <em>Emitido el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</em>
    </div>

    <div class="footer">
        <div class="seal-box">
            <p class="seal-text">Sello de la Parroquia</p>
        </div>
    </div>
</body>
</html>
