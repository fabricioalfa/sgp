@extends('layouts.app')

@section('title', 'Panel Principal')

@section('content')
  <div class="max-w-3xl mx-auto bg-white/60 p-6 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-[#C1440E] mb-6 text-center">Bienvenido, {{ $usuario->nombre_usuario }}</h2>

    <div class="grid grid-cols-1 gap-6">
      <!-- Nombre de Usuario -->
      <div class="bg-[#F4A261] text-white p-4 rounded-xl shadow-md">
        <h3 class="font-semibold text-lg mb-2">Nombre de Usuario</h3>
        <p class="text-xl">{{ $usuario->nombre_usuario }}</p>
      </div>

      <!-- Información personal -->
      <div class="bg-[#F4A261] text-white p-4 rounded-xl shadow-md">
        <h3 class="font-semibold text-lg mb-2">Información Personal</h3>
        <p><strong>Nombre Completo:</strong> {{ $usuario->nombres }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</p>
        <p><strong>Correo Electrónico:</strong> {{ $usuario->correo_electronico ?? 'No registrado' }}</p>
        <p><strong>Teléfono:</strong> {{ $usuario->telefono ?? 'No registrado' }}</p>
      </div>

      <!-- Rol y Estado -->
      <div class="bg-[#F4A261] text-white p-4 rounded-xl shadow-md">
        <h3 class="font-semibold text-lg mb-2">Rol y Estado</h3>
        <p><strong>Rol:</strong> {{ ucfirst($usuario->rol) }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($usuario->estado) }}</p>
      </div>
    </div>

    <!-- Botones de Acción -->
    <div class="flex gap-6 mt-6 justify-center">
      <a href="{{ route('perfil.cambiar-contrasena') }}" class="bg-[#E9A209] text-white font-semibold py-2 px-6 rounded-lg shadow hover:bg-[#c98b07] transition">
        Cambiar Contraseña
      </a>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="bg-[#C1440E] text-white font-semibold py-2 px-6 rounded-lg shadow hover:bg-[#a8390b] transition">
          Cerrar Sesión
        </button>
      </form>
    </div>
  </div>
@endsection