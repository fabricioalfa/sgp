@extends('layouts.app')

@section('title', 'Lista de Egresos')

@section('content')
  <div class="flex justify-between mb-4">
    <h2 class="text-xl font-bold">Egresos registrados</h2>
    <a href="{{ route('egresos.create') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
      Nuevo egreso
    </a>
  </div>

  <!-- Botón de generación de informes de egresos -->
  <div class="flex justify-between mb-4">
    <form action="{{ route('egresos.generarInforme') }}" method="GET">
      <div class="flex gap-4">
        <div>
          <label for="fecha_inicio" class="block text-sm font-medium mb-1">Fecha de Inicio</label>
          <input type="date" name="fecha_inicio" value="{{ request()->fecha_inicio }}" class="w-48 border rounded px-3 py-2">
        </div>
        <div>
          <label for="fecha_fin" class="block text-sm font-medium mb-1">Fecha de Fin</label>
          <input type="date" name="fecha_fin" value="{{ request()->fecha_fin }}" class="w-48 border rounded px-3 py-2">
        </div>
        <div>
          <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Generar Informe</button>
        </div>
      </div>
    </form>
  </div>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  @if($egresos->isEmpty())
    <div class="text-gray-600">No hay egresos registrados.</div>
  @else
    <table class="w-full bg-white shadow text-sm">
      <thead class="bg-gray-200 text-left">
        <tr>
          <th class="p-2">Fecha</th>
          <th class="p-2">Monto</th>
          <th class="p-2">Categoría</th>
          <th class="p-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($egresos as $egreso)
          <tr class="border-b">
            <td class="p-2">{{ $egreso->fecha }}</td>
            <td class="p-2">Bs {{ number_format($egreso->monto, 2) }}</td>
            <td class="p-2">{{ $egreso->categoria }}</td>
            <td class="p-2 flex gap-2">
              <a href="{{ route('egresos.show', $egreso) }}" class="text-blue-600 hover:underline">Ver</a>
              <a href="{{ route('egresos.edit', $egreso) }}" class="text-yellow-600 hover:underline">Editar</a>
              <form action="{{ route('egresos.destroy', $egreso) }}" method="POST" onsubmit="return confirm('¿Eliminar este egreso?')">
                @csrf @method('DELETE')
                <button class="text-red-600 hover:underline">Eliminar</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@endsection