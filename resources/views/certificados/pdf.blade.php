<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Certificado de {{ ucfirst($sacramento->tipo_sacramento) }}</title>
  <style>
    body {
      font-family: 'DejaVu Sans', sans-serif;
      margin: 40px;
      font-size: 14px;
    }
    header {
      text-align: center;
      margin-bottom: 30px;
    }
    header img {
      height: 80px;
      margin-bottom: 10px;
    }
    .titulo {
      font-size: 20px;
      font-weight: bold;
      text-transform: uppercase;
      margin-top: 10px;
      color: #333;
    }
    .contenido {
      line-height: 1.8;
      text-align: justify;
    }
    .firma {
      margin-top: 80px;
      text-align: center;
    }
    .footer {
      position: fixed;
      bottom: 30px;
      text-align: center;
      font-size: 12px;
      width: 100%;
      color: #666;
    }
  </style>
</head>
<body>
  <header>
    <img src="{{ public_path('images/logo-arquidiocesis.png') }}" alt="Logo Arquidiócesis">
    <div class="titulo">Certificado de {{ ucfirst($sacramento->tipo_sacramento) }}</div>
    <hr style="margin-top: 10px;">
  </header>

  <div class="contenido">
    <p><strong>Fecha de emisión:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>

    <p>
      Se hace constar que <strong>{{ $sacramento->nombre_receptor }} {{ $sacramento->apellido_paterno }} {{ $sacramento->apellido_materno }}</strong>
      recibió el sacramento de <strong>{{ ucfirst($sacramento->tipo_sacramento) }}</strong>
      el día <strong>{{ \Carbon\Carbon::parse($sacramento->fecha)->format('d/m/Y') }}</strong>
      a horas <strong>{{ $sacramento->hora }}</strong>,
      en <strong>{{ $sacramento->lugar }}</strong>,
      correspondiente a la Iglesia <strong>{{ $sacramento->iglesia }}</strong>.
    </p>

    <p>Este certificado se emite a solicitud del interesado, para los fines que estime convenientes.</p>
  </div>

  <div class="firma">
    ___________________________<br>
    Sello de la Parroquia
  </div>

  <div class="footer">
    Parroquia La Paz – {{ now()->year }} – www.parroquialapaz.bo
  </div>
</body>
</html>
