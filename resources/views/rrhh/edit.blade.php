@extends('layouts.app')

@section('title', 'Editar Personal')

@section('content')
<div class="max-w-4xl mx-auto py-8">
  <h2 class="text-2xl font-bold mb-6 text-center">Editar Personal</h2>

  <form action="{{ route('rrhh.update', $rrhh->id_personal) }}" method="POST" 
        class="bg-white p-6 rounded-lg shadow-md">
    @csrf
    @method('PUT')

    @include('rrhh.form')

    <div class="mt-6 flex justify-end gap-4">
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Actualizar
      </button>
      <a href="{{ route('rrhh.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
        Cancelar
      </a>
    </div>
  </form>
</div>
@endsection