@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('content')
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">Cambiar Contraseña</h2>

    @if(session('success'))
      <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
        <ul class="list-disc ml-5">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('cambiar.contrasena.update') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="block text-sm font-semibold">Contraseña Actual</label>
        <input type="password" name="contrasena_actual" class="w-full border px-3 py-2 rounded" required>
      </div>

      <div>
        <label class="block text-sm font-semibold">Nueva Contraseña</label>
        <input type="password" name="nueva_contrasena" class="w-full border px-3 py-2 rounded" required>
      </div>

      <div>
        <label class="block text-sm font-semibold">Confirmar Nueva Contraseña</label>
        <input type="password" name="nueva_contrasena_confirmation" class="w-full border px-3 py-2 rounded" required>
      </div>

      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded w-full">
        Actualizar Contraseña
      </button>
    </form>
  </div>
@endsection
