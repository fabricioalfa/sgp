@extends('layouts.app')

@section('title', 'Nuevo Usuario')

@section('content')
  <h2 class="text-2xl font-bold mb-4">Crear nuevo usuario</h2>

  <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-3 max-w-xl">
    @csrf

    <input name="nombre_usuario" placeholder="Nombre de usuario" value="{{ old('nombre_usuario') }}" class="w-full border px-4 py-2 rounded" required>

    <input name="contrasena" type="password" placeholder="Contraseña" class="w-full border px-4 py-2 rounded" required>

    <input name="nombres" placeholder="Nombres" value="{{ old('nombres') }}" class="w-full border px-4 py-2 rounded" required>

    <input name="apellido_paterno" placeholder="Apellido paterno" value="{{ old('apellido_paterno') }}" class="w-full border px-4 py-2 rounded" required>

    <input name="apellido_materno" placeholder="Apellido materno" value="{{ old('apellido_materno') }}" class="w-full border px-4 py-2 rounded">

    <input name="correo_electronico" placeholder="Correo electrónico" value="{{ old('correo_electronico') }}" class="w-full border px-4 py-2 rounded" type="email">

    <input name="telefono" placeholder="Teléfono" value="{{ old('telefono') }}" class="w-full border px-4 py-2 rounded">

    <select name="rol" class="w-full border px-4 py-2 rounded" required>
      <option value="">Seleccionar rol</option>
      <option value="administrador">Administrador</option>
      <option value="secretario">Secretario</option>
    </select>

    <select name="estado" class="w-full border px-4 py-2 rounded" required>
      <option value="">Seleccionar estado</option>
      <option value="activo">Activo</option>
      <option value="inactivo">Inactivo</option>
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
  </form>
@endsection
