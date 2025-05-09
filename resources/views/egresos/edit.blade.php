@extends('layouts.app')

@section('title', 'Editar egreso')

@section('content')
  <h2 class="text-xl font-bold mb-4">Editar egreso</h2>

  <form action="{{ route('egresos.update', $egreso) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-sm font-semibold">Fecha</label>
      <input type="date" name="fecha" value="{{ old('fecha', $egreso->fecha) }}" class="w-full border px-3 py-2 rounded" required>
    </div>

    <div>
      <label class="block text-sm font-semibold">Monto (Bs.)</label>
      <input type="number" step="0.01" name="monto" value="{{ old('monto', $egreso->monto) }}" class="w-full border px-3 py-2 rounded" required>
    </div>

    <div>
      <label class="block text-sm font-semibold">Descripción</label>
      <textarea name="descripcion" class="w-full border px-3 py-2 rounded">{{ old('descripcion', $egreso->descripcion) }}</textarea>
    </div>

    <div>
      <label class="block text-sm font-semibold">Categoría</label>
      <input type="text" name="categoria" value="{{ old('categoria', $egreso->categoria) }}" class="w-full border px-3 py-2 rounded">
    </div>

    <div class="flex gap-2">
      <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Actualizar</button>
      <a href="{{ route('egresos.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cancelar</a>
    </div>
  </form>
@endsection
