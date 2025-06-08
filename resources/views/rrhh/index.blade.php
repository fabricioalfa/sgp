{{-- resources/views/rrhh/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Personal de RRHH')

@section('content')
  <div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-[#C1440E]">Personal de RRHH</h2>
    <a href="{{ route('rrhh.create') }}"
       class="bg-[#E9A209] text-white px-5 py-2 rounded-full shadow hover:bg-[#c98b07] transition">
      + Nuevo Personal
    </a>
  </div>

  @if(session('success'))
    <div class="bg-green-100/80 border border-green-300 text-green-800 px-4 py-2 rounded-lg mb-4 text-sm">
      {{ session('success') }}
    </div>
  @endif

  <div class="overflow-auto max-h-[70vh] rounded-xl shadow bg-white/60">
    <table class="w-full min-w-[800px] text-[15px] text-[#573830]">
      <thead class="bg-white/20 text-[#C1440E] uppercase tracking-wide text-sm border-b border-[#F4A261]">
        <tr>
          <th class="text-left p-3">Nombre Completo</th>
          <th class="text-left p-3">Cargo</th>
          <th class="text-left p-3">Ingreso</th>
          <th class="text-left p-3">Teléfono</th>
          <th class="text-left p-3">Estado</th>
          <th class="text-left p-3">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rrhh as $p)
          <tr class="border-b border-[#F4A261]/50 hover:bg-white/10 transition" x-data="{ showConfirm: false }">
            <td class="p-3">{{ $p->nombres }} {{ $p->apellido_paterno }} {{ $p->apellido_materno }}</td>
            <td class="p-3">{{ $p->cargo }}</td>
            <td class="p-3">{{ $p->fecha_ingreso }}</td>
            <td class="p-3">{{ $p->telefono }}</td>
            <td class="p-3 capitalize">{{ $p->estado }}</td>
            <td class="p-3 flex flex-wrap gap-2">
              <a href="{{ route('rrhh.edit', $p->id_personal) }}"
                 class="bg-[#E9A209] text-white px-4 py-1 rounded-full text-sm hover:bg-[#c98b07] transition">
                Editar
              </a>
              <button @click="showConfirm = true"
                      class="bg-[#C1440E] text-white px-4 py-1 rounded-full text-sm hover:bg-[#a8390b] transition">
                Eliminar
              </button>
              <!-- Modal -->
              <div x-show="showConfirm" x-cloak x-transition
                   class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center">
                <div class="bg-white/90 rounded-xl shadow-xl p-6 w-full max-w-sm text-center text-[#573830]">
                  <h3 class="text-lg font-semibold text-[#C1440E] mb-4">¿Confirmar eliminación?</h3>
                  <p class="text-sm mb-6">¿Seguro que deseas eliminar a <strong>{{ $p->nombres }}</strong>?</p>
                  <div class="flex justify-center gap-4">
                    <button @click="showConfirm = false"
                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                      Cancelar
                    </button>
                    <form action="{{ route('rrhh.destroy', $p->id_personal) }}" method="POST">
                      @csrf @method('DELETE')
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
