{{-- resources/views/auth/passwords/email.blade.php --}}
@extends('layouts.guest')

@section('title', 'Recuperar contraseña')

@section('content')
<main class="w-full max-w-md mx-auto">
  <div class="text-center mb-6">
    <h2 class="text-3xl font-bold text-[#C1440E]">Recuperar contraseña</h2>
    <p class="text-sm text-[#573830]">Ingresa tu correo y te enviaremos un enlace</p>
  </div>

  {{-- Mensaje de éxito --}}
  @if(session('success'))
    <div
      x-data="{ show: true }"
      x-show="show"
      x-init="setTimeout(() => show = false, 5000)"
      class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 text-sm"
    >
      {{ session('success') }}
    </div>
  @endif

  {{-- Mensaje de error --}}
  @if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded mb-4 text-sm">
      {{ session('error') }}
    </div>
  @endif

  <form action="{{ route('password.send') }}" method="POST" class="space-y-5">
    @csrf

    <div>
      <label for="correo_electronico" class="block text-sm font-medium text-[#573830] mb-1">Correo electrónico</label>
      <input
        type="email"
        name="correo_electronico"
        id="correo_electronico"
        value="{{ old('correo_electronico') }}"
        required
        class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2
          {{ $errors->has('correo_electronico') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#F4A261]' }}"
      >
      @error('correo_electronico')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <button
      type="submit"
      class="w-full bg-[#E9A209] hover:bg-[#c98b07] text-white font-semibold py-2 rounded-xl transition duration-200"
    >
      Enviar enlace
    </button>
  </form>

  <div class="mt-4 text-center">
    <a href="{{ route('login') }}" class="text-[#C1440E] hover:underline">
      ← Volver al login
    </a>
  </div>
</main>
@endsection
