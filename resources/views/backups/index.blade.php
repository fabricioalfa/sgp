@extends('layouts.app')

@section('title', 'Backups')

@section('content')
  <div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-[#C1440E]">Backups Generados</h2>

    {{-- Botón para crear un nuevo backup --}}
    <form action="{{ route('backups.run') }}" method="POST">
      @csrf
      <button type="submit"
              class="bg-[#E9A209] text-white px-5 py-2 rounded-full shadow hover:bg-[#c98b07] transition">
        + Crear Backup
      </button>
    </form>
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
          <th class="text-left p-3">Nombre Archivo</th>
          <th class="text-left p-3">Tamaño</th>
          <th class="text-left p-3">Última Modificación</th>
          <th class="text-left p-3">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($backups as $backup)
          <tr class="border-b border-[#F4A261]/50 hover:bg-white/10 transition" x-data="{ showConfirm: false }">
            <td class="p-3">{{ $backup['basename'] }}</td>
            <td class="p-3">{{ $backup['size'] }}</td>
            <td class="p-3">{{ $backup['last_modified'] }}</td>
            <td class="p-3 flex gap-2 flex-wrap items-center">
              {{-- Descargar --}}
              <a href="{{ route('backups.download', $backup['basename']) }}"
                 class="bg-blue-600 text-white px-4 py-1 rounded-full text-sm hover:bg-blue-800 transition">
                Descargar
              </a>

              {{-- Botón Eliminar: abre modal --}}
              <button @click="showConfirm = true"
                      class="bg-[#C1440E] text-white px-4 py-1 rounded-full text-sm hover:bg-[#a8390b] transition">
                Eliminar
              </button>

              {{-- Modal de confirmación --}}
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
                    <form action="{{ route('backups.destroy', $backup['basename']) }}" method="POST">
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
        @empty
          <tr>
            <td colspan="4" class="p-4 text-center text-gray-500">
              No hay backups disponibles.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
