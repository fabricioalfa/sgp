@extends('layouts.app')

@section('title', 'Recuperar Contraseña')

@section('content')
  <h2 class="text-2xl font-bold mb-4">Recuperar contraseña</h2>

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

  <form action="{{ route('password.email') }}" method="POST" class="space-y-3 max-w-md">
    @csrf

    <input type="email" name="correo_electronico" placeholder="Correo electrónico"
           value="{{ old('correo_electronico') }}" required class="w-full border px-4 py-2 rounded">

    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
      Recuperar contraseña
    </button>
  </form>
@endsection
