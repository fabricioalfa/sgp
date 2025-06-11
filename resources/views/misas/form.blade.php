@php
  $tiposMisa = [
    'MISA DE DIFUNTOS COMUNITARIAS'      => 20,
    'MISA DE CUERPO PRESENTE'            => 100,
    'MISA DE SALUD'                      => 100,
    'MISA DE ALMA'                       => 100,
    'MISA DE DEVOCION'                   => 350,
    'MISA DE FIESTA (preste folclorico)' => 500,
    'MISA DE ANIVERSARIO MATRIMONIAL'    => 200,
  ];
   $latitudPredeterminada = -16.513212;
  $longitudPredeterminada = -68.127465;

  $latitud = old('latitud', $misa->latitud ?? $latitudPredeterminada);
  $longitud = old('longitud', $misa->longitud ?? $longitudPredeterminada);

@endphp
@include('components.scripts.misas-map')

{{-- Fecha --}}
<div>
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Fecha</label>
  <input type="date" name="fecha" value="{{ old('fecha', $misa->fecha ?? '') }}"
         class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
  @error('fecha') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

{{-- Hora --}}
<div class="mt-4">
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Hora</label>
  <input type="time" name="hora" value="{{ old('hora', isset($misa->hora) ? \Carbon\Carbon::parse($misa->hora)->format('H:i') : '') }}"
         class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
  @error('hora') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
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
      <option value="{{ $tipo }}" {{ old('tipo_misa', $misa->tipo_misa ?? '') === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
    @endforeach
  </select>
  @error('tipo_misa') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
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
  @error('id_sacerdote') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

{{-- Lugar --}}
<div class="mt-4">
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Lugar (nombre del sitio)</label>
  <input type="text" name="lugar"
         value="{{ old('lugar', $misa->lugar ?? 'Parroquia Montículo') }}"
         placeholder="Ej: Capilla San Pedro"
         class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
  @error('lugar') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>


{{-- Seleccionar ubicación en el mapa --}}
<div class="mt-4">
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Selecciona el lugar en el mapa</label>
  <div id="map" class="rounded-xl border border-gray-300" style="height: 300px;"></div>
</div>

{{-- Coordenadas GPS --}}
<div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Latitud</label>
    <input type="text" name="latitud" id="latitud"
           value="{{ $latitud }}"
           readonly
           class="w-full border rounded-xl px-4 py-2 bg-gray-100 text-[#573830]">
    @error('latitud') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>
  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Longitud</label>
    <input type="text" name="longitud" id="longitud"
           value="{{ $longitud }}"
           readonly
           class="w-full border rounded-xl px-4 py-2 bg-gray-100 text-[#573830]">
    @error('longitud') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>
</div>


{{-- Intención --}}
<div class="mt-4">
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Intención</label>
  <textarea name="intencion"
            class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                   focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">{{ old('intencion', $misa->intencion ?? '') }}</textarea>
  @error('intencion') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

{{-- Observaciones --}}
<div class="mt-4">
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Observaciones</label>
  <textarea name="observaciones"
            class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                   focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">{{ old('observaciones', $misa->observaciones ?? '') }}</textarea>
  @error('observaciones') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
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
    <option value="programada" {{ old('estado', $misa->estado ?? '') == 'programada' ? 'selected' : '' }}>Programada</option>
    <option value="celebrada"  {{ old('estado', $misa->estado ?? '') == 'celebrada' ? 'selected' : '' }}>Celebrada</option>
    <option value="cancelada"  {{ old('estado', $misa->estado ?? '') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
  </select>
  @error('estado') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

{{-- Fiel solicitante --}}
<hr class="my-6 border-t border-gray-300">
<h3 class="text-lg font-bold text-[#C1440E] mb-4">Datos del solicitante (fiel creyente)</h3>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Nombres</label>
    <input type="text" name="fiel_nombres" value="{{ old('fiel_nombres', $misa->creyente->nombres ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
    @error('fiel_nombres') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>
  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Apellido Paterno</label>
    <input type="text" name="fiel_apellido_paterno" value="{{ old('fiel_apellido_paterno', $misa->creyente->apellido_paterno ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
    @error('fiel_apellido_paterno') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Apellido Materno</label>
    <input type="text" name="fiel_apellido_materno" value="{{ old('fiel_apellido_materno', $misa->creyente->apellido_materno ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
    @error('fiel_apellido_materno') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>
  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Correo electrónico</label>
    <input type="email" name="fiel_correo" value="{{ old('fiel_correo', $misa->creyente->correo_electronico ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
    @error('fiel_correo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>
</div>

<div class="mt-4">
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Teléfono</label>
  <input type="text" name="fiel_telefono" value="{{ old('fiel_telefono', $misa->creyente->telefono ?? '') }}"
         class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
  @error('fiel_telefono') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>
