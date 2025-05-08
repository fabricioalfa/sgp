<!-- Campos comunes a todos los sacramentos -->
<div class="space-y-4">
  <div class="grid grid-cols-2 gap-4">
    <!-- Tipo de sacramento -->
    <div>
      <label class="block text-sm font-medium mb-1">Tipo de Sacramento <span class="text-red-500">*</span></label>
      <select name="tipo_sacramento" id="tipo_sacramento" required onchange="mostrarCamposEspecificos()"
              class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
        <option value="">-- Seleccione --</option>
        @foreach($tipos as $key => $label)
          <option value="{{ $key }}" {{ ($sacramento->tipo_sacramento ?? old('tipo_sacramento')) == $key ? 'selected' : '' }}>
            {{ $label }}
          </option>
        @endforeach
      </select>
    </div>

    <!-- Fecha y Hora -->
    <div>
      <label class="block text-sm font-medium mb-1">Fecha <span class="text-red-500">*</span></label>
      <input type="date" name="fecha" value="{{ old('fecha', $sacramento->fecha ?? '') }}" required
             class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Hora <span class="text-red-500">*</span></label>
      <input type="time" name="hora" value="{{ old('hora', $sacramento->hora ?? '') }}" required
             class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Lugar <span class="text-red-500">*</span></label>
      <input type="text" name="lugar" value="{{ old('lugar', $sacramento->lugar ?? '') }}" required
             class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
             placeholder="Ej: Parroquia San Pedro">
    </div>
  </div>

  <!-- Información del Receptor -->
  <div class="space-y-4 border-t pt-4">
    <h3 class="font-medium text-lg mb-4">Información del Receptor <span class="text-red-500">*</span></h3>
    
    <div class="grid grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Nombres</label>
        <input type="text" name="nombre_receptor" value="{{ old('nombre_receptor', $sacramento->nombre_receptor ?? '') }}" required
               class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
      </div>
      
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
        <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $sacramento->apellido_paterno ?? '') }}" required
               class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
      </div>
      
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Materno</label>
        <input type="text" name="apellido_materno" value="{{ old('apellido_materno', $sacramento->apellido_materno ?? '') }}"
               class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
      </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Fecha de Nacimiento <span class="text-red-500">*</span></label>
        <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $sacramento->fecha_nacimiento ?? '') }}" required
               class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
      </div>
      
      <div>
        <label class="block text-sm font-medium mb-1">Sexo <span class="text-red-500">*</span></label>
        <select name="sexo" required class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
          <option value="M" {{ old('sexo', $sacramento->sexo ?? '') == 'M' ? 'selected' : '' }}>Masculino</option>
          <option value="F" {{ old('sexo', $sacramento->sexo ?? '') == 'F' ? 'selected' : '' }}>Femenino</option>
        </select>
      </div>
    </div>
  </div>

  <!-- Campos específicos por tipo de sacramento -->
  <div id="campos_especificos" class="space-y-4 border-t pt-4">
    @includeWhen(isset($sacramento), 'sacramentos.partials.' . $sacramento->tipo_sacramento . '-fields')
    
    <!-- Campos dinámicos iniciales -->
    <div id="bautizo_fields" class="sacramento-fields hidden">
      @include('sacramentos.partials.bautizo-fields')
    </div>

    <div id="matrimonio_fields" class="sacramento-fields hidden">
      @include('sacramentos.partials.matrimonio-fields')
    </div>

    <div id="comunion_fields" class="sacramento-fields hidden">
      @include('sacramentos.partials.comunion-fields')
    </div>

    <div id="confirmacion_fields" class="sacramento-fields hidden">
      @include('sacramentos.partials.confirmacion-fields')
    </div>
  </div>

  <!-- Usuario registro (oculto) -->
  <input type="hidden" name="id_usuario_registro" value="{{ session('usuario')->id_usuario }}">
</div>

<script>
  function mostrarCamposEspecificos() {
    const tipo = document.getElementById('tipo_sacramento').value;
    document.querySelectorAll('.sacramento-fields').forEach(el => {
      el.classList.add('hidden');
      el.querySelectorAll('input').forEach(input => input.disabled = true);
    });
    
    if(tipo) {
      const activeSection = document.getElementById(`${tipo}_fields`);
      activeSection.classList.remove('hidden');
      activeSection.querySelectorAll('input').forEach(input => input.disabled = false);
    }
  }

  // Mostrar campos al cargar
  window.addEventListener('DOMContentLoaded', () => {
    const tipoInicial = document.getElementById('tipo_sacramento').value;
    if(tipoInicial) mostrarCamposEspecificos();
    
    // Habilitar campos en caso de error de validación
    @if($errors->any())
      mostrarCamposEspecificos();
    @endif
  });
</script>