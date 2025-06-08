{{-- resources/views/rrhh/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Registrar Personal RRHH')

@section('content')
  <div class="max-w-2xl mx-auto mt-10 bg-white/60 p-8 rounded-xl shadow">
    <h2 class="text-2xl font-bold text-[#C1440E] mb-6">Registrar Nuevo Personal</h2>
    <form action="{{ route('rrhh.store') }}" method="POST" class="space-y-6">
      @csrf
      @include('rrhh.form')
      <div class="flex justify-end gap-4">
        <a href="{{ route('rrhh.index') }}"
           class="px-6 py-2 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 transition">
          Cancelar
        </a>
        <button type="submit"
                class="bg-[#E9A209] text-white px-6 py-2 rounded-xl shadow hover:bg-[#c98b07] transition">
          Guardar
        </button>
      </div>
    </form>
  </div>
@endsection
