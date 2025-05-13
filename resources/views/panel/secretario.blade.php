@extends('layouts.app')

@section('title', 'Panel del Secretario')

@section('content')
  <h2 class="text-3xl font-bold text-purple-800 mb-6">Bienvenido, Secretario</h2>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <a href="{{ route('sacerdotes.index') }}"
       class="group block bg-purple-100 p-6 rounded-xl shadow hover:shadow-md transition">
      <h3 class="text-lg font-semibold text-purple-800 mb-1">Gestión de Sacerdotes</h3>
      <p class="text-sm text-gray-700">Registrar y editar sacerdotes.</p>
    </a>

    <a href="{{ route('certificados.index') }}"
       class="group block bg-purple-100 p-6 rounded-xl shadow hover:shadow-md transition">
      <h3 class="text-lg font-semibold text-purple-800 mb-1">Emitir Certificados</h3>
      <p class="text-sm text-gray-700">Generar documentos parroquiales.</p>
    </a>

    {{-- Puedes seguir agregando tarjetas similares aquí --}}
  </div>
@endsection
