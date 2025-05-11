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

<div>
  <label class="block text-sm font-semibold">Fecha</label>
  <input 
    type="date" 
    name="fecha" 
    value="{{ old('fecha', $misa->fecha ?? '') }}" 
    class="w-full border px-3 py-2 rounded @error('fecha') border-red-500 @enderror" 
    required
  >
  @error('fecha')
    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
  @enderror
</div>

<div class="mt-4">
  <label class="block text-sm font-semibold">Hora</label>
  <input 
    type="time" 
    name="hora" 
    value="{{ old('hora', $misa->hora ?? '') }}" 
    class="w-full border px-3 py-2 rounded @error('hora') border-red-500 @enderror" 
    required
  >
  @error('hora')
    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
  @enderror
</div>

<div class="mt-4">
  <label class="block text-sm font-semibold">Tipo de Misa</label>
  <select 
    name="tipo_misa" 
    id="tipo_misa" 
    class="w-full border px-3 py-2 rounded" 
    required 
    onchange="asignarEstipendio()"
  >
    <option value="">-- Seleccione --</option>
    @foreach($tiposMisa as $tipo => $monto)
      <option value="{{ $tipo }}" {{ old('tipo_misa', $misa->tipo_misa ?? '') === $tipo ? 'selected' : '' }}>
        {{ $tipo }}
      </option>
    @endforeach
  </select>
</div>

<div class="mt-4">
  <label class="block text-sm font-semibold">Sacerdote</label>
  <select 
    name="id_sacerdote" 
    class="w-full border px-3 py-2 rounded"
  >
    <option value="">-- Sin asignar --</option>
    @foreach($sacerdotes as $sacerdote)
      <option 
        value="{{ $sacerdote->id_sacerdote }}" 
        {{ old('id_sacerdote', $misa->id_sacerdote ?? '') == $sacerdote->id_sacerdote ? 'selected' : '' }}
      >
        {{ $sacerdote->nombres }} {{ $sacerdote->apellido_paterno }} {{ $sacerdote->apellido_materno }}
      </option>
    @endforeach
  </select>
</div>

<div class="mt-4">
  <label class="block text-sm font-semibold">Intención</label>
  <textarea 
    name="intencion" 
    class="w-full border px-3 py-2 rounded"
  >{{ old('intencion', $misa->intencion ?? '') }}</textarea>
</div>

<div class="mt-4">
  <label class="block text-sm font-semibold">Observaciones</label>
  <textarea 
    name="observaciones" 
    class="w-full border px-3 py-2 rounded"
  >{{ old('observaciones', $misa->observaciones ?? '') }}</textarea>
</div>

<div class="mt-4">
  <label class="block text-sm font-semibold">Estipendio (Bs.)</label>
  <input 
    type="text" 
    id="estipendio" 
    name="estipendio" 
    value="{{ old('estipendio', $misa->estipendio ?? '') }}" 
    class="w-full border px-3 py-2 rounded bg-gray-100" 
    readonly
  >
</div>

<div class="mt-4">
  <label class="block text-sm font-semibold">Estado</label>
  <select 
    name="estado" 
    class="w-full border px-3 py-2 rounded" 
    required
  >
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