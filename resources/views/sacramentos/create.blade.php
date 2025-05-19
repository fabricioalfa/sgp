@extends('layouts.app')

@section('title', 'Registrar Sacramento')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow">
  <h2 class="text-2xl font-bold text-[#C1440E] mb-6">Registrar Sacramento</h2>
  <form method="POST" action="{{ route('sacramentos.store') }}">
    @csrf

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
      <div>
        <label class="text-sm text-gray-700">Tipo de Sacramento</label>
        <select name="tipo_sacramento" class="w-full border rounded-lg px-3 py-2">
          <option value="">Seleccione</option>
          <option value="bautizo">Bautizo</option>
          <option value="comunion">Comunión</option>
          <option value="confirmacion">Confirmación</option>
          <option value="matrimonio">Matrimonio</option>
        </select>
        @error('tipo_sacramento') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="text-sm text-gray-700">Fecha</label>
        <input type="date" name="fecha" class="w-full border rounded-lg px-3 py-2">
        @error('fecha') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="text-sm text-gray-700">Hora</label>
        <input type="time" name="hora" class="w-full border rounded-lg px-3 py-2">
        @error('hora') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="text-sm text-gray-700">Lugar</label>
        <input type="text" name="lugar" class="w-full border rounded-lg px-3 py-2">
        @error('lugar') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="text-sm text-gray-700">Iglesia</label>
        <input type="text" name="iglesia" class="w-full border rounded-lg px-3 py-2">
        @error('iglesia') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="text-sm text-gray-700">Nombre del Receptor</label>
        <input type="text" name="nombre_receptor" class="w-full border rounded-lg px-3 py-2">
        @error('nombre_receptor') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="text-sm text-gray-700">Apellido Paterno</label>
        <input type="text" name="apellido_paterno" class="w-full border rounded-lg px-3 py-2">
        @error('apellido_paterno') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="text-sm text-gray-700">Apellido Materno</label>
        <input type="text" name="apellido_materno" class="w-full border rounded-lg px-3 py-2">
        @error('apellido_materno') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="text-sm text-gray-700">Fecha de Nacimiento</label>
        <input type="date" name="fecha_nacimiento" class="w-full border rounded-lg px-3 py-2">
        @error('fecha_nacimiento') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="text-sm text-gray-700">Sexo</label>
        <select name="sexo" class="w-full border rounded-lg px-3 py-2">
          <option value="">Seleccione</option>
          <option value="M">Masculino</option>
          <option value="F">Femenino</option>
        </select>
        @error('sexo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>
    </div>

    <div class="mt-6 flex justify-between">
      <a href="{{ route('sacramentos.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
        Cancelar
      </a>
      <button type="submit" class="bg-[#E9A209] text-white px-6 py-2 rounded-full shadow hover:bg-[#c98b07] transition">
        Siguiente
      </button>
    </div>
    
  </form>
</div>
@endsection