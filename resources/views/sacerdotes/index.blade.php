<!-- resources/views/sacerdotes/index.blade.php -->
@extends('layouts.app')

@section('title', 'Lista de Sacerdotes')

@section('content')
<div class="mb-6 flex justify-between items-center">
  <h2 class="text-2xl font-bold text-[#C1440E]">Sacerdotes Registrados</h2>
  <a href="{{ route('sacerdotes.create') }}"
     class="bg-[#E9A209] text-white px-5 py-2 rounded-full shadow hover:bg-[#c98b07] transition">
    + Nuevo Sacerdote
  </a>
</div>

@if(session('success'))
  <div class="bg-green-100/80 border border-green-300 text-green-800 px-4 py-2 rounded-lg mb-4 text-sm">
    {{ session('success') }}
  </div>
@endif

<div class="overflow-auto max-h-[70vh] rounded-xl shadow bg-white/60">
  <table class="w-full min-w-[600px] text-[15px] text-[#573830]">

    <thead class="bg-white/20 text-[#C1440E] uppercase tracking-wide text-sm border-b border-[#F4A261]">
      <tr>
        <th class="text-left p-3">Nombres</th>
        <th class="text-left p-3">Apellido Paterno</th>
        <th class="text-left p-3">Apellido Materno</th>
        <th class="text-left p-3">Teléfono</th>
        <th class="text-left p-3">Estipendio</th>
        <th class="text-left p-3">Acciones</th>
      </tr>
    </thead>

    <tbody>
      @foreach($sacerdotes as $sacerdote)
        <tr class="border-b border-[#F4A261]/50 hover:bg-white/10 transition" x-data="{ showConfirm: false }">
          <td class="p-3">{{ $sacerdote->nombres }}</td>
          <td class="p-3">{{ $sacerdote->apellido_paterno }}</td>
          <td class="p-3">{{ $sacerdote->apellido_materno }}</td>
          <td class="p-3">{{ $sacerdote->telefono ?? 'N/A' }}</td>
          <td class="p-3">{{ number_format($sacerdote->estipendio, 2, ',', '.') }}</td>
          <td class="p-3 flex flex-wrap gap-2">
            <a href="{{ route('sacerdotes.edit', $sacerdote->id_sacerdote) }}"
               class="bg-[#E9A209] text-white px-4 py-1 rounded-full text-sm hover:bg-[#c98b07] transition">
              Editar
            </a>
            <button @click="showConfirm = true"
                    class="bg-[#C1440E] text-white px-4 py-1 rounded-full text-sm hover:bg-[#a8390b] transition">
              Eliminar
            </button>

            <div x-show="showConfirm" x-cloak x-transition
                 class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center">
              <div class="bg-white/90 rounded-xl shadow-xl p-6 w-full max-w-sm text-center text-[#573830]">
                <h3 class="text-lg font-semibold text-[#C1440E] mb-4">¿Confirmar eliminación?</h3>
                <p class="text-sm mb-6">Esta acción no se puede deshacer.</p>
                <div class="flex justify-center gap-4">
                  <button @click="showConfirm = false"
                          class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                    Cancelar
                  </button>
                  <form action="{{ route('sacerdotes.destroy', $sacerdote->id_sacerdote) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-[#C1440E] text-white px-4 py-2 rounded-lg hover:bg-[#a8390b] transition">
                      Eliminar
                    </button>
                  </form>
                </div>
              </div>
            </div>

          </td>
        </tr>
      @endforeach
    </tbody>

  </table>
</div>
@endsection
