@extends('layouts.app')

@section('title', 'Lista de Actividades')

@section('content')
  <div class="flex justify-between mb-4">
    <h2 class="text-xl font-bold">Actividades registradas</h2>
    <a href="{{ route('actividades.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
      Nueva Actividad
    </a>
  </div>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  <table class="w-full bg-white shadow text-sm">
    <thead class="bg-gray-200 text-left">
      <tr>
        <th class="p-2">Título</th>
        <th class="p-2">Fecha de Inicio</th>
        <th class="p-2">Fecha de Fin</th>
        <th class="p-2">Responsable</th>
        <th class="p-2">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($actividades as $actividad)
        <tr class="border-b">
          <td class="p-2">{{ $actividad->titulo }}</td>
          <td class="p-2">{{ $actividad->fecha_inicio }}</td>
          <td class="p-2">{{ $actividad->fecha_fin }}</td>
          <td class="p-2">{{ $actividad->responsable }}</td>
          <td class="p-2 flex gap-2">
            <a href="{{ route('actividades.edit', $actividad) }}" class="text-yellow-600 hover:underline">Editar</a>
            <form action="{{ route('actividades.destroy', $actividad) }}" method="POST" onsubmit="return confirm('¿Eliminar esta actividad?')">
              @csrf @method('DELETE')
              <button class="text-red-600 hover:underline">Eliminar</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection