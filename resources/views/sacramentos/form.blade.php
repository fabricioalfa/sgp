@php
  $tipos = [
    'bautizo' => 'Bautizo', 
    'comunion' => 'Primera Comunión', 
    'confirmacion' => 'Confirmación', 
    'matrimonio' => 'Matrimonio'
  ];
@endphp

@extends('layouts.app')

@section('title', 'Registrar Sacramento')

@section('content')
<div class="max-w-7xl mx-auto py-8">
  <div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Registro de Sacramento</h2>

    <form action="{{ route('sacramentos.store') }}" method="POST" class="space-y-4">
      @csrf

      <!-- Campos comunes -->
      <div class="grid grid-cols-2 gap-4">
        <!-- Tipo de sacramento -->
        <div>
          <label class="block text-sm font-medium mb-1">Tipo de Sacramento <span class="text-red-500">*</span></label>
          <select name="tipo_sacramento" id="tipo_sacramento" required onchange="mostrarCamposEspecificos()"
                  class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
            <option value="">-- Seleccione --</option>
            @foreach($tipos as $key => $label)
              <option value="{{ $key }}" {{ old('tipo_sacramento') == $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Fecha <span class="text-red-500">*</span></label>
          <input type="date" name="fecha" value="{{ old('fecha') }}" required
                 class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Hora <span class="text-red-500">*</span></label>
          <input type="time" name="hora" value="{{ old('hora') }}" required
                 class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Lugar <span class="text-red-500">*</span></label>
          <input type="text" name="lugar" value="{{ old('lugar') }}" required
                 class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
        </div>
      </div>

      <!-- Información del Receptor -->
      <div class="space-y-4 border-t pt-4">
        <h3 class="font-medium text-lg mb-4">Información del Receptor <span class="text-red-500">*</span></h3>
        
        <div class="grid grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Nombres</label>
            <input type="text" name="nombre_receptor" value="{{ old('nombre_receptor') }}" required
                   class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
          </div>
          
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
            <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required
                   class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
          </div>
          
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Materno</label>
            <input type="text" name="apellido_materno" value="{{ old('apellido_materno') }}"
                   class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Fecha de Nacimiento <span class="text-red-500">*</span></label>
            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required
                   class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
          </div>
          
          <div>
            <label class="block text-sm font-medium mb-1">Sexo <span class="text-red-500">*</span></label>
            <select name="sexo" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
              <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
              <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Campos específicos -->
      <div id="campos_especificos" class="space-y-4 border-t pt-4">
        <!-- Bautizo -->
        <div id="bautizo_fields" class="sacramento-fields hidden">
          @include('sacramentos.partials.bautizo-fields')
        </div>

        <!-- Matrimonio -->
        <div id="matrimonio_fields" class="sacramento-fields hidden">
          @include('sacramentos.partials.matrimonio-fields')
        </div>

        <!-- Primera Comunión -->
        <div id="comunion_fields" class="sacramento-fields hidden">
          @include('sacramentos.partials.comunion-fields')
        </div>

        <!-- Confirmación -->
        <div id="confirmacion_fields" class="sacramento-fields hidden">
          @include('sacramentos.partials.confirmacion-fields')
        </div>
      </div>

      <!-- Usuario registro -->
      <input type="hidden" name="id_usuario_registro" value="{{ session('usuario')->id_usuario }}">

      <!-- Botones -->
      <div class="pt-4 flex justify-end gap-3">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition-colors">
          Guardar
        </button>
        <a href="{{ route('sacramentos.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition-colors">
          Cancelar
        </a>
      </div>
    </form>
  </div>
</div>

<script>
  function mostrarCamposEspecificos() {
    const tipo = document.getElementById('tipo_sacramento').value;
    document.querySelectorAll('.sacramento-fields').forEach(el => el.classList.add('hidden'));
    if(tipo) document.getElementById(`${tipo}_fields`).classList.remove('hidden');
  }

  window.addEventListener('DOMContentLoaded', () => {
    @if($errors->any())
      mostrarCamposEspecificos();
      document.getElementById('tipo_sacramento').dispatchEvent(new Event('change'));
    @endif
  });
</script>
@endsection