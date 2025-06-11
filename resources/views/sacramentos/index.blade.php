@extends('layouts.app')

@section('title', 'Sacramentos')

@section('content')
<div class="mb-6 flex justify-between items-center">
  <h2 class="text-2xl font-bold text-[#C1440E]">Lista de Sacramentos</h2>
  <a href="{{ route('sacramentos.create') }}" class="bg-[#E9A209] text-white px-5 py-2 rounded-full shadow hover:bg-[#c98b07] transition">
    + Nuevo Sacramento
  </a>
</div>

<!-- Filtro por fechas -->
<form method="GET" class="mb-4 flex gap-4 items-end">
  <div>
    <label class="text-sm text-gray-700">Desde</label>
    <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="border rounded px-3 py-1">
  </div>
  <div>
    <label class="text-sm text-gray-700">Hasta</label>
    <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="border rounded px-3 py-1">
  </div>
  <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-800 transition">
    Filtrar
  </button>
  <a href="{{ route('sacramentos.index') }}" class="text-sm text-blue-600 hover:underline">Limpiar</a>
</form>

@if(session('success'))
  <div class="bg-green-100/80 border border-green-300 text-green-800 px-4 py-2 rounded-lg mb-4 text-sm">
    {{ session('success') }}
  </div>
@endif

<div class="overflow-auto max-h-[70vh] rounded-xl shadow bg-white/60">
  <table class="w-full min-w-[700px] text-[15px] text-[#573830]">
    <thead class="bg-white/20 text-[#C1440E] uppercase tracking-wide text-sm border-b border-[#F4A261]">
      <tr>
        <th class="text-left p-3">Tipo</th>
        <th class="text-left p-3">Fecha</th>
        <th class="text-left p-3">Hora</th>
        <th class="text-left p-3">Receptor</th>
        <th class="text-left p-3">Estado</th>
        <th class="text-left p-3">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($sacramentos as $sacramento)
        <tr class="border-b border-[#F4A261]/50 hover:bg-white/10 transition {{ $sacramento->observado ? 'bg-red-100/30' : 'bg-green-100/20' }}" x-data="{ showConfirm: false }">
          <td class="p-3">{{ ucfirst($sacramento->tipo_sacramento) }}</td>
          <td class="p-3">{{ $sacramento->fecha }}</td>
          <td class="p-3">{{ $sacramento->hora }}</td>
          <td class="p-3">{{ $sacramento->nombre_receptor }} {{ $sacramento->apellido_paterno }}</td>
          <td class="p-3">
            @if ($sacramento->observado)
              <span class="text-red-600 font-semibold">Observado</span>
            @else
              <span class="text-green-700 font-semibold">Correcto</span>
            @endif
          </td>
          <td class="p-3 flex gap-2 flex-wrap">
            <a href="{{ route('sacramentos.show', $sacramento) }}" class="bg-blue-500 text-white px-4 py-1 rounded-full text-sm hover:bg-blue-700 transition">Ver</a>
            <a href="{{ route('sacramentos.edit', $sacramento) }}" class="bg-[#E9A209] text-white px-4 py-1 rounded-full text-sm hover:bg-[#c98b07] transition">Editar</a>
            <button @click="showConfirm = true" class="bg-[#C1440E] text-white px-4 py-1 rounded-full text-sm hover:bg-[#a8390b] transition">Eliminar</button>

            <!-- Modal de confirmación -->
            <div x-show="showConfirm" x-cloak x-transition class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center">
              <div class="bg-white/90 rounded-xl shadow-xl p-6 w-full max-w-sm text-center text-[#573830]">
                <h3 class="text-lg font-semibold text-[#C1440E] mb-4">¿Confirmar eliminación?</h3>
                <p class="text-sm mb-6">Esta acción no se puede deshacer.</p>
                <div class="flex justify-center gap-4">
                  <button @click="showConfirm = false" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">Cancelar</button>
                  <form action="{{ route('sacramentos.destroy', $sacramento) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-[#C1440E] text-white px-4 py-2 rounded-lg hover:bg-[#a8390b] transition">Eliminar</button>
                  </form>
                </div>
              </div>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center text-gray-500 p-4">No hay registros</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
