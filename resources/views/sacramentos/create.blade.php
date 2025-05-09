@extends('layouts.app')

@section('title', 'Registrar Sacramento')

@section('content')
  <h2 class="text-xl font-bold mb-4">Registrar nuevo sacramento</h2>

  <form action="{{ route('sacramentos.store') }}" method="POST" class="space-y-6">
    @csrf

    {{-- Campos comunes de sacramento --}}
    <div>
      <label class="block text-sm font-medium mb-1">Tipo de Sacramento <span class="text-red-500">*</span></label>
      <select id="tipo_sacramento" name="tipo_sacramento" required class="w-full border rounded px-3 py-2" onchange="mostrarCamposEspecificos()">
        <option value="">-- Seleccione --</option>
        <option value="bautizo">Bautizo</option>
        <option value="comunion">Primera Comunión</option>
        <option value="confirmacion">Confirmación</option>
        <option value="matrimonio">Matrimonio</option>
      </select>
    </div>

    {{-- Datos comunes del sacramento --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Fecha <span class="text-red-500">*</span></label>
        <input type="date" name="fecha" value="{{ old('fecha') }}" required class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Hora <span class="text-red-500">*</span></label>
        <input type="time" name="hora" value="{{ old('hora') }}" required class="w-full border rounded px-3 py-2">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Lugar <span class="text-red-500">*</span></label>
      <input type="text" name="lugar" value="{{ old('lugar') }}" required class="w-full border rounded px-3 py-2">
    </div>

    <div class="grid grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Nombre del Receptor</label>
        <input type="text" name="nombre_receptor" value="{{ old('nombre_receptor') }}" required class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
        <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Materno</label>
        <input type="text" name="apellido_materno" value="{{ old('apellido_materno') }}" class="w-full border rounded px-3 py-2">
      </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Fecha de Nacimiento</label>
        <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Sexo</label>
        <select name="sexo" required class="w-full border rounded px-3 py-2">
          <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
          <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
        </select>
      </div>
    </div>

    {{-- Campos específicos de Bautizo --}}
    <div id="bautizo" class="campos-tipo-sacramento hidden">
      <h3 class="font-medium text-lg mb-2">Datos del Bautizo</h3>
    
      <!-- Iglesia -->
      <div class="bg-gray-100 p-4 rounded-lg shadow-md">
        <label class="block text-sm font-medium mb-1">Iglesia</label>
        <input type="text" name="iglesia" value="{{ old('iglesia') }}" class="w-full border rounded px-3 py-2">
      </div>
    
      <!-- Datos del Padre -->
      <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
        <h4 class="font-medium text-md mb-2">Datos del Padre</h4>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Nombre del Padre</label>
            <input type="text" name="nombre_padre" value="{{ old('nombre_padre') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
            <input type="text" name="apellido_paterno_padre" value="{{ old('apellido_paterno_padre') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Materno</label>
            <input type="text" name="apellido_materno_padre" value="{{ old('apellido_materno_padre') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
      </div>
    
      <!-- Datos de la Madre -->
      <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
        <h4 class="font-medium text-md mb-2">Datos de la Madre</h4>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Nombre de la Madre</label>
            <input type="text" name="nombre_madre" value="{{ old('nombre_madre') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
            <input type="text" name="apellido_paterno_madre" value="{{ old('apellido_paterno_madre') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Materno</label>
            <input type="text" name="apellido_materno_madre" value="{{ old('apellido_materno_madre') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
      </div>
    
      <!-- Datos del Padrino -->
      <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
        <h4 class="font-medium text-md mb-2">Datos del Padrino</h4>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Nombre del Padrino</label>
            <input type="text" name="nombre_padrino" value="{{ old('nombre_padrino') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
            <input type="text" name="apellido_paterno_padrino" value="{{ old('apellido_paterno_padrino') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Materno</label>
            <input type="text" name="apellido_materno_padrino" value="{{ old('apellido_materno_padrino') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
      </div>
    
      <!-- Datos de la Madrina -->
      <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
        <h4 class="font-medium text-md mb-2">Datos de la Madrina</h4>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Nombre de la Madrina</label>
            <input type="text" name="nombre_madrina" value="{{ old('nombre_madrina') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
            <input type="text" name="apellido_paterno_madrina" value="{{ old('apellido_paterno_madrina') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Materno</label>
            <input type="text" name="apellido_materno_madrina" value="{{ old('apellido_materno_madrina') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
      </div>
    
      <!-- Sacerdote celebrante -->
      <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
        <h4 class="font-medium text-md mb-2">Sacerdote Celebrante</h4>
        <input type="text" name="sacerdote_celebrante" value="{{ old('sacerdote_celebrante') }}" class="w-full border rounded px-3 py-2">
      </div>
    </div>
    
        <div class="flex gap-2">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
          <a href="{{ route('sacramentos.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Cancelar</a>
        </div>

    {{-- Campos específicos de Primera Comunión --}}
    <div id="comunion" class="campos-tipo-sacramento hidden">
      <h3 class="font-medium text-lg mb-2">Datos de la Primera Comunión</h3>

      <!-- Iglesia -->
      <div class="bg-gray-100 p-4 rounded-lg shadow-md">
        <label class="block text-sm font-medium mb-1">Iglesia</label>
        <input type="text" name="iglesia" value="{{ old('iglesia') }}" class="w-full border rounded px-3 py-2">
      </div>

      <!-- Datos del Padre -->
      <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
        <h4 class="font-medium text-md mb-2">Datos del Padre</h4>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Nombre del Padre</label>
            <input type="text" name="nombre_padre" value="{{ old('nombre_padre') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
            <input type="text" name="apellido_paterno_padre" value="{{ old('apellido_paterno_padre') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Materno</label>
            <input type="text" name="apellido_materno_padre" value="{{ old('apellido_materno_padre') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
      </div>

      <!-- Datos de la Madre -->
      <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
        <h4 class="font-medium text-md mb-2">Datos de la Madre</h4>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Nombre de la Madre</label>
            <input type="text" name="nombre_madre" value="{{ old('nombre_madre') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
            <input type="text" name="apellido_paterno_madre" value="{{ old('apellido_paterno_madre') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Materno</label>
            <input type="text" name="apellido_materno_madre" value="{{ old('apellido_materno_madre') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
      </div>

      <!-- Datos del Padrino -->
      <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
        <h4 class="font-medium text-md mb-2">Datos del Padrino</h4>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Nombre del Padrino</label>
            <input type="text" name="nombre_padrino" value="{{ old('nombre_padrino') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
            <input type="text" name="apellido_paterno_padrino" value="{{ old('apellido_paterno_padrino') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Materno</label>
            <input type="text" name="apellido_materno_padrino" value="{{ old('apellido_materno_padrino') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
      </div>

      <!-- Datos de la Madrina -->
      <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
        <h4 class="font-medium text-md mb-2">Datos de la Madrina</h4>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Nombre de la Madrina</label>
            <input type="text" name="nombre_madrina" value="{{ old('nombre_madrina') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
            <input type="text" name="apellido_paterno_madrina" value="{{ old('apellido_paterno_madrina') }}" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Apellido Materno</label>
            <input type="text" name="apellido_materno_madrina" value="{{ old('apellido_materno_madrina') }}" class="w-full border rounded px-3 py-2">
          </div>
        </div>
      </div>
    </div>

    <!-- Campos específicos para Confirmación -->
<div id="confirmacion" class="campos-tipo-sacramento hidden">
  <h3 class="font-medium text-lg mb-2">Datos de la Confirmación</h3>

  <!-- Obispo -->
  <div class="bg-gray-100 p-4 rounded-lg shadow-md">
    <label class="block text-sm font-medium mb-1">Obispo</label>
    <input type="text" name="obispo" value="{{ old('obispo') }}" class="w-full border rounded px-3 py-2">
  </div>

  <!-- Datos del Padrino -->
  <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
    <h4 class="font-medium text-md mb-2">Datos del Padrino</h4>
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Nombre del Padrino</label>
        <input type="text" name="nombre_padrino" value="{{ old('nombre_padrino') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
        <input type="text" name="apellido_paterno_padrino" value="{{ old('apellido_paterno_padrino') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Materno</label>
        <input type="text" name="apellido_materno_padrino" value="{{ old('apellido_materno_padrino') }}" class="w-full border rounded px-3 py-2">
      </div>
    </div>
  </div>

  <!-- Datos de la Madrina -->
  <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
    <h4 class="font-medium text-md mb-2">Datos de la Madrina</h4>
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Nombre de la Madrina</label>
        <input type="text" name="nombre_madrina" value="{{ old('nombre_madrina') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
        <input type="text" name="apellido_paterno_madrina" value="{{ old('apellido_paterno_madrina') }}" class="w-full border rounded px-3 py-2">
      </div>
        <div>
        <label class="block text-sm font-medium mb-1">Apellido Materno</label>
        <input type="text" name="apellido_materno_madrina" value="{{ old('apellido_materno_madrina') }}" class="w-full border rounded px-3 py-2">
        </div>
      </div>
    </div>
  </div>


  <!-- Campos específicos para Matrimonio -->
<div id="matrimonio" class="campos-tipo-sacramento hidden">
  <h3 class="font-medium text-lg mb-2">Datos del Matrimonio</h3>

  <!-- Datos del Novio -->
  <div class="bg-gray-100 p-4 rounded-lg shadow-md">
    <h4 class="font-medium text-md mb-2">Datos del Novio</h4>
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Nombre del Novio</label>
        <input type="text" name="nombre_novio" value="{{ old('nombre_novio') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
        <input type="text" name="apellido_paterno_novio" value="{{ old('apellido_paterno_novio') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Materno</label>
        <input type="text" name="apellido_materno_novio" value="{{ old('apellido_materno_novio') }}" class="w-full border rounded px-3 py-2">
      </div>
    </div>
  </div>

  <!-- Datos de la Novia -->
  <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
    <h4 class="font-medium text-md mb-2">Datos de la Novia</h4>
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Nombre de la Novia</label>
        <input type="text" name="nombre_novia" value="{{ old('nombre_novia') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
        <input type="text" name="apellido_paterno_novia" value="{{ old('apellido_paterno_novia') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Materno</label>
        <input type="text" name="apellido_materno_novia" value="{{ old('apellido_materno_novia') }}" class="w-full border rounded px-3 py-2">
      </div>
    </div>
  </div>

  <!-- Iglesia -->
  <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
    <label class="block text-sm font-medium mb-1">Iglesia</label>
    <input type="text" name="iglesia" value="{{ old('iglesia') }}" class="w-full border rounded px-3 py-2">
  </div>

  <!-- Testigos -->
  <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
    <h4 class="font-medium text-md mb-2">Testigos</h4>
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Nombre del Testigo 1</label>
        <input type="text" name="nombre_testigo1" value="{{ old('nombre_testigo1') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Paterno Testigo 1</label>
        <input type="text" name="apellido_paterno_testigo1" value="{{ old('apellido_paterno_testigo1') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Materno Testigo 1</label>
        <input type="text" name="apellido_materno_testigo1" value="{{ old('apellido_materno_testigo1') }}" class="w-full border rounded px-3 py-2">
      </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mt-4">
      <div>
        <label class="block text-sm font-medium mb-1">Nombre del Testigo 2</label>
        <input type="text" name="nombre_testigo2" value="{{ old('nombre_testigo2') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Paterno Testigo 2</label>
        <input type="text" name="apellido_paterno_testigo2" value="{{ old('apellido_paterno_testigo2') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Materno Testigo 2</label>
        <input type="text" name="apellido_materno_testigo2" value="{{ old('apellido_materno_testigo2') }}" class="w-full border rounded px-3 py-2">
      </div>
    </div>
  </div>

  <!-- Datos del Padrino -->
  <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
    <h4 class="font-medium text-md mb-2">Datos del Padrino</h4>
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Nombre del Padrino</label>
        <input type="text" name="nombre_padrino" value="{{ old('nombre_padrino') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
        <input type="text" name="apellido_paterno_padrino" value="{{ old('apellido_paterno_padrino') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Materno</label>
        <input type="text" name="apellido_materno_padrino" value="{{ old('apellido_materno_padrino') }}" class="w-full border rounded px-3 py-2">
      </div>
    </div>
  </div>

  <!-- Datos de la Madrina -->
  <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-4">
    <h4 class="font-medium text-md mb-2">Datos de la Madrina</h4>
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Nombre de la Madrina</label>
        <input type="text" name="nombre_madrina" value="{{ old('nombre_madrina') }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
        <input type="text" name="apellido_paterno_madrina" value="{{ old('apellido_paterno_madrina') }}" class="w-full border rounded px-3 py-2">
      </div>
        <div>
        <label class="block text-sm font-medium mb-1">Apellido Materno</label>
        <input type="text" name="apellido_materno_madrina" value="{{ old('apellido_materno_madrina') }}" class="w-full border rounded px-3 py-2">
        </div>
      </div>
    </div>
  </div>
  </form>

  <script>
    function mostrarCamposEspecificos() {
      // Ocultar todos los campos específicos
      document.querySelectorAll('.campos-tipo-sacramento').forEach(function(element) {
        element.classList.add('hidden');
      });

      // Mostrar el campo específico dependiendo del tipo de sacramento seleccionado
      var tipo = document.getElementById('tipo_sacramento').value;
      if (tipo) {
        document.getElementById(tipo).classList.remove('hidden');
        document.getElementById('campos-especificos').classList.remove('hidden');
      } else {
        document.getElementById('campos-especificos').classList.add('hidden');
      }
    }
  </script>
@endsection