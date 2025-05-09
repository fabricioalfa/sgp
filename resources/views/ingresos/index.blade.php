@extends('layouts.app')

@section('title', 'Lista de Ingresos')

@section('content')
  <div class="flex justify-between mb-4">
    <h2 class="text-xl font-bold">Ingresos registrados</h2>
    <a href="{{ route('ingresos.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
      Nuevo ingreso
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
          <td class="p-2">{{ ucfirst($ingreso->tipo_ingreso) }}</td>
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
@endsection
