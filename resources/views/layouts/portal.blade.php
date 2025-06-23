<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Portal Parroquial')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- ✅ Carga Tailwind CSS directamente desde CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- Fuentes o estilos extra opcionales --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Nunito', sans-serif;
    }
  </style>
</head>
<body class="bg-[#fef6f0] text-[#573830] min-h-screen flex flex-col">

  {{-- Encabezado --}}
  <header class="bg-white/80 shadow-md py-4 px-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-[#C1440E]">Parroquia</h1>
    <div class="text-sm flex items-center gap-4">
      <span>{{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
      <a href="{{ route('login') }}"
         class="bg-[#E9A209] text-white px-4 py-1 rounded-full hover:bg-[#c98b07] transition text-sm">
        Iniciar sesión
      </a>
    </div>
  </header>

  {{-- Contenido principal --}}
  <main class="flex-grow p-6">
    @yield('content')
  </main>

  {{-- Pie de página --}}
  <footer class="bg-white/90 text-center py-4 text-sm text-[#a3671b]">
    &copy; {{ now()->year }} Parroquia. Todos los derechos reservados.
  </footer>

</body>
</html>
