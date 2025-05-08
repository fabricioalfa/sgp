@extends('layouts.app')

@section('title', 'Nueva Misa')

@section('content')
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Registrar nueva misa</h2>
    <form action="{{ route('misas.store') }}" method="POST" class="space-y-4">
      @csrf
      @include('misas.form')
      <div class="flex justify-between">
        <a href="{{ route('misas.index') }}" class="text-blue-600 hover:underline">Cancelar</a>
        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Guardar</button>
      </div>
    </form>
  </div>
@endsection
