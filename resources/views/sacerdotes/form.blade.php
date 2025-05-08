<div>
    <label class="block text-sm font-semibold">Nombres</label>
    <input type="text" name="nombres" value="{{ old('nombres', $sacerdote->nombres ?? '') }}" required class="w-full border px-3 py-2 rounded">
  </div>
  <div>
    <label class="block text-sm font-semibold">Apellido Paterno</label>
    <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $sacerdote->apellido_paterno ?? '') }}" required class="w-full border px-3 py-2 rounded">
  </div>
  <div>
    <label class="block text-sm font-semibold">Apellido Materno</label>
    <input type="text" name="apellido_materno" value="{{ old('apellido_materno', $sacerdote->apellido_materno ?? '') }}" required class="w-full border px-3 py-2 rounded">
  </div>
  <div>
    <label class="block text-sm font-semibold">Teléfono</label>
    <input type="text" name="telefono" value="{{ old('telefono', $sacerdote->telefono ?? '') }}" class="w-full border px-3 py-2 rounded">
  </div>
  <div>
    <label class="block text-sm font-semibold">Fecha de Ordenación</label>
    <input type="date" name="fecha_ordenacion" value="{{ old('fecha_ordenacion', $sacerdote->fecha_ordenacion ?? '') }}" class="w-full border px-3 py-2 rounded">
  </div>
  