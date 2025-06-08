{{-- resources/views/rrhh/form.blade.php --}}
@php /** @var \App\Models\PersonalRrhh|null $rrhh */ @endphp
<div class="space-y-4">
  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Nombres</label>
    <input type="text" name="nombres" required
           value="{{ old('nombres', $rrhh->nombres ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('nombres') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}">
    @error('nombres') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Apellido Paterno</label>
    <input type="text" name="apellido_paterno" required
           value="{{ old('apellido_paterno', $rrhh->apellido_paterno ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('apellido_paterno') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}">
    @error('apellido_paterno') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Apellido Materno</label>
    <input type="text" name="apellido_materno" required
           value="{{ old('apellido_materno', $rrhh->apellido_materno ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('apellido_materno') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}">
    @error('apellido_materno') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Cargo</label>
    <input type="text" name="cargo" required
           value="{{ old('cargo', $rrhh->cargo ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830] focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('cargo') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}">
    @error('cargo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Fecha de Ingreso</label>
    <input type="date" name="fecha_ingreso" required
           value="{{ old('fecha_ingreso', $rrhh->fecha_ingreso ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('fecha_ingreso') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}">
    @error('fecha_ingreso') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Fecha de Fin</label>
    <input type="date" name="fecha_fin"
           value="{{ old('fecha_fin', $rrhh->fecha_fin ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('fecha_fin') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}">
    @error('fecha_fin') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Teléfono</label>
    <input type="text" name="telefono"
           value="{{ old('telefono', $rrhh->telefono ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('telefono') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}">
    @error('telefono') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Dirección</label>
    <input type="text" name="direccion"
           value="{{ old('direccion', $rrhh->direccion ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('direccion') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}">
    @error('direccion') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Sueldo</label>
    <input type="number" step="0.01" name="sueldo"
           value="{{ old('sueldo', $rrhh->sueldo ?? '') }}"
           class="w-full border rounded-xl px-4 py-2 bg-white/80 focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('sueldo') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}">
    @error('sueldo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Estado</label>
    <select name="estado" required
            class="w-full border rounded-xl px-4 py-2 bg-white/80 focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('estado') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}">
      <option value="activo"   {{ old('estado', $rrhh->estado ?? '') == 'activo'   ? 'selected' : '' }}>Activo</option>
      <option value="inactivo" {{ old('estado', $rrhh->estado ?? '') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
    </select>
    @error('estado') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-semibold text-[#C1440E] mb-1">Observaciones</label>
    <textarea name="observaciones"
              class="w-full border rounded-xl px-4 py-2 bg-white/80 focus:outline-none focus:ring-2 focus:ring-[#F4A261] {{ $errors->has('observaciones') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}"
              rows="3">{{ old('observaciones', $rrhh->observaciones ?? '') }}</textarea>
    @error('observaciones') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>
</div>
