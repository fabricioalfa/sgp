<div class="space-y-4">
    <h3 class="font-medium text-lg mb-4">Datos Específicos del Bautizo</h3>
  
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Iglesia</label>
        <input type="text" name="iglesia" value="{{ old('iglesia') }}"
               class="w-full border rounded px-3 py-2">
      </div>
      
      <div>
        <label class="block text-sm font-medium mb-1">Sacerdote Celebrante</label>
        <input type="text" name="sacerdote_celebrante" value="{{ old('sacerdote_celebrante') }}"
               class="w-full border rounded px-3 py-2">
      </div>
    </div>
  
    <!-- Sección Padres -->
    <div class="border p-4 rounded space-y-4">
      <h4 class="font-medium mb-2">Datos de los Padres</h4>
      
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1">Nombre del Padre</label>
          <input type="text" name="nombre_padre" value="{{ old('nombre_padre') }}"
                 class="w-full border rounded px-3 py-2">
          
          <div class="grid grid-cols-2 gap-2 mt-2">
            <input type="text" name="apellido_paterno_padre" placeholder="Apellido Paterno"
                   value="{{ old('apellido_paterno_padre') }}" class="w-full border rounded px-3 py-2">
            <input type="text" name="apellido_materno_padre" placeholder="Apellido Materno"
                   value="{{ old('apellido_materno_padre') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
  
        <div>
          <label class="block text-sm font-medium mb-1">Nombre de la Madre</label>
          <input type="text" name="nombre_madre" value="{{ old('nombre_madre') }}"
                 class="w-full border rounded px-3 py-2">
          
          <div class="grid grid-cols-2 gap-2 mt-2">
            <input type="text" name="apellido_paterno_madre" placeholder="Apellido Paterno"
                   value="{{ old('apellido_paterno_madre') }}" class="w-full border rounded px-3 py-2">
            <input type="text" name="apellido_materno_madre" placeholder="Apellido Materno"
                   value="{{ old('apellido_materno_madre') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
      </div>
    </div>
  
    <!-- Sección Padrinos -->
    <div class="border p-4 rounded space-y-4">
      <h4 class="font-medium mb-2">Datos de los Padrinos</h4>
      
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1">Padrino</label>
          <input type="text" name="nombre_padrino" value="{{ old('nombre_padrino') }}"
                 class="w-full border rounded px-3 py-2">
          
          <div class="grid grid-cols-2 gap-2 mt-2">
            <input type="text" name="apellido_paterno_padrino" placeholder="Apellido Paterno"
                   value="{{ old('apellido_paterno_padrino') }}" class="w-full border rounded px-3 py-2">
            <input type="text" name="apellido_materno_padrino" placeholder="Apellido Materno"
                   value="{{ old('apellido_materno_padrino') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
  
        <div>
          <label class="block text-sm font-medium mb-1">Madrina</label>
          <input type="text" name="nombre_madrina" value="{{ old('nombre_madrina') }}"
                 class="w-full border rounded px-3 py-2">
          
          <div class="grid grid-cols-2 gap-2 mt-2">
            <input type="text" name="apellido_paterno_madrina" placeholder="Apellido Paterno"
                   value="{{ old('apellido_paterno_madrina') }}" class="w-full border rounded px-3 py-2">
            <input type="text" name="apellido_materno_madrina" placeholder="Apellido Materno"
                   value="{{ old('apellido_materno_madrina') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
      </div>
    </div>
  </div>