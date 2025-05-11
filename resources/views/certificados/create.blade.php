{{-- resources/views/certificados/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Emitir Certificado')

@section('content')
<div class="container mx-auto p-4" x-data="certificadoForm()" x-cloak>
  <h1 class="text-2xl font-semibold mb-4">Emitir Certificado</h1>

  <form action="{{ route('certificados.store') }}" method="POST" target="_blank">
    @csrf

    {{-- 1) Tipo de certificado --}}
    <div class="mb-4">
      <label for="tipo" class="block font-medium">Tipo de Certificado</label>
      <select
        id="tipo"
        name="tipo"
        x-model="tipo"
        @change="onTipoChange()"
        required
        class="w-full border p-2"
      >
        <option value="">-- Selecciona --</option>
        @foreach($tipos as $key => [$label, $precio])
          <option value="{{ $key }}">
            {{ $label }} @if($precio > 0)(Bs. {{ number_format($precio,2) }})@endif
          </option>
        @endforeach
      </select>
    </div>

    {{-- 2) Buscador y tarjetas sólo para sacramentos --}}
    <template x-if="['bautizo','matrimonio','primera_comunion','confirmacion'].includes(tipo)">
      <div class="mb-4">
        <label class="block font-medium mb-2" for="query">
          <span x-text="{
            bautizo: 'Filtrar Bautizos',
            matrimonio: 'Filtrar Matrimonios',
            primera_comunion: 'Filtrar Primeras Comuniones',
            confirmacion: 'Filtrar Confirmaciones'
          }[tipo]"></span>
        </label>

        <input
          id="query"
          type="text"
          x-model="query"
          placeholder="Escribe nombre completo…"
          @input="filterSacramentos()"
          class="w-full border p-2 mb-4"
        >

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <template x-for="s in sacramentosFiltrados" :key="s.id_sacramento">
            <div
              @click="select(s)"
              :class="{
                'border-blue-500 bg-blue-50': s.id_sacramento === sacramento_id,
                'border-gray-300 bg-white': s.id_sacramento !== sacramento_id
              }"
              class="border p-4 rounded cursor-pointer hover:shadow"
            >
              <h4 class="font-semibold" x-text="`${s.nombre_receptor} ${s.apellido_paterno} ${s.apellido_materno}`"></h4>
              <p class="text-sm text-gray-600" x-text="`Fecha: ${formatDate(s.fecha)}`"></p>
              <p class="text-sm text-gray-600" x-text="`Lugar: ${s.lugar}`"></p>
            </div>
          </template>
        </div>

        <div x-show="query && sacramentosFiltrados.length === 0" class="text-gray-500 italic mt-2">
          No se encontraron resultados.
        </div>

        <input type="hidden" name="sacramento_id" :value="sacramento_id">
      </div>
    </template>

    {{-- 3) Botón de envío --}}
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
      Generar Certificado
    </button>
  </form>
</div>

{{-- Alpine.js --}}
<script src="https://unpkg.com/alpinejs" defer></script>
<script>
document.addEventListener('alpine:init', () => {
  Alpine.data('certificadoForm', () => ({
    tipo: '',
    query: '',
    sacramento_id: null,

    // Carga todos los sacramentos de golpe desde el controlador
    sacramentos: @json($sacramentos),
    sacramentosFiltrados: [],

    onTipoChange() {
      this.query = '';
      this.sacramento_id = null;
      this.sacramentosFiltrados = [];
    },

    filterSacramentos() {
      const q = this.query.toLowerCase();
      this.sacramento_id = null;

      this.sacramentosFiltrados = this.sacramentos
        .filter(s => s.tipo_sacramento === this.tipo)
        .filter(s => !q || `${s.nombre_receptor} ${s.apellido_paterno} ${s.apellido_materno}`.toLowerCase().includes(q));
    },

    select(s) {
      this.sacramento_id = s.id_sacramento;
    },

    formatDate(str) {
      const [y, m, d] = str.split('-');
      return `${d}/${m}/${y}`;
    }
  }));
});
</script>
@endsection