@extends('layouts.app')

@section('title', 'Panel del Secretario')

@section('content')
  <h2 class="text-2xl font-bold mb-6">Bienvenido, Secretario</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <a href="{{ route('sacerdotes.index') }}" class="block p-6 bg-white rounded shadow hover:bg-blue-50">
      <h3 class="text-xl font-semibold text-blue-800">Gestión de Sacerdotes</h3>
      <p class="text-sm text-gray-600">Registrar y editar información de sacerdotes.</p>
    </a>

    <a href="{{ route('cebs.index') }}" class="block p-6 bg-white rounded shadow hover:bg-blue-50">
      <h3 class="text-xl font-semibold text-blue-800">Comunidades CEBs</h3>
      <p class="text-sm text-gray-600">Administrar comunidades eclesiales de base.</p>
    </a>

    <a href="{{ route('misas.index') }}" class="block p-6 bg-white rounded shadow hover:bg-blue-50">
      <h3 class="text-xl font-semibold text-blue-800">Registro de Misas</h3>
      <p class="text-sm text-gray-600">Registrar, editar o cancelar misas parroquiales.</p>
    </a>

    <a href="{{ route('sacramentos.index') }}" class="block p-6 bg-white rounded shadow hover:bg-blue-50">
      <h3 class="text-xl font-semibold text-blue-800">Registro de Sacramentos</h3>
      <p class="text-sm text-gray-600">Registrar y editar sacramentos como bautizos, comuniones, etc.</p>
    </a>
  </div>
@endsection
