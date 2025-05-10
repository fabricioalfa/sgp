@extends('layouts.app')

@section('title', 'Editar Actividad')

@section('content')
  <h2 class="text-xl font-bold mb-4">Editar actividad</h2>

  <form action="{{ route('actividades.update', ['actividad' => $actividad->id_actividad]) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-sm font-medium mb-1">Título</label>
      <input type="text" name="titulo" value="{{ old('titulo', $actividad->titulo) }}" required class="w-full border rounded px-3 py-2">
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Descripción</label>
      <textarea name="descripcion" class="w-full border rounded px-3 py-2">{{ old('descripcion', $actividad->descripcion) }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Fecha de Inicio</label>
        <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $actividad->fecha_inicio) }}" required class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Fecha de Fin</label>
        <input type="date" name="fecha_fin" value="{{ old('fecha_fin', $actividad->fecha_fin) }}" required class="w-full border rounded px-3 py-2">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Responsable</label>
      <input type="text" name="responsable" value="{{ old('responsable', $actividad->responsable) }}" required class="w-full border rounded px-3 py-2">
    </div>

    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Actualizar Actividad</button>
  </form>
@endsection