@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold">Usuarios</h2>
    <a href="{{ route('usuarios.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
      + Nuevo usuario
    </a>
  </div>

  @if(session('success'))
    <div class="bg-green-200 text-green-800 px-4 py-2 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  <table class="w-full border text-sm">
    <thead class="bg-gray-100">
      <tr>
        <th class="border px-2 py-1">Usuario</th>
        <th class="border px-2 py-1">Nombre</th>
        <th class="border px-2 py-1">Apellidos</th>
        <th class="border px-2 py-1">Correo</th>
        <th class="border px-2 py-1">Rol</th>
        <th class="border px-2 py-1">Estado</th>
        <th class="border px-2 py-1">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($usuarios as $usuario)
        <tr>
          <td class="border px-2 py-1">{{ $usuario->nombre_usuario }}</td>
          <td class="border px-2 py-1">{{ $usuario->nombres }}</td>
          <td class="border px-2 py-1">{{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</td>
          <td class="border px-2 py-1">{{ $usuario->correo_electronico }}</td>
          <td class="border px-2 py-1 capitalize">{{ $usuario->rol }}</td>
          <td class="border px-2 py-1 capitalize">{{ $usuario->estado }}</td>
          <td class="border px-2 py-1 space-x-2">
            <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" class="text-blue-600 hover:underline">Editar</a>
            <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
