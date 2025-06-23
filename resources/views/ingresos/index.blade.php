@extends('layouts.app')

@section('title', 'Lista de Ingresos')

@section('content')
  <div class="flex flex-wrap justify-between items-center gap-2 mb-4">
    <div class="flex items-center gap-4">
      <h2 class="text-xl font-bold text-[#C1440E]">Ingresos registrados</h2>
      <a href="{{ route('finanzas.index') }}"
         class="text-sm bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-gray-300 transition">
        ← Volver a Finanzas
      </a>
    </div>
    <a href="{{ route('ingresos.create') }}"
       class="bg-[#E9A209] text-white px-4 py-2 rounded hover:bg-[#c98b07] transition">
      Nuevo ingreso
    </a>
  </div>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  @if($ingresos->isEmpty())
    <div class="text-gray-600">No hay ingresos registrados.</div>
  @else
    <!-- Tabla de ingresos -->
    <table class="w-full bg-white shadow text-sm">
      <thead class="bg-[#F4A261] text-left text-white">
        <tr>
          <th class="p-2">Fecha</th>
          <th class="p-2">Monto</th>
          <th class="p-2">Tipo</th>
          <th class="p-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($ingresos as $ingreso)
          <tr class="border-b">
            <td class="p-2">{{ $ingreso->fecha }}</td>
            <td class="p-2">Bs {{ number_format($ingreso->monto, 2) }}</td>
            <td class="p-2 capitalize">{{ $ingreso->tipo_ingreso }}</td>
            <td class="p-2 flex gap-2">
              <a href="{{ route('ingresos.show', $ingreso) }}" class="text-blue-600 hover:underline">Ver</a>
              <a href="{{ route('ingresos.edit', $ingreso) }}" class="text-yellow-600 hover:underline">Editar</a>
              <form action="{{ route('ingresos.destroy', $ingreso) }}" method="POST" onsubmit="return confirm('¿Eliminar este ingreso?')">
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
