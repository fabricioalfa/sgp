@extends('layouts.app')

@section('title', 'Personal de RRHH')

@section('content')
  <div class="mb-4 flex justify-between items-center">
    <h2 class="text-xl font-bold">Personal de RRHH</h2>
    <a href="{{ route('rrhh.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nuevo Personal</a>
  </div>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
  @endif

  <table class="w-full bg-white shadow rounded text-sm">
    <thead class="bg-gray-200">
      <tr>
        <th class="p-2">Nombre Completo</th>
        <th class="p-2">Cargo</th>
        <th class="p-2">Ingreso</th>
        <th class="p-2">Teléfono</th>
        <th class="p-2">Estado</th>
        <th class="p-2">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($rrhh as $p)
        <tr class="border-b">
          <td class="p-2">{{ $p->nombres }} {{ $p->apellido_paterno }} {{ $p->apellido_materno }}</td>
          <td class="p-2">{{ $p->cargo }}</td>
          <td class="p-2">{{ $p->fecha_ingreso }}</td>
          <td class="p-2">{{ $p->telefono }}</td>
          <td class="p-2">{{ ucfirst($p->estado) }}</td>
          <td class="p-2 flex gap-2">
            <a href="{{ route('rrhh.edit', $p) }}" class="text-blue-600 hover:underline">Editar</a>
            <form action="{{ route('rrhh.destroy', $p) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
              @csrf @method('DELETE')
              <button class="text-red-600 hover:underline">Eliminar</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
