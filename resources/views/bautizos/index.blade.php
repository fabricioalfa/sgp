@extends('layouts.app')

@section('title', 'Bautizos')

@section('content')
  <h2 class="text-2xl font-bold mb-6">Lista de Bautizos</h2>
  
  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
  @endif

  <a href="{{ route('bautizos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">Nuevo Bautizo</a>

  <table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
      <tr>
        <th class="p-2">Nombre del Receptor</th>
        <th class="p-2">Iglesia</th>
        <th class="p-2">Padrino</th>
        <th class="p-2">Madrina</th>
        <th class="p-2">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($bautizos as $bautizo)
        <tr>
          <td>{{ $bautizo->nombre_receptor }}</td>
          <td>{{ $bautizo->iglesia }}</td>
          <td>{{ $bautizo->nombre_padrino }} {{ $bautizo->apellido_paterno_padrino }}</td>
          <td>{{ $bautizo->nombre_madrina }} {{ $bautizo->apellido_paterno_madrina }}</td>
          <td>
            <a href="{{ route('bautizos.edit', $bautizo) }}" class="text-blue-600 hover:underline">Editar</a>
            <form action="{{ route('bautizos.destroy', $bautizo) }}" method="POST" onsubmit="return confirm('¿Eliminar este bautizo?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
