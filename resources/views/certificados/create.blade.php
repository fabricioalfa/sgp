@extends('layouts.app')

@section('title', 'Emitir Certificado')

@section('content')
<div class="max-w-6xl mx-auto bg-white/60 rounded-xl shadow p-6 overflow-auto max-h-[80vh]" x-data="certificadoForm()" x-cloak>
  <h1 class="text-2xl font-bold text-[#C1440E] mb-6">Emitir Certificado</h1>

  <form action="{{ route('certificados.store') }}" method="POST" class="space-y-6">
    @csrf

    {{-- 1) Tipo de certificado --}}
    <div>
      <label for="tipo" class="block text-sm font-semibold text-[#C1440E] mb-1">Tipo de Certificado</label>
      <select
        id="tipo"
        name="tipo"
        x-model="tipo"
        @change="onTipoChange()"
        class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
               focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]"
      >
        <option value="">-- Selecciona --</option>
        @foreach($tipos as $key => [$label, $precio])
          <option value="{{ $key }}">
            {{ $label }} @if($precio > 0)(Bs. {{ number_format($precio,2) }})@endif
          </option>
        @endforeach
      </select>
      @error('tipo')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- 2) Buscador y tarjetas --}}
    <template x-if="['bautizo','matrimonio','primera_comunion','confirmacion'].includes(tipo)">
      <div>
        <label class="block text-sm font-semibold text-[#C1440E] mb-2" for="query">
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
          class="w-full border rounded-xl px-4 py-2 bg-white/80 text-[#573830]
                 focus:outline-none focus:ring-2 border-gray-300 focus:ring-[#F4A261]"
        >

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
          <template x-for="s in sacramentosFiltrados" :key="s.id_sacramento">
            <div
              @click="select(s)"
              :class="{
                'border-[#C1440E] bg-[#FFF3E0]': s.id_sacramento === sacramento_id,
                'border-gray-300 bg-white': s.id_sacramento !== sacramento_id
              }"
              class="border p-4 rounded-xl cursor-pointer hover:shadow transition"
            >
              <h4 class="font-semibold text-[#573830]" x-text="`${s.nombre_receptor} ${s.apellido_paterno} ${s.apellido_materno}`"></h4>
              <p class="text-sm text-[#573830]/80" x-text="`Fecha: ${formatDate(s.fecha)}`"></p>
              <p class="text-sm text-[#573830]/80" x-text="`Lugar: ${s.lugar}`"></p>
            </div>
          </template>
        </div>

        <div x-show="query && sacramentosFiltrados.length === 0" class="text-sm text-gray-500 italic mt-2">
          No se encontraron resultados.
        </div>

        <input type="hidden" name="sacramento_id" :value="sacramento_id">
        @if(old('sacramento_id') === null && $errors->has('sacramento_id'))
          <p class="text-sm text-red-600 mt-2">{{ $errors->first('sacramento_id') }}</p>
        @endif
      </div>
    </template>

    {{-- 3) Botones --}}
    <div class="pt-4 flex justify-between items-center">
      <a href="{{ route('certificados.index') }}"
         class="px-5 py-2 border border-[#C1440E] text-[#C1440E] rounded-lg hover:bg-[#f9e5dd] transition">
        Cancelar
      </a>

      <button type="submit"
              class="bg-[#E9A209] hover:bg-[#c98b07] text-white font-semibold px-6 py-2 rounded-lg shadow transition">
        Generar Certificado
      </button>
    </div>
  </form>
</div>

<script src="https://unpkg.com/alpinejs" defer></script>
<script>
document.addEventListener('alpine:init', () => {
  Alpine.data('certificadoForm', () => ({
    tipo: '',
    query: '',
    sacramento_id: null,
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
