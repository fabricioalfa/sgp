@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
  <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Iniciar sesión</h2>

    @if(session('error'))
      <div class="bg-red-200 text-red-800 px-4 py-2 rounded mb-4">
        {{ session('error') }}
      </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label for="nombre_usuario" class="block text-sm font-semibold">Usuario</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario"
               value="{{ old('nombre_usuario') }}"
               class="w-full border px-4 py-2 rounded" required>
      </div>

      <div>
        <label for="contrasena" class="block text-sm font-semibold">Contraseña</label>
        <input type="password" name="contrasena" id="contrasena"
               class="w-full border px-4 py-2 rounded" required>
      </div>

      <div class="text-right">
        <a href="{{ route('password.request') }}" class="text-blue-600 text-sm hover:underline">
          ¿Olvidaste tu contraseña?
        </a>
      </div>

      <button type="submit"
              class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700">
        Iniciar sesión
      </button>
    </form>
  </div>
@endsection
