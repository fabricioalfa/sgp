@php
  $tiposMisa = [
    'MISA DE DIFUNTOS COMUNITARIAS'      => 20,
    'MISA DE CUERPO PRESENTE'            => 100,
    'MISA DE SALUD Y OTRAS PETICIONES'   => 100,
    'MISA DE DEVOCION'                   => 350,
    'MISA DE FIESTA (preste folclorico)' => 500,
    'MISA DE ANIVERSARIO MATRIMONIAL'    => 200,
  ];
@endphp

{{-- Fecha --}}
<div>
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Fecha</label>
  <input type="date" name="fecha"
         value="{{ old('fecha', $misa->fecha ?? '') }}"
         class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
  @error('fecha')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>

{{-- Hora --}}
<div class="mt-4">
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Hora</label>
  <input type="time" name="hora"
         value="{{ old('hora', $misa->hora ?? '') }}"
         class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
  @error('hora')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>

{{-- Tipo de misa --}}
<div class="mt-4">
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Tipo de Misa</label>
  <select name="tipo_misa" id="tipo_misa"
          class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                 focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]"
          onchange="asignarEstipendio()">
    <option value="">-- Seleccione --</option>
    @foreach($tiposMisa as $tipo => $monto)
      <option value="{{ $tipo }}" {{ old('tipo_misa', $misa->tipo_misa ?? '') === $tipo ? 'selected' : '' }}>
        {{ $tipo }}
      </option>
    @endforeach
  </select>
  @error('tipo_misa')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>

{{-- Sacerdote --}}
<div class="mt-4">
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Sacerdote</label>
  <select name="id_sacerdote"
          class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                 focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
    <option value="">-- Sin asignar --</option>
    @foreach($sacerdotes as $sacerdote)
      <option value="{{ $sacerdote->id_sacerdote }}"
        {{ old('id_sacerdote', $misa->id_sacerdote ?? '') == $sacerdote->id_sacerdote ? 'selected' : '' }}>
        {{ $sacerdote->nombres }} {{ $sacerdote->apellido_paterno }} {{ $sacerdote->apellido_materno }}
      </option>
    @endforeach
  </select>
  @error('id_sacerdote')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>

{{-- Intención --}}
<div class="mt-4">
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Intención</label>
  <textarea name="intencion"
            class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                   focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">{{ old('intencion', $misa->intencion ?? '') }}</textarea>
  @error('intencion')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>

{{-- Observaciones --}}
<div class="mt-4">
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Observaciones</label>
  <textarea name="observaciones"
            class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                   focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">{{ old('observaciones', $misa->observaciones ?? '') }}</textarea>
  @error('observaciones')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>

{{-- Estipendio --}}
<div class="mt-4">
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Estipendio (Bs.)</label>
  <input type="text" id="estipendio" name="estipendio"
         value="{{ old('estipendio', $misa->estipendio ?? '') }}"
         class="w-full border rounded-xl px-4 py-2 bg-gray-100 text-[#573830]" readonly>
</div>

{{-- Estado --}}
<div class="mt-4">
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Estado</label>
  <select name="estado"
          class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                 focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
    <option value="programada" {{ old('estado', $misa->estado ?? '') == 'programada' ? 'selected' : '' }}>
      Programada
    </option>
    <option value="celebrada" {{ old('estado', $misa->estado ?? '') == 'celebrada' ? 'selected' : '' }}>
      Celebrada
    </option>
    <option value="cancelada" {{ old('estado', $misa->estado ?? '') == 'cancelada' ? 'selected' : '' }}>
      Cancelada
    </option>
  </select>
  @error('estado')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>

<script>
  function asignarEstipendio() {
    const precios = {
      @foreach($tiposMisa as $tipo => $monto)
        '{{ $tipo }}': {{ $monto }},
      @endforeach
    };
    const tipo = document.getElementById('tipo_misa').value;
    document.getElementById('estipendio').value = precios[tipo] ?? 0;
  }
  window.addEventListener('DOMContentLoaded', asignarEstipendio);
</script>
