@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="max-w-2xl mx-auto py-8">
  <div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Editar usuario</h2>

    <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST" class="space-y-4">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-sm font-medium mb-1">Nombres</label>
        <input name="nombres" value="{{ old('nombres', $usuario->nombres) }}" 
               class="w-full border px-4 py-2 rounded focus:ring-2 focus:ring-blue-500" required>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
          <input name="apellido_paterno" value="{{ old('apellido_paterno', $usuario->apellido_paterno) }}" 
                 class="w-full border px-4 py-2 rounded focus:ring-2 focus:ring-blue-500" required>
        </div>
        
        <div>
          <label class="block text-sm font-medium mb-1">Apellido Materno</label>
          <input name="apellido_materno" value="{{ old('apellido_materno', $usuario->apellido_materno) }}" 
                 class="w-full border px-4 py-2 rounded focus:ring-2 focus:ring-blue-500">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Correo Electrónico</label>
        <input name="correo_electronico" value="{{ old('correo_electronico', $usuario->correo_electronico) }}" 
               class="w-full border px-4 py-2 rounded focus:ring-2 focus:ring-blue-500" type="email">
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Teléfono</label>
        <input name="telefono" value="{{ old('telefono', $usuario->telefono) }}" 
               class="w-full border px-4 py-2 rounded focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Rol</label>
        <select name="rol" class="w-full border px-4 py-2 rounded focus:ring-2 focus:ring-blue-500" required>
          <option value="administrador" @selected(old('rol', $usuario->rol) == 'administrador')>Administrador</option>
          <option value="secretario" @selected(old('rol', $usuario->rol) == 'secretario')>Secretario</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Estado</label>
        <select name="estado" class="w-full border px-4 py-2 rounded focus:ring-2 focus:ring-blue-500" required>
          <option value="activo" @selected(old('estado', $usuario->estado) == 'activo')>Activo</option>
          <option value="inactivo" @selected(old('estado', $usuario->estado) == 'inactivo')>Inactivo</option>
        </select>
      </div>

      <div class="pt-4 flex justify-end gap-3">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition-colors">
          Actualizar
        </button>
        <a href="{{ route('usuarios.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition-colors">
          Cancelar
        </a>
      </div>
    </form>
  </div>
</div>
@endsection