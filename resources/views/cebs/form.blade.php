{{-- Nombres --}}
<div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Nombres</label>
    <input type="text" name="nombres_ceb" value="{{ old('nombres_ceb', $ceb->nombres_ceb ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                  focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
    @error('nombres_ceb')
      <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>
  
  {{-- Apellido Paterno --}}
  <div class="mt-4">
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Apellido Paterno</label>
    <input type="text" name="apellido_pat_ceb" value="{{ old('apellido_pat_ceb', $ceb->apellido_pat_ceb ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                  focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
    @error('apellido_pat_ceb')
      <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>
  
  {{-- Apellido Materno --}}
  <div class="mt-4">
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Apellido Materno</label>
    <input type="text" name="apellido_mat_ceb" value="{{ old('apellido_mat_ceb', $ceb->apellido_mat_ceb ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                  focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
    @error('apellido_mat_ceb')
      <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>
  
  {{-- Nombre CEB --}}
  <div class="mt-4">
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Nombre de la CEB</label>
    <input type="text" name="ceb" value="{{ old('ceb', $ceb->ceb ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                  focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
    @error('ceb')
      <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>
  
  {{-- Responsable --}}
  <div class="mt-4">
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">¿Es Responsable?</label>
    <select name="responsable"
            class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                   focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
      <option value="SI" {{ old('responsable', $ceb->responsable ?? '') == 'SI' ? 'selected' : '' }}>Sí</option>
      <option value="NO" {{ old('responsable', $ceb->responsable ?? '') == 'NO' ? 'selected' : '' }}>No</option>
    </select>
    @error('responsable')
      <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>
  
  <input type="text" name="telefono"
       pattern="[0-9]{6,20}" title="Solo números, mínimo 6 dígitos"
       value="{{ old('telefono', $ceb->telefono ?? '') }}"
       class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
              focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]">
    @error('telefono')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror

  