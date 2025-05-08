@extends('layouts.app')

@section('title', 'Registrar Personal')

@section('content')
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Nuevo Personal</h2>
    <form action="{{ route('rrhh.store') }}" method="POST" class="space-y-4">
      @csrf
      @include('rrhh.form')
      <div class="flex justify-between">
        <a href="{{ route('rrhh.index') }}" class="text-blue-600 hover:underline">Cancelar</a>
        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Guardar</button>
      </div>
    </form>
  </div>
@endsection
