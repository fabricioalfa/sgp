@php
  $tipos = [
    'bautizo' => 'Bautizo', 
    'comunion' => 'Primera Comunión', 
    'confirmacion' => 'Confirmación', 
    'matrimonio' => 'Matrimonio'
  ];
@endphp

@extends('layouts.app')

@section('title', 'Registrar Sacramento')

@section('content')
<div class="max-w-7xl mx-auto py-8">
  <div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Registro de Sacramento</h2>

    <form action="{{ route('sacramentos.store') }}" method="POST">
      @csrf
      @include('sacramentos.form')
      
      <div class="pt-4 flex justify-end gap-3">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition-colors">
          Guardar
        </button>
        <a href="{{ route('sacramentos.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition-colors">
          Cancelar
        </a>
      </div>
    </form>
  </div>
</div>
@endsection