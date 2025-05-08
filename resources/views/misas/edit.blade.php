@extends('layouts.app')

@section('title', 'Editar Misa')

@section('content')
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Editar misa</h2>
    <form action="{{ route('misas.update', $misa) }}" method="POST" class="space-y-4">
      @csrf @method('PUT')
      @include('misas.form')
      <div class="flex justify-between">
        <a href="{{ route('misas.index') }}" class="text-blue-600 hover:underline">Cancelar</a>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
      </div>
    </form>
  </div>
@endsection
