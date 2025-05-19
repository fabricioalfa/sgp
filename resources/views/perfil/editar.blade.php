@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow" x-data="{ confirmar: false, exito: false }">
  <h2 class="text-2xl font-bold text-[#C1440E] mb-6">Editar Perfil</h2>

  @if(session('success'))
    <div x-init="exito = true" x-show="exito" class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 text-sm">
      {{ session('success') }}
    </div>
  @endif

  <form x-ref="formulario" action="{{ route('perfil.actualizar') }}" method="POST">
    @csrf

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="text-sm text-gray-700">Nombre de Usuario</label>
        <input type="text" name="nombre_usuario" value="{{ old('nombre_usuario', $usuario->nombre_usuario) }}" class="w-full border rounded px-3 py-2">
        @error('nombre_usuario') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="text-sm text-gray-700">Nueva Contraseña (opcional)</label>
        <input type="password" name="contrasena" class="w-full border rounded px-3 py-2" x-on:change="confirmar = true">
        @error('contrasena') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div class="sm:col-span-2">
        <label class="text-sm text-gray-700">Nombres</label>
        <input type="text" name="nombres" value="{{ old('nombres', $usuario->nombres) }}" class="w-full border rounded px-3 py-2">
        @error('nombres') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="text-sm text-gray-700">Apellido Paterno</label>
        <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $usuario->apellido_paterno) }}" class="w-full border rounded px-3 py-2">
        @error('apellido_paterno') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="text-sm text-gray-700">Apellido Materno</label>
        <input type="text" name="apellido_materno" value="{{ old('apellido_materno', $usuario->apellido_materno) }}" class="w-full border rounded px-3 py-2">
        @error('apellido_materno') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="text-sm text-gray-700">Correo Electrónico</label>
        <input type="email" name="correo_electronico" value="{{ old('correo_electronico', $usuario->correo_electronico) }}" class="w-full border rounded px-3 py-2">
        @error('correo_electronico') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="text-sm text-gray-700">Teléfono</label>
        <input type="text" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" class="w-full border rounded px-3 py-2">
        @error('telefono') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>
    </div>

    <!-- Modal de confirmación -->
    <div x-show="confirmar" x-cloak class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md text-center">
        <h3 class="text-lg font-semibold text-[#C1440E] mb-4">¿Desea cambiar la contraseña?</h3>
        <div class="flex justify-center gap-4 mt-4">
          <button type="button" @click="confirmar = false" class="px-4 py-2 border rounded hover:bg-gray-100">Cancelar</button>
          <button type="button" @click="$refs.formulario.submit()" class="px-4 py-2 bg-[#C1440E] text-white rounded hover:bg-[#a8390b]">Confirmar</button>
        </div>
      </div>
    </div>

    <div class="mt-6 flex justify-end gap-4">
      <a href="{{ route('panel') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
        Cancelar
      </a>
      <button type="button"
        @click="confirmar ? confirmar = true : $refs.formulario.submit()"
        class="bg-[#E9A209] text-white px-6 py-2 rounded-full shadow hover:bg-[#c98b07] transition">
  Guardar Cambios
</button>

    </div>
  </form>
</div>
@endsection
