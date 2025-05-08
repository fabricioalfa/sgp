<div class="space-y-4">
    <h3 class="font-medium text-lg mb-4">Datos Específicos del Matrimonio</h3>
  
    <!-- Novios -->
    <div class="grid grid-cols-2 gap-4">
      <div class="border p-4 rounded">
        <h4 class="font-medium mb-2">Novio</h4>
        <div class="space-y-4">
          <input type="text" name="nombre_novio" value="{{ old('nombre_novio') }}"
                 placeholder="Nombre completo" class="w-full border rounded px-3 py-2">
          <div class="grid grid-cols-2 gap-2">
            <input type="text" name="apellido_paterno_novio" placeholder="Apellido Paterno"
                   value="{{ old('apellido_paterno_novio') }}" class="w-full border rounded px-3 py-2">
            <input type="text" name="apellido_materno_novio" placeholder="Apellido Materno"
                   value="{{ old('apellido_materno_novio') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
      </div>
  
      <div class="border p-4 rounded">
        <h4 class="font-medium mb-2">Novia</h4>
        <div class="space-y-4">
          <input type="text" name="nombre_novia" value="{{ old('nombre_novia') }}"
                 placeholder="Nombre completo" class="w-full border rounded px-3 py-2">
          <div class="grid grid-cols-2 gap-2">
            <input type="text" name="apellido_paterno_novia" placeholder="Apellido Paterno"
                   value="{{ old('apellido_paterno_novia') }}" class="w-full border rounded px-3 py-2">
            <input type="text" name="apellido_materno_novia" placeholder="Apellido Materno"
                   value="{{ old('apellido_materno_novia') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
      </div>
    </div>
  
    <!-- Testigos -->
    <div class="grid grid-cols-2 gap-4 mt-4">
      <div class="border p-4 rounded">
        <h4 class="font-medium mb-2">Testigo 1</h4>
        <div class="space-y-4">
          <input type="text" name="nombre_testigo1" value="{{ old('nombre_testigo1') }}"
                 placeholder="Nombre completo" class="w-full border rounded px-3 py-2">
          <div class="grid grid-cols-2 gap-2">
            <input type="text" name="apellido_paterno_testigo1" placeholder="Apellido Paterno"
                   value="{{ old('apellido_paterno_testigo1') }}" class="w-full border rounded px-3 py-2">
            <input type="text" name="apellido_materno_testigo1" placeholder="Apellido Materno"
                   value="{{ old('apellido_materno_testigo1') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
      </div>
  
      <div class="border p-4 rounded">
        <h4 class="font-medium mb-2">Testigo 2</h4>
        <div class="space-y-4">
          <input type="text" name="nombre_testigo2" value="{{ old('nombre_testigo2') }}"
                 placeholder="Nombre completo" class="w-full border rounded px-3 py-2">
          <div class="grid grid-cols-2 gap-2">
            <input type="text" name="apellido_paterno_testigo2" placeholder="Apellido Paterno"
                   value="{{ old('apellido_paterno_testigo2') }}" class="w-full border rounded px-3 py-2">
            <input type="text" name="apellido_materno_testigo2" placeholder="Apellido Materno"
                   value="{{ old('apellido_materno_testigo2') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
      </div>
    </div>
  
    <!-- Iglesia -->
    <div class="mt-4">
      <label class="block text-sm font-medium mb-1">Iglesia</label>
      <input type="text" name="iglesia" value="{{ old('iglesia') }}"
             class="w-full border rounded px-3 py-2">
    </div>
  </div>