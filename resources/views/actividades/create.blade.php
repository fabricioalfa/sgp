@extends('layouts.app')

@section('title', 'Registrar Actividad')

@section('content')
  <div class="overflow-auto max-h-[80vh] bg-white/60 p-6 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-[#C1440E] mb-4">Registrar nueva actividad</h2>
    <form action="{{ route('actividades.store') }}" method="POST" class="space-y-5">
      @csrf
      @include('actividades.form')
      <div class="flex justify-between items-center pt-4">
        <a href="{{ route('actividades.index') }}"
           class="px-4 py-2 border border-[#C1440E] text-[#C1440E] rounded-lg hover:bg-[#f9e5dd] transition">
          Cancelar
        </a>
        <button type="submit"
                class="bg-[#E9A209] hover:bg-[#c98b07] text-white font-semibold px-5 py-2 rounded-lg shadow transition">
          Registrar
        </button>
      </div>
    </form>
  </div>
@endsection
