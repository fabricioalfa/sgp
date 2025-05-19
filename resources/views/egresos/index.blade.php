@extends('layouts.app')

@section('title', 'Lista de Egresos')

@section('content')
  <div class="flex justify-between mb-4">
    <h2 class="text-xl font-bold text-[#C1440E]">Egresos registrados</h2>
    <a href="{{ route('egresos.create') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
      Nuevo egreso
    </a>
  </div>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  @if($egresos->isEmpty())
    <div class="text-gray-600">No hay egresos registrados.</div>
  @else
    <!-- Formulario de filtro por fechas -->
    <form action="{{ route('egresos.informe') }}" method="GET" target="_blank" class="flex gap-4 mb-6">
      <div>
        <label for="fecha_inicio" class="block text-sm font-medium mb-1">Fecha de Inicio</label>
        <input type="date" name="fecha_inicio" value="{{ request()->fecha_inicio }}" required class="w-48 border rounded px-3 py-2">
      </div>
      <div>
        <label for="fecha_fin" class="block text-sm font-medium mb-1">Fecha de Fin</label>
        <input type="date" name="fecha_fin" value="{{ request()->fecha_fin }}" required class="w-48 border rounded px-3 py-2">
      </div>
      <div>
        <!-- El botón enviará el formulario y abrirá el informe en una nueva pestaña -->
        <button type="submit" class="bg-[#E9A209] text-white px-6 py-2 rounded hover:bg-[#c98b07] transition">
          Generar Informe
        </button>
      </div>
    </form>

    <!-- Tabla de egresos -->
    <table class="w-full bg-white shadow text-sm">
      <thead class="bg-[#F4A261] text-left text-white">
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
            <td class="p-2 capitalize">{{ $egreso->categoria }}</td>
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

  <!-- Botón Volver a Finanzas -->
  <div class="mt-4">
    <a href="{{ route('finanzas.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700 transition">Volver a Finanzas</a>
  </div>
@endsection
