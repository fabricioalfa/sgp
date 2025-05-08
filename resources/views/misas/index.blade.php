@extends('layouts.app')

@section('title', 'Lista de Misas')

@section('content')
  <div class="flex justify-between mb-4">
    <h2 class="text-xl font-bold">Misas registradas</h2>
    <a href="{{ route('misas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
      Nueva misa
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
        <th class="p-2">Hora</th>
        <th class="p-2">Tipo</th>
        <th class="p-2">Sacerdote</th>
        <th class="p-2">Estado</th>
        <th class="p-2">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($misas as $misa)
        <tr class="border-b">
          <td class="p-2">{{ $misa->fecha }}</td>
          <td class="p-2">{{ $misa->hora }}</td>
          <td class="p-2">{{ $misa->tipo_misa ?? '-' }}</td>
          <td class="p-2">{{ $misa->sacerdote->nombres ?? 'Sin asignar' }}</td>
          <td class="p-2">{{ ucfirst($misa->estado) }}</td>
          <td class="p-2 flex gap-2">
            <a href="{{ route('misas.edit', $misa) }}" class="text-blue-600 hover:underline">Editar</a>
            <form action="{{ route('misas.destroy', $misa) }}" method="POST" onsubmit="return confirm('¿Eliminar esta misa?')">
              @csrf @method('DELETE')
              <button class="text-red-600 hover:underline">Eliminar</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
