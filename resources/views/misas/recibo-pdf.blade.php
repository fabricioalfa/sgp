<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Recibo de Misa</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    .header { text-align: center; font-weight: bold; margin-bottom: 20px; }
    .section { margin-bottom: 10px; }
    .label { font-weight: bold; }
  </style>
</head>
<body>
  <div class="header">RECIBO DE MISA</div>

  <div class="section">
    <span class="label">Tipo de Misa:</span> {{ $misa->tipo_misa }}
  </div>
  <div class="section">
    <span class="label">Fecha:</span> {{ $misa->fecha }} {{ $misa->hora }}
  </div>
  <div class="section">
    <span class="label">Sacerdote:</span> {{ $misa->sacerdote->nombres ?? 'No asignado' }}
  </div>
  <div class="section">
    <span class="label">Estipendio:</span> Bs {{ number_format($misa->estipendio, 2) }}
  </div>

  <hr>

  <div class="section" style="margin-top: 40px; text-align: right;">
    <em>Emitido el {{ now()->format('d/m/Y H:i') }}</em>
  </div>
</body>
</html>
