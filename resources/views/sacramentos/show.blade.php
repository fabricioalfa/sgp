@extends('layouts.app')

@section('title', 'Detalle del Sacramento')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow">
  <h2 class="text-2xl font-bold text-[#C1440E] mb-6">Detalle del Sacramento</h2>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div><strong>Tipo:</strong> {{ ucfirst($sacramento->tipo_sacramento) }}</div>
    <div><strong>Fecha:</strong> {{ $sacramento->fecha }}</div>
    <div><strong>Hora:</strong> {{ $sacramento->hora }}</div>
    <div><strong>Lugar:</strong> {{ $sacramento->lugar }}</div>
    <div><strong>Iglesia:</strong> {{ $sacramento->iglesia }}</div>
    <div><strong>Nombre Receptor:</strong> {{ $sacramento->nombre_receptor }} {{ $sacramento->apellido_paterno }} {{ $sacramento->apellido_materno }}</div>

    @if($sacramento->fecha_nacimiento)
      <div><strong>Fecha Nacimiento:</strong> {{ $sacramento->fecha_nacimiento }}</div>
    @endif

    @if($sacramento->sexo)
      <div><strong>Sexo:</strong> {{ ucfirst($sacramento->sexo) }}</div>
    @endif

    <div><strong>Estado:</strong>
      @if($sacramento->observado)
        <span class="text-red-600 font-semibold">Observado</span>
      @else
        <span class="text-green-700 font-semibold">Correcto</span>
      @endif
    </div>
  </div>

  <div class="mt-6">
    <h3 class="text-lg font-semibold text-[#C1440E]">Fieles Relacionados</h3>
    <ul class="list-disc pl-6 mt-2 space-y-1">
      @forelse($sacramento->fieles as $fiel)
        <li>
          <strong>{{ ucfirst($fiel->tipo_fiel) }}:</strong>
          {{ $fiel->nombres }} {{ $fiel->apellido_paterno }} {{ $fiel->apellido_materno }}
          @if($fiel->correo_electronico)
            | <span class="text-sm text-gray-700">📧 {{ $fiel->correo_electronico }}</span>
          @endif
          @if($fiel->telefono)
            | <span class="text-sm text-gray-700">📞 {{ $fiel->telefono }}</span>
          @endif
        </li>
      @empty
        <li>No hay fieles registrados para este sacramento.</li>
      @endforelse
    </ul>
  </div>

  <div class="mt-6 flex justify-end space-x-3">
    <a href="{{ route('sacramentos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Volver</a>
    @if(in_array($sacramento->tipo_sacramento, ['bautizo', 'matrimonio']))
      <a href="{{ route('sacramentos.recibo', $sacramento) }}" class="bg-[#E9A209] text-white px-4 py-2 rounded">Ver Recibo</a>
    @endif
  </div>
</div>
@endsection
