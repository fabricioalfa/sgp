@extends('layouts.app')

@section('title', 'Lista de Sacramentos')

@section('content')
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold">Sacramentos registrados</h2>
    <a href="{{ route('sacramentos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
      Nuevo sacramento
    </a>
  </div>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  @if($sacramentos->isEmpty())
    <div class="text-gray-600">No hay sacramentos registrados.</div>
  @else
    <table class="w-full text-sm bg-white shadow rounded">
      <thead class="bg-gray-100 text-left">
        <tr>
          <th class="p-2">Tipo</th>
          <th class="p-2">Fecha</th>
          <th class="p-2">Hora</th>
          <th class="p-2">Receptor</th>
          <th class="p-2">Sexo</th>
          <th class="p-2">Lugar</th>
          <th class="p-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($sacramentos as $sacramento)
          <tr class="border-b">
            <td class="p-2 capitalize">{{ $sacramento->tipo_sacramento }}</td>
            <td class="p-2">{{ $sacramento->fecha }}</td>
            <td class="p-2">{{ $sacramento->hora }}</td>
            <td class="p-2">{{ $sacramento->nombre_receptor }} {{ $sacramento->apellido_paterno }} {{ $sacramento->apellido_materno }}</td>
            <td class="p-2">{{ $sacramento->sexo }}</td>
            <td class="p-2">{{ $sacramento->lugar }}</td>
            <td class="p-2 flex gap-2">
              <a href="{{ route('sacramentos.show', $sacramento) }}" class="text-blue-600 hover:underline">Ver</a>
              <a href="{{ route('sacramentos.edit', $sacramento) }}" class="text-yellow-600 hover:underline">Editar</a>
              <form action="{{ route('sacramentos.destroy', $sacramento) }}" method="POST" onsubmit="return confirm('¿Eliminar este sacramento?')">
                @csrf
                @method('DELETE')
                <button class="text-red-600 hover:underline">Eliminar</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@endsection