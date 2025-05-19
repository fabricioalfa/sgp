@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">
  <h2 class="text-2xl font-bold text-[#C1440E] mb-6">Cambiar Contraseña</h2>
  <form action="{{ route('perfil.cambiar-contrasena.update') }}" method="POST">

    @csrf

    <div class="mb-4">
      <label class="block text-sm text-gray-700 mb-1">Nueva Contraseña</label>
      <input type="password" name="contrasena" required class="w-full border px-3 py-2 rounded">
      @error('contrasena') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div class="mb-6">
      <label class="block text-sm text-gray-700 mb-1">Confirmar Contraseña</label>
      <input type="password" name="contrasena_confirmation" required class="w-full border px-3 py-2 rounded">
    </div>

    <div class="flex justify-end gap-4">
      <a href="{{ route('panel') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
        Cancelar
      </a>
      <button type="submit" class="bg-[#C1440E] text-white px-6 py-2 rounded-full shadow hover:bg-[#a8390b] transition">
        Cambiar Contraseña
      </button>
    </div>
  </form>
</div>
@endsection
