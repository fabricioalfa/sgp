<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Panel Administrativo')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    html, body {
      height: 100vh;
      overflow: hidden; /* ❌ Prohíbe scroll en body */
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      font-size: 16px;
      background-color: #FFF8F0;
      background-image: url('{{ asset('images/fondosgp.png') }}');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
    }

    [x-cloak] { display: none !important; }

    table td {
      color: #573830 !important;
    }
  </style>
</head>

<body class="text-[#3C3C3C] h-screen flex text-base overflow-hidden">

  {{-- Sidebar --}}
  <aside class="w-64 bg-[#E9A209] text-white shadow-lg flex flex-col h-full text-lg backdrop-blur-sm/40">
    <div class="px-6 py-5 text-2xl font-extrabold tracking-tight border-b border-[#F4A261]">
      Sistema Parroquial
    </div>

    <nav class="flex-1 px-4 py-6 space-y-3 font-semibold overflow-y-auto">
      <a href="{{ route('panel') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#C1440E] transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M3 9.75V21h18V9.75L12 3 3 9.75z" />
        </svg>
        Panel Principal
      </a>
      <a href="{{ route('sacerdotes.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#C1440E] transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21v-2a4 4 0 014-4h8a4 4 0 014 4v2" />
        </svg>
        Sacerdotes
      </a>
      <a href="{{ route('cebs.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#C1440E] transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M5 13l4 4L19 7" />
        </svg>
        CEBs
      </a>
      <a href="{{ route('misas.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#C1440E] transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" />
        </svg>
        Misas
      </a>
      <a href="{{ route('sacramentos.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#C1440E] transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M5 12h14M12 5l7 7-7 7" />
        </svg>
        Sacramentos
      </a>
      <a href="{{ route('actividades.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#C1440E] transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M8 7V3m8 4V3m-9 4h10M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z" />
        </svg>
        Actividades
      </a>
      <a href="{{ route('certificados.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#C1440E] transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M9 12h6m2 6H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v9a2 2 0 01-2 2z" />
        </svg>
        Certificados
      </a>
      <a href="{{ route('finanzas.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#C1440E] transition">
        <!-- Moneda (Heroicons) -->
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path fill="none" stroke="currentColor" stroke-width="2" d="M17 9l4 4-4 4M7 9l-4 4 4 4"></path>
          <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
        </svg>
        Finanzas
    </a>
    
    </nav>

    {{-- Usuario --}}
    @if(session('usuario'))
    <div class="px-4 py-5 border-t border-[#F4A261] bg-[#F4A261]/10">
      <div class="text-sm text-white/80 mb-2">Sesión activa</div>
      <div class="text-base font-semibold text-white truncate mb-3">
        {{ session('usuario')->nombre_usuario }}
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="w-full bg-white text-[#C1440E] font-semibold py-2 rounded-md hover:bg-[#ffe4ca] transition">
          Cerrar sesión
        </button>
      </form>
    </div>
    @endif
  </aside>

  {{-- Contenido principal --}}
  <div class="flex-1 flex flex-col text-[1.05rem] h-full">
    <header class="bg-white/90 shadow-sm px-6 py-4 flex justify-between items-center backdrop-blur-sm">
      <h1 class="text-2xl font-bold text-[#C1440E]">@yield('title')</h1>
      <span class="text-base text-gray-700">
        {{ \Carbon\Carbon::now()->translatedFormat('l, d \de F \de Y') }}
      </span>
    </header>

    {{-- Solo este contenedor hace scroll --}}
    <main class="p-6 m-4 bg-white/5 rounded-xl shadow-lg flex-1 overflow-y-auto">
      @yield('content')
    </main>
  </div>

</body>
</html>
