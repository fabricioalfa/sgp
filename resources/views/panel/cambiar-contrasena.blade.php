@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('content')
  <div class="max-w-md mx-auto bg-white/60 p-6 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-[#C1440E] mb-4 text-center">Cambiar Contraseña</h2>

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

    <form action="{{ route('perfil.cambiar-contrasena.update') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="block text-sm font-semibold text-[#C1440E] mb-1">Contraseña Actual</label>
        <input type="password" name="contrasena_actual" class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]" required>
      </div>

      <div>
        <label class="block text-sm font-semibold text-[#C1440E] mb-1">Nueva Contraseña</label>
        <input type="password" name="nueva_contrasena" class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]" required>
      </div>

      <div>
        <label class="block text-sm font-semibold text-[#C1440E] mb-1">Confirmar Nueva Contraseña</label>
        <input type="password" name="nueva_contrasena_confirmation" class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]" required>
      </div>

      <button type="submit" class="bg-[#E9A209] text-white font-semibold py-2 px-4 rounded-xl hover:bg-[#c98b07] transition-colors w-full">
        Actualizar Contraseña
      </button>
    </form>
  </div>
@endsection