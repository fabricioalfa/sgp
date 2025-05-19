<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recibo Sacramento</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; font-weight: bold; margin-bottom: 20px; }
        .section { margin-bottom: 10px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">RECIBO DE SACRAMENTO - {{ strtoupper($sacramento->tipo_sacramento) }}</div>

    <div class="section">
        <span class="label">Receptor:</span> {{ $sacramento->nombre_receptor }} {{ $sacramento->apellido_paterno }} {{ $sacramento->apellido_materno }}
    </div>
    <div class="section">
        <span class="label">Fecha de Sacramento:</span> {{ $sacramento->fecha }} - {{ $sacramento->hora }}
    </div>
    <div class="section">
        <span class="label">Lugar:</span> {{ $sacramento->lugar }} | Iglesia: {{ $sacramento->iglesia }}
    </div>
    <div class="section">
        <span class="label">Fecha de Nacimiento:</span> {{ $sacramento->fecha_nacimiento }} | Sexo: {{ ucfirst($sacramento->sexo) }}
    </div>

    <hr>

    <div class="section">
        <span class="label">Fieles Asociados:</span>
        <ul>
            @foreach($fieles as $fiel)
              <li>{{ ucfirst($fiel->tipo_fiel) }}: {{ $fiel->nombres }} {{ $fiel->apellido_paterno }} {{ $fiel->apellido_materno }}</li>
            @endforeach
        </ul>
    </div>

    <div class="section" style="margin-top: 40px; text-align: right;">
        <em>Emitido el {{ now()->format('d/m/Y H:i') }}</em>
    </div>
</body>
</html>
