@extends('layouts.app')

@section('title', 'Editar Actividad')

@section('content')
  <div class="overflow-auto max-h-[80vh] bg-white/60 p-6 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-[#C1440E] mb-4">Editar actividad</h2>

    <form action="{{ route('actividades.update', ['actividad' => $actividad->id_actividad]) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
      @csrf
      @method('PUT')
      @include('actividades.form')

      <div class="flex justify-between items-center pt-4">
        <a href="{{ route('actividades.index') }}"
           class="px-4 py-2 border border-[#C1440E] text-[#C1440E] rounded-lg hover:bg-[#f9e5dd] transition">
          Cancelar
        </a>
        <button type="submit"
                class="bg-[#E9A209] hover:bg-[#c98b07] text-white font-semibold px-5 py-2 rounded-lg shadow transition">
          Actualizar
        </button>
      </div>
    </form>
  </div>
@endsection
