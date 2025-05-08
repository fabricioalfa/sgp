@extends('layouts.app')

@section('title', 'Registrar Bautizo')

@section('content')
  <h2 class="text-2xl font-bold mb-6">Registrar Bautizo</h2>

  <form action="{{ route('bautizos.store') }}" method="POST">
    @csrf
    @include('bautizos.form')
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
  </form>
@endsection
