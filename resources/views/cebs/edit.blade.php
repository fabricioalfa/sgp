@extends('layouts.app')

@section('title', 'Editar CEB')

@section('content')
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Editar CEB</h2>
    <form action="{{ route('cebs.update', $ceb) }}" method="POST" class="space-y-4">
      @csrf @method('PUT')
      @include('cebs.form')
      <div class="flex justify-between">
        <a href="{{ route('cebs.index') }}" class="text-blue-600 hover:underline">Cancelar</a>
        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Actualizar</button>
      </div>
    </form>
  </div>
@endsection
