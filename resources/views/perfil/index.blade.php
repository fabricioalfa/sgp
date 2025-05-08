@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">Mi Perfil</h2>

    <div class="grid grid-cols-1 gap-4">
      <p><strong>Usuario:</strong> {{ $usuario->nombre_usuario }}</p>
      <p><strong>Nombre completo:</strong> {{ $usuario->nombres }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</p>
      <p><strong>Correo electrónico:</strong> {{ $usuario->correo_electronico ?? 'No registrado' }}</p>
      <p><strong>Teléfono:</strong> {{ $usuario->telefono ?? 'No registrado' }}</p>
      <p><strong>Rol:</strong> {{ ucfirst($usuario->rol) }}</p>
      <p><strong>Estado:</strong> {{ ucfirst($usuario->estado) }}</p>
    </div>
  </div>
@endsection
