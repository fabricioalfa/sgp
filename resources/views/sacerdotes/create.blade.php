@extends('layouts.app')

@section('title', 'Nuevo Sacerdote')

@section('content')
  <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Registrar Sacerdote</h2>
    <form action="{{ route('sacerdotes.store') }}" method="POST" class="space-y-4">
      @csrf
      @include('sacerdotes.form')
      <div class="flex justify-between">
        <a href="{{ route('sacerdotes.index') }}" class="text-blue-600 hover:underline">Cancelar</a>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Guardar</button>
      </div>
    </form>
  </div>
@endsection
