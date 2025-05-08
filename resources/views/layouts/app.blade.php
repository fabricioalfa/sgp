<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Panel Parroquial')</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  {{-- Barra de navegación superior --}}
      @if(request()->route()->getName() !== 'login')
    <nav class="bg-blue-800 text-white p-4 flex justify-between items-center">
      
      {{-- Izquierda: título + botón Pantalla Principal --}}
      <div class="flex items-center gap-4">
        <h1 class="text-lg font-semibold">Sistema Parroquial</h1>

        @if(session()->has('usuario') && url()->current() !== route('panel'))
          <a href="{{ route('panel') }}" class="bg-blue-600 hover:bg-blue-700 px-4 py-1 rounded text-sm">
            🏠 Pantalla Principal
          </a>
        @endif
      </div>

      {{-- Derecha: botón Atrás y menú de usuario --}}
      <div class="flex items-center gap-4">
        @if(session()->has('usuario') && !in_array(url()->current(), [route('login'), route('panel')]))
          <a href="{{ url()->previous() }}" class="bg-gray-500 hover:bg-gray-600 px-4 py-1 rounded text-sm">
            ⬅️ Atrás
          </a>
        @endif

        @if(session()->has('usuario'))
          <div class="relative">
            <button onclick="toggleUserMenu()" class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-sm">
              {{ session('usuario')->nombre_usuario }} ▾
            </button>
            <div id="userDropdown" class="hidden absolute right-0 mt-2 bg-white text-black rounded shadow-md w-48 z-50">
              <a href="{{ route('perfil') }}" class="block px-4 py-2 hover:bg-gray-100">Mi perfil</a>
              <a href="{{ route('cambiar.contrasena') }}" class="block px-4 py-2 hover:bg-gray-100">Cambiar contraseña</a>

              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full text-left px-4 py-2 hover:bg-red-100 text-red-600">Cerrar sesión</button>
              </form>
            </div>
          </div>
        @endif
      </div>
    </nav>

    <script>
      function toggleUserMenu() {
        const menu = document.getElementById('userDropdown');
        menu.classList.toggle('hidden');
      }
    </script>
    @endif


  {{-- Contenido principal --}}
  <main class="p-6">
    @yield('content')
  </main>

</body>
</html>
