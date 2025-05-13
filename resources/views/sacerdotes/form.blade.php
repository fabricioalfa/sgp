{{-- Campo: Nombres --}}
<div>
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Nombres</label>
  <input type="text" name="nombres" pattern="[A-Za-zÀ-ÿ\s]+" title="Solo letras y espacios"
         value="{{ old('nombres', $sacerdote->nombres ?? '') }}"
         class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] placeholder-gray-500
                focus:outline-none focus:ring-2
                {{ $errors->has('nombres') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#F4A261]' }}">
  @error('nombres')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>

{{-- Campo: Apellido Paterno --}}
<div>
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Apellido Paterno</label>
  <input type="text" name="apellido_paterno" pattern="[A-Za-zÀ-ÿ\s]+" title="Solo letras y espacios"
         value="{{ old('apellido_paterno', $sacerdote->apellido_paterno ?? '') }}"
         class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] placeholder-gray-500
                focus:outline-none focus:ring-2
                {{ $errors->has('apellido_paterno') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#F4A261]' }}">
  @error('apellido_paterno')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>

{{-- Campo: Apellido Materno --}}
<div>
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Apellido Materno</label>
  <input type="text" name="apellido_materno" pattern="[A-Za-zÀ-ÿ\s]+" title="Solo letras y espacios"
         value="{{ old('apellido_materno', $sacerdote->apellido_materno ?? '') }}"
         class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] placeholder-gray-500
                focus:outline-none focus:ring-2
                {{ $errors->has('apellido_materno') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#F4A261]' }}">
  @error('apellido_materno')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>

{{-- Campo: Teléfono --}}
<div>
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Teléfono</label>
  <input type="tel" name="telefono" pattern="[0-9]{6,}" title="Solo números, mínimo 6 dígitos"
         value="{{ old('telefono', $sacerdote->telefono ?? '') }}"
         class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] placeholder-gray-500
                focus:outline-none focus:ring-2
                {{ $errors->has('telefono') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#F4A261]' }}">
  @error('telefono')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>

{{-- Campo: Fecha de Ordenación --}}
<div>
  <label class="block text-sm font-semibold text-[#C1440E] mb-1">Fecha de Ordenación</label>
  <input type="date" name="fecha_ordenacion"
         value="{{ old('fecha_ordenacion', $sacerdote->fecha_ordenacion ?? '') }}"
         class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                focus:outline-none focus:ring-2
                {{ $errors->has('fecha_ordenacion') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#F4A261]' }}">
  @error('fecha_ordenacion')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>
