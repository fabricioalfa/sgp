@extends('layouts.guest')

@section('title', 'Iniciar sesión')

@section('content')
<main class="w-full max-w-md mx-auto">
  <div class="text-center mb-6">
    <h2 class="text-3xl font-bold text-[#C1440E]">Bienvenido</h2>
    <p class="text-sm text-[#573830]">Ingresa tus credenciales para continuar</p>
  </div>

  @if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded mb-4 text-sm">
      {{ session('error') }}
    </div>
  @endif

  <form action="{{ route('login.post') }}" method="POST" class="space-y-5" novalidate x-data="{ show: false }">
    @csrf

    {{-- Usuario --}}
    <div>
      <label for="nombre_usuario" class="block text-sm font-medium text-[#573830] mb-1">Usuario</label>
      <input
        type="text"
        name="nombre_usuario"
        id="nombre_usuario"
        placeholder="Ingresa tu usuario"
        pattern="[A-Za-zÀ-ÿ\s]+"
        title="Solo letras y espacios"
        value="{{ old('nombre_usuario') }}"
        class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2
               {{ $errors->has('nombre_usuario') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#F4A261]' }}"
      >
      @error('nombre_usuario')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- Contraseña con “ojito” centrado --}}
    <div>
      <label for="contrasena" class="block text-sm font-medium text-[#573830] mb-1">Contraseña</label>
      <div class="relative">
        <input
          :type="show ? 'text' : 'password'"
          name="contrasena"
          id="contrasena"
          placeholder="Ingresa tu contraseña"
          class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2
                 {{ $errors->has('contrasena') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#F4A261]' }}"
        >
        <!-- Botón ojo, ahora posicionado relativo al input -->
        <button
          type="button"
          x-on:click="show = !show"
          class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700"
          tabindex="-1"
        >
          <template x-if="!show">
            <!-- Icono ojo cerrado -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-4.477-10-10 
                       0-1.122.18-2.197.5-3.2m4.112-3.124C7.838 2.349 9.336 2 
                       12 2c5.523 0 10 4.477 10 10 0 2.664-.349 4.162-.701 5.012
                       m-3.124 4.112A9.97 9.97 0 0112 22c-2.664 0-4.162-.349-5.012-.701" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3l18 18" />
            </svg>
          </template>
          <template x-if="show">
            <!-- Icono ojo abierto -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 
                       9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </template>
        </button>
      </div>
      @error('contrasena')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <button
      type="submit"
      class="w-full bg-[#E9A209] hover:bg-[#c98b07] text-white font-semibold py-2 rounded-xl transition duration-200"
    >
      Iniciar sesión
    </button>
  </form>
</main>
@endsection
