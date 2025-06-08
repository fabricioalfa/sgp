{{-- resources/views/usuarios/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="max-w-2xl mx-auto mt-10">
  <h2 class="text-2xl font-bold text-[#C1440E] mb-6">Crear Nuevo Usuario</h2>

  @if(session('success'))
    <div class="bg-green-100/80 border border-green-300 text-green-800 px-4 py-2 rounded-lg mb-4 text-sm">
      {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('usuarios.store') }}" method="POST" class="bg-white/60 p-8 rounded-xl shadow space-y-6">
    @csrf

    {{-- Nombre de Usuario --}}
    <div>
      <label class="block text-sm font-semibold text-[#C1440E] mb-1">Nombre de usuario</label>
      <input
        type="text"
        name="nombre_usuario"
        value="{{ old('nombre_usuario') }}"
        class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('nombre_usuario') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}"
        required
      >
      @error('nombre_usuario')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- Contraseña --}}
    <div>
      <label class="block text-sm font-semibold text-[#C1440E] mb-1">Contraseña</label>
      <input
        type="password"
        name="contrasena"
        class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('contrasena') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}"
        required
      >
      @error('contrasena')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- Nombres --}}
    <div>
      <label class="block text-sm font-semibold text-[#C1440E] mb-1">Nombres</label>
      <input
        type="text"
        name="nombres"
        value="{{ old('nombres') }}"
        class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('nombres') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}"
        required
      >
      @error('nombres')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- Apellidos --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-semibold text-[#C1440E] mb-1">Apellido Paterno</label>
        <input
          type="text"
          name="apellido_paterno"
          value="{{ old('apellido_paterno') }}"
          class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('apellido_paterno') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}"
          required
        >
        @error('apellido_paterno')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div>
        <label class="block text-sm font-semibold text-[#C1440E] mb-1">Apellido Materno</label>
        <input
          type="text"
          name="apellido_materno"
          value="{{ old('apellido_materno') }}"
          class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('apellido_materno') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}"
        >
        @error('apellido_materno')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>
    </div>

    {{-- Correo y Teléfono --}}
    <div>
      <label class="block text-sm font-semibold text-[#C1440E] mb-1">Correo Electrónico</label>
      <input
        type="email"
        name="correo_electronico"
        value="{{ old('correo_electronico') }}"
        class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('correo_electronico') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}"
      >
      @error('correo_electronico')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label class="block text-sm font-semibold text-[#C1440E] mb-1">Teléfono</label>
      <input
        type="tel"
        name="telefono"
        value="{{ old('telefono') }}"
        class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('telefono') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}"
      >
      @error('telefono')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- Rol y Estado --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-semibold text-[#C1440E] mb-1">Rol</label>
        <select
          name="rol"
          class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('rol') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}"
          required
        >
          <option value="">Seleccionar rol</option>
          <option value="administrador" @selected(old('rol')=='administrador')>Administrador</option>
          <option value="secretario"    @selected(old('rol')=='secretario')>Secretario</option>
        </select>
        @error('rol')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div>
        <label class="block text-sm font-semibold text-[#C1440E] mb-1">Estado</label>
        <select
          name="estado"
          class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('estado') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}"
          required
        >
          <option value="">Seleccionar estado</option>
          <option value="activo"   @selected(old('estado')=='activo')>Activo</option>
          <option value="inactivo" @selected(old('estado')=='inactivo')>Inactivo</option>
        </select>
        @error('estado')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>
    </div>

    {{-- Botones --}}
    <div class="pt-6 flex justify-end gap-4">
      <a href="{{ route('usuarios.index') }}"
         class="px-6 py-2 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 transition">
        Cancelar
      </a>
      <button type="submit"
              class="bg-[#E9A209] text-white px-6 py-2 rounded-xl shadow hover:bg-[#c98b07] transition">
        Guardar
      </button>
    </div>
  </form>
</div>
@endsection
