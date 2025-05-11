@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-8 p-6 bg-white rounded shadow">
  <h2 class="text-xl font-semibold mb-4">Restablecer contraseña</h2>
  <form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <label class="block mb-2">Correo electrónico</label>
    <input
      type="email"
      name="email"
      value="{{ old('email', $email) }}"
      required
      class="w-full border p-2 mb-4"
    >
    @error('email')
      <p class="text-red-600 text-sm mb-4">{{ $message }}</p>
    @enderror

    <label class="block mb-2">Nueva contraseña</label>
    <input
      type="password"
      name="password"
      required
      class="w-full border p-2 mb-4"
    >
    @error('password')
      <p class="text-red-600 text-sm mb-4">{{ $message }}</p>
    @enderror

    <label class="block mb-2">Confirmar contraseña</label>
    <input
      type="password"
      name="password_confirmation"
      required
      class="w-full border p-2 mb-4"
    >

    <button
      type="submit"
      class="w-full bg-blue-600 text-white p-2 rounded"
    >Restablecer contraseña</button>
  </form>
</div>
@endsection