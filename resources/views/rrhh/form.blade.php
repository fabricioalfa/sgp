<div>
    <label class="block text-sm font-semibold">Nombres</label>
    <input type="text" name="nombres" value="{{ old('nombres', $rrhh->nombres ?? '') }}" required class="w-full border px-3 py-2 rounded">
  </div>
  
  <div>
    <label class="block text-sm font-semibold">Apellido Paterno</label>
    <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $rrhh->apellido_paterno ?? '') }}" required class="w-full border px-3 py-2 rounded">
  </div>
  
  <div>
    <label class="block text-sm font-semibold">Apellido Materno</label>
    <input type="text" name="apellido_materno" value="{{ old('apellido_materno', $rrhh->apellido_materno ?? '') }}" required class="w-full border px-3 py-2 rounded">
  </div>
  
  <div>
    <label class="block text-sm font-semibold">Cargo</label>
    <input type="text" name="cargo" value="{{ old('cargo', $rrhh->cargo ?? '') }}" required class="w-full border px-3 py-2 rounded">
  </div>
  
  <div>
    <label class="block text-sm font-semibold">Fecha de Ingreso</label>
    <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso', $rrhh->fecha_ingreso ?? '') }}" required class="w-full border px-3 py-2 rounded">
  </div>
  
  <div>
    <label class="block text-sm font-semibold">Fecha de Fin</label>
    <input type="date" name="fecha_fin" value="{{ old('fecha_fin', $rrhh->fecha_fin ?? '') }}" class="w-full border px-3 py-2 rounded">
  </div>
  
  <div>
    <label class="block text-sm font-semibold">Teléfono</label>
    <input type="text" name="telefono" value="{{ old('telefono', $rrhh->telefono ?? '') }}" class="w-full border px-3 py-2 rounded">
  </div>
  
  <div>
    <label class="block text-sm font-semibold">Dirección</label>
    <input type="text" name="direccion" value="{{ old('direccion', $rrhh->direccion ?? '') }}" class="w-full border px-3 py-2 rounded">
  </div>
  
  <div>
    <label class="block text-sm font-semibold">Sueldo</label>
    <input type="number" step="0.01" name="sueldo" value="{{ old('sueldo', $rrhh->sueldo ?? '') }}" class="w-full border px-3 py-2 rounded">
  </div>
  
  <div>
    <label class="block text-sm font-semibold">Estado</label>
    <select name="estado" class="w-full border px-3 py-2 rounded">
      <option value="activo" {{ old('estado', $rrhh->estado ?? '') == 'activo' ? 'selected' : '' }}>Activo</option>
      <option value="inactivo" {{ old('estado', $rrhh->estado ?? '') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
    </select>
  </div>
  
  <div>
    <label class="block text-sm font-semibold">Observaciones</label>
    <textarea name="observaciones" class="w-full border px-3 py-2 rounded">{{ old('observaciones', $rrhh->observaciones ?? '') }}</textarea>
  </div>
  