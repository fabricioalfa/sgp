@extends('layouts.guest')

@section('title', 'Iniciar sesión')

@section('content')
<main class="w-full">
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
      <input type="text" name="nombre_usuario" id="nombre_usuario"
             placeholder="Ingresa tu usuario"
             pattern="[A-Za-zÀ-ÿ\s]+" title="Solo letras y espacios"
             value="{{ old('nombre_usuario') }}"
             class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2
                    {{ $errors->has('nombre_usuario') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#F4A261]' }}">
      @error('nombre_usuario')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- Contraseña --}}
    <div class="relative">
      <label for="contrasena" class="block text-sm font-medium text-[#573830] mb-1">Contraseña</label>
      <input :type="show ? 'text' : 'password'" name="contrasena" id="contrasena"
             placeholder="Ingresa tu contraseña"
             class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2
                    {{ $errors->has('contrasena') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#F4A261]' }}">
      <button type="button" @click="show = !show"
              class="absolute right-3 top-9 text-gray-500 hover:text-[#C1440E] focus:outline-none text-sm">
        👁️
      </button>
      @error('contrasena')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="text-right">
      <a href="{{ route('password.request') }}" class="text-sm text-[#C1440E] hover:underline">
        ¿Olvidaste tu contraseña?
      </a>
    </div>

    <button type="submit"
            class="w-full bg-[#E9A209] hover:bg-[#c98b07] text-white font-semibold py-2 rounded-xl transition duration-200">
      Iniciar sesión
    </button>
  </form>
</main>
@endsection
