@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-8 p-6 bg-white rounded shadow">
  <h2 class="text-xl font-semibold mb-4">¿Olvidaste tu contraseña?</h2>
  @if(session('status'))
    <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
      {{ session('status') }}
    </div>
  @endif
  <form method="POST" action="{{ route('password.send') }}">
    @csrf
    <label class="block mb-2">Correo electrónico</label>
    <input
      type="email"
      name="email"
      value="{{ old('email') }}"
      required
      class="w-full border p-2 mb-4"
    >
    @error('email')
      <p class="text-red-600 text-sm mb-4">{{ $message }}</p>
    @enderror
    <button
      type="submit"
      class="w-full bg-blue-600 text-white p-2 rounded"
    >Enviar enlace</button>
  </form>
</div>
@endsection