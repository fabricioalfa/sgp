@extends('layouts.app')

@section('title', 'Registrar ingreso')

@section('content')
  <h2 class="text-xl font-bold mb-4">Nuevo ingreso</h2>

  <form action="{{ route('ingresos.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
      <label class="block text-sm font-semibold">Fecha</label>
      <input type="date" name="fecha" value="{{ old('fecha') }}" class="w-full border px-3 py-2 rounded" required>
      @error('fecha')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label class="block text-sm font-semibold">Monto (Bs.)</label>
      <input type="number" step="0.01" name="monto" value="{{ old('monto') }}" class="w-full border px-3 py-2 rounded" required>
      @error('monto')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label class="block text-sm font-semibold">Descripción</label>
      <textarea name="descripcion" class="w-full border px-3 py-2 rounded">{{ old('descripcion') }}</textarea>
      @error('descripcion')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label class="block text-sm font-semibold">Tipo de ingreso</label>
      <select name="tipo_ingreso" class="w-full border px-3 py-2 rounded" required>
        <option value="">-- Seleccione --</option>
        @foreach(['donación', 'otro'] as $tipo)
          <option value="{{ $tipo }}" {{ old('tipo_ingreso') == $tipo ? 'selected' : '' }}>
            {{ ucfirst($tipo) }}
          </option>
        @endforeach
      </select>
      @error('tipo_ingreso')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="flex gap-2">
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Guardar</button>
      <a href="{{ route('ingresos.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cancelar</a>
    </div>
  </form>
@endsection
