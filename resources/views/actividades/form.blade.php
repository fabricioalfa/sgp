{{-- Campo: Título --}}
<div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Título</label>
    <input type="text" name="titulo" maxlength="255"
           value="{{ old('titulo', $actividad->titulo ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                  focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
    @error('titulo')
      <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>
  
  {{-- Campo: Descripción --}}
  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Descripción</label>
    <textarea name="descripcion"
              class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                     focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">{{ old('descripcion', $actividad->descripcion ?? '') }}</textarea>
    @error('descripcion')
      <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>
  
  {{-- Campo: Fechas --}}
  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-semibold text-[#C1440E] mb-1">Fecha de Inicio</label>
      <input type="date" name="fecha_inicio"
             value="{{ old('fecha_inicio', $actividad->fecha_inicio ?? '') }}"
             class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                    focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
      @error('fecha_inicio')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>
  
    <div>
      <label class="block text-sm font-semibold text-[#C1440E] mb-1">Fecha de Fin</label>
      <input type="date" name="fecha_fin"
             value="{{ old('fecha_fin', $actividad->fecha_fin ?? '') }}"
             class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                    focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
      @error('fecha_fin')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>
  </div>
  
  {{-- Campo: Responsable --}}
  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Responsable</label>
    <input type="text" name="responsable" maxlength="255"
           value="{{ old('responsable', $actividad->responsable ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                  focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
    @error('responsable')
      <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>
  