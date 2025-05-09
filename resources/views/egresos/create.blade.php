@extends('layouts.app')

@section('title', 'Registrar egreso')

@section('content')
  <h2 class="text-xl font-bold mb-4">Nuevo egreso</h2>

  <form action="{{ route('egresos.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
      <label class="block text-sm font-semibold">Fecha</label>
      <input type="date" name="fecha" value="{{ old('fecha') }}" class="w-full border px-3 py-2 rounded" required>
    </div>

    <div>
      <label class="block text-sm font-semibold">Monto (Bs.)</label>
      <input type="number" step="0.01" name="monto" value="{{ old('monto') }}" class="w-full border px-3 py-2 rounded" required>
    </div>

    <div>
      <label class="block text-sm font-semibold">Descripción</label>
      <textarea name="descripcion" class="w-full border px-3 py-2 rounded">{{ old('descripcion') }}</textarea>
    </div>

    <div>
      <label class="block text-sm font-semibold">Categoría</label>
      <input type="text" name="categoria" value="{{ old('categoria') }}" class="w-full border px-3 py-2 rounded">
    </div>

    <div>
      <label class="block text-sm font-semibold">ID usuario que autorizó (opcional)</label>
      <input type="number" name="id_usuario_autorizador" value="{{ old('id_usuario_autorizador') }}" class="w-full border px-3 py-2 rounded">
    </div>

    <div class="flex gap-2">
      <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Guardar</button>
      <a href="{{ route('egresos.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cancelar</a>
    </div>
  </form>
@endsection
