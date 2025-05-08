@extends('layouts.app')

@section('title', 'Restablecer Contraseña')

@section('content')
  <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4 text-center">Restablecer contraseña</h2>

    @if(session('error'))
      <div class="bg-red-200 text-red-800 px-4 py-2 rounded mb-4">
        {{ session('error') }}
      </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
      @csrf

      <input type="hidden" name="token" value="{{ $token }}">
      <input type="hidden" name="correo_electronico" value="{{ $correo }}">

      <label for="contrasena" class="block text-sm font-semibold">Nueva contraseña</label>
      <input type="password" name="contrasena" id="contrasena"
             class="w-full border px-4 py-2 rounded" required>

      <label for="contrasena_confirmation" class="block text-sm font-semibold">Confirmar contraseña</label>
      <input type="password" name="contrasena_confirmation" id="contrasena_confirmation"
             class="w-full border px-4 py-2 rounded" required>

      <button type="submit"
              class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Cambiar contraseña
      </button>
    </form>
  </div>
@endsection
