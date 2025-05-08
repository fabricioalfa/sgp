@extends('layouts.app')

@section('title', 'Editar Sacerdote')

@section('content')
  <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Editar Sacerdote</h2>
    <form action="{{ route('sacerdotes.update', $sacerdote) }}" method="POST" class="space-y-4">
      @csrf @method('PUT')
      @include('sacerdotes.form')
      <div class="flex justify-between">
        <a href="{{ route('sacerdotes.index') }}" class="text-blue-600 hover:underline">Cancelar</a>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Actualizar</button>
      </div>
    </form>
  </div>
@endsection
