@extends('layouts.app')

@section('title', 'Recuperar Contraseña')

@section('content')
  <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4 text-center">¿Olvidaste tu contraseña?</h2>

    @if(session('success'))
      <div class="bg-green-200 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="bg-red-200 text-red-800 px-4 py-2 rounded mb-4">
        {{ session('error') }}
      </div>
    @endif

    <form action="{{ route('password.send') }}" method="POST" class="space-y-4">
      @csrf

      <label for="correo_electronico" class="block text-sm font-semibold">Correo electrónico</label>
      <input type="email" name="correo_electronico" id="correo_electronico"
             class="w-full border px-4 py-2 rounded" required value="{{ old('correo_electronico') }}">

      <button type="submit"
              class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Enviar enlace de recuperación
      </button>
    </form>
  </div>
@endsection
