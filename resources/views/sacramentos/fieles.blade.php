@extends('layouts.app')

@section('title', 'Añadir Fieles')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow" x-data="fielesForm">
  <h2 class="text-2xl font-bold text-[#C1440E] mb-6">Editar Fieles del Sacramento</h2>
  <form method="POST" action="{{ route('sacramentos.fieles.store', $sacramento) }}">
    @csrf

    <div id="fieles-wrapper" class="space-y-4">
      <template x-for="(fiel, index) in fieles" :key="index">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 border rounded-lg p-4">
          <input type="text" :name="`fieles[${index}][nombres]`" x-model="fiel.nombres" placeholder="Nombres" class="border px-3 py-2 rounded" required>
          <input type="text" :name="`fieles[${index}][apellido_paterno]`" x-model="fiel.apellido_paterno" placeholder="Apellido Paterno" class="border px-3 py-2 rounded">
          <input type="text" :name="`fieles[${index}][apellido_materno]`" x-model="fiel.apellido_materno" placeholder="Apellido Materno" class="border px-3 py-2 rounded">

          <select :name="`fieles[${index}][tipo_fiel]`" x-model="fiel.tipo_fiel" class="border px-3 py-2 rounded col-span-1">
            <option value="">Tipo de Fiel</option>
            <option value="padrino">Padrino</option>
            <option value="madrina">Madrina</option>
            <option value="testigo">Testigo</option>
            <option value="padre">Padre</option>
            <option value="madre">Madre</option>
          </select>
        </div>
      </template>
    </div>

    <div class="mt-4">
      <button type="button" @click="fieles.push({ nombres: '', apellido_paterno: '', apellido_materno: '', tipo_fiel: '' })" class="bg-green-500 text-white px-4 py-2 rounded">+ Añadir Fiel</button>
    </div>

    <div class="mt-6 flex justify-between">
      <a href="{{ route('sacramentos.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
        Cancelar
      </a>
      <button type="submit" class="bg-[#E9A209] text-white px-6 py-2 rounded-full shadow hover:bg-[#c98b07] transition">
        Guardar Fieles
      </button>
    </div>
  </form>
</div>

<script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('fielesForm', () => ({
        fieles: {!! json_encode(
          $sacramento->fieles->map(function($fiel) {
            return [
              'nombres' => $fiel->nombres,
              'apellido_paterno' => $fiel->apellido_paterno,
              'apellido_materno' => $fiel->apellido_materno,
              'tipo_fiel' => $fiel->tipo_fiel
            ];
          })->values()
        ) !!}
      }))
    });
  </script>
@endsection
