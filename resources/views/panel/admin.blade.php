@extends('layouts.app')

@section('title', 'Panel del Administrador')

@section('content')
  <h2 class="text-2xl font-bold mb-6">Bienvenido, Administrador</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <a href="{{ route('usuarios.index') }}" class="block p-6 bg-white rounded shadow hover:bg-blue-50">
      <h3 class="text-xl font-semibold text-green-800">Gestión de Usuarios</h3>
      <p class="text-sm text-gray-600">Crear, editar y eliminar usuarios del sistema.</p>
    </a>

    <a href="{{ route('rrhh.index') }}" class="block p-6 bg-white rounded shadow hover:bg-blue-50">
      <h3 class="text-xl font-semibold text-green-800">Recursos Humanos</h3>
      <p class="text-sm text-gray-600">Administrar el personal parroquial.</p>
    </a>

    
    <a href="{{ route('finanzas.index') }}" class="block p-6 bg-white rounded shadow hover:bg-blue-50">
      <h3 class="text-xl font-semibold text-blue-800">Finanzas</h3>
      <p class="text-sm text-gray-600">Gestionar ingresos y egresos, y registrar actividades económicas.</p>
    </a>
  </div>
@endsection
