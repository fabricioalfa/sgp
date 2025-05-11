<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: sans-serif; margin: 2cm; }
    .header { text-align: center; margin-bottom: 1cm; }
    .header h2 { margin: 0; }
    .content { line-height: 1.5; }
    .footer {
      position: fixed;
      bottom: 2cm;
      width: 100%;
      text-align: center;
      font-size: 0.8em;
    }
  </style>
</head>
<body>
  <div class="header">
    <h2>PARROQUIA LA PAZ</h2>
    <h3>Certificado de {{ $tipo }}</h3>
    <hr>
  </div>

  <div class="content">
    <p><strong>Fecha de emisión:</strong> {{ $fecha }}</p>

    @if($sacramento)
      <p>
        Se certifica que
        <strong>{{ $sacramento->nombre_receptor }}
        {{ $sacramento->apellido_paterno }}
        {{ $sacramento->apellido_materno }}</strong>,
        recibió el sacramento de
        <strong>{{ ucfirst($sacramento->tipo) }}</strong>
        el día
        <strong>{{ \Carbon\Carbon::parse($sacramento->fecha)->format('d/m/Y') }}</strong>
        en
        <strong>{{ $sacramento->lugar }}</strong>.
      </p>
    @else
      <p>Solicitud de certificado: <strong>{{ $tipo }}</strong>.</p>
    @endif

    <p class="mt-4">Atentamente,</p>
    <p>__________________________</p>
    <p>Párroco / Secretario</p>
  </div>

  <div class="footer">
    Parroquia La Paz – {{ now()->year }} – www.parroquialapaz.bo
  </div>
</body>
</html>
