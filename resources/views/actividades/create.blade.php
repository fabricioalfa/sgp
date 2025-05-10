@extends('layouts.app')

@section('title', 'Registrar Actividad')

@section('content')
  <h2 class="text-xl font-bold mb-4">Registrar nueva actividad</h2>

  <form action="{{ route('actividades.store') }}" method="POST" class="space-y-6">
    @csrf

    <div>
      <label class="block text-sm font-medium mb-1">Título</label>
      <input type="text" name="titulo" value="{{ old('titulo') }}" required class="w-full border rounded px-3 py-2">
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Descripción</label>
      <textarea name="descripcion" class="w-full border rounded px-3 py-2">{{ old('descripcion') }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Fecha de Inicio</label>
        <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Fecha de Fin</label>
        <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}" required class="w-full border rounded px-3 py-2">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Responsable</label>
      <input type="text" name="responsable" value="{{ old('responsable') }}" required class="w-full border rounded px-3 py-2">
    </div>

    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Registrar Actividad</button>
  </form>
@endsection