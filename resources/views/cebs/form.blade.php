<form method="POST" action="{{ isset($ceb) ? route('cebs.update', $ceb->id_ceb) : route('cebs.store') }}">
  @csrf
  @if(isset($ceb))
      @method('PUT')
  @endif

  <div class="mb-4">
      <label class="block text-sm font-semibold mb-2">Nombres *</label>
      <input type="text" name="nombres_ceb" 
             value="{{ old('nombres_ceb', $ceb->nombres_ceb ?? '') }}" 
             class="w-full border px-3 py-2 rounded" required>
  </div>

  <div class="mb-4">
      <label class="block text-sm font-semibold mb-2">Apellido Paterno</label>
      <input type="text" name="apellido_pat_ceb" 
             value="{{ old('apellido_pat_ceb', $ceb->apellido_pat_ceb ?? '') }}" 
             class="w-full border px-3 py-2 rounded">
  </div>

  <div class="mb-4">
      <label class="block text-sm font-semibold mb-2">Apellido Materno</label>
      <input type="text" name="apellido_mat_ceb" 
             value="{{ old('apellido_mat_ceb', $ceb->apellido_mat_ceb ?? '') }}" 
             class="w-full border px-3 py-2 rounded">
  </div>

  <div class="mb-4">
      <label class="block text-sm font-semibold mb-2">Nombre de la CEB *</label>
      <input type="text" name="ceb" 
             value="{{ old('ceb', $ceb->ceb ?? '') }}" 
             class="w-full border px-3 py-2 rounded" required>
  </div>

  <div class="mb-4">
      <label class="block text-sm font-semibold mb-2">¿Es Responsable? *</label>
      <select name="responsable" class="w-full border px-3 py-2 rounded" required>
        <option value="SI" {{ (old('responsable', $ceb->responsable ?? '') == 'SI' ? 'selected' : '') }}>Sí</option>
        <option value="NO" {{ (old('responsable', $ceb->responsable ?? '') == 'NO' ? 'selected' : '') }}>No</option>
      </select>
  </div>

  <div class="mb-4">
      <label class="block text-sm font-semibold mb-2">Teléfono</label>
      <input type="text" name="telefono" 
             value="{{ old('telefono', $ceb->telefono ?? '') }}" 
             class="w-full border px-3 py-2 rounded">
  </div>

  <div class="mt-6">
      <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          {{ isset($ceb) ? 'Actualizar' : 'Guardar' }}
      </button>
  </div>
</form> 