@extends('layouts.app')

@section('title', 'Editar ingreso')

@section('content')
  <h2 class="text-xl font-bold mb-4">Editar ingreso</h2>

  <form action="{{ route('ingresos.update', $ingreso) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-sm font-semibold">Fecha</label>
      <input type="date" name="fecha" value="{{ old('fecha', $ingreso->fecha) }}" class="w-full border px-3 py-2 rounded" required>
    </div>

    <div>
      <label class="block text-sm font-semibold">Monto (Bs.)</label>
      <input type="number" step="0.01" name="monto" value="{{ old('monto', $ingreso->monto) }}" class="w-full border px-3 py-2 rounded" required>
    </div>

    <div>
      <label class="block text-sm font-semibold">Descripción</label>
      <textarea name="descripcion" class="w-full border px-3 py-2 rounded">{{ old('descripcion', $ingreso->descripcion) }}</textarea>
    </div>

    <div>
      <label class="block text-sm font-semibold">Tipo de ingreso</label>
      <select name="tipo_ingreso" class="w-full border px-3 py-2 rounded" required>
        @foreach(['donación', 'misa', 'sacramento', 'otro'] as $tipo)
          <option value="{{ $tipo }}" {{ old('tipo_ingreso', $ingreso->tipo_ingreso) == $tipo ? 'selected' : '' }}>
            {{ ucfirst($tipo) }}
          </option>
        @endforeach
      </select>
    </div>


    <div class="flex gap-2">
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Actualizar</button>
      <a href="{{ route('ingresos.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cancelar</a>
    </div>
  </form>
@endsection
