@extends('layouts.app')

@section('title', 'Solicitudes de Certificados')

@section('content')
<div class="max-w-6xl mx-auto bg-white/60 rounded-xl shadow p-6 overflow-auto max-h-[75vh]">
  <h1 class="text-2xl font-bold text-[#C1440E] mb-6">Solicitudes de Certificados</h1>

  <a href="{{ route('certificados.create') }}"
     class="mb-6 inline-block px-5 py-2 bg-[#E9A209] text-white rounded-lg shadow hover:bg-[#c98b07] transition">
    + Emitir nuevo certificado
  </a>

  @if($ingresos->isEmpty())
    <p class="text-gray-500">No hay solicitudes registradas.</p>
  @else
    <table class="w-full text-sm text-[#573830] border-collapse">
      <thead class="bg-white/20 border-b border-[#F4A261] text-[#C1440E] uppercase tracking-wide text-xs">
        <tr>
          <th class="px-4 py-2 text-left">Descripción</th>
          <th class="px-4 py-2 text-left">Monto (Bs.)</th>
          <th class="px-4 py-2 text-left">Fecha</th>
        </tr>
      </thead>
      <tbody>
        @foreach($ingresos as $ingreso)
          <tr class="border-b hover:bg-white/10 transition">
            <td class="px-4 py-2">{{ $ingreso->descripcion }}</td>
            <td class="px-4 py-2">{{ number_format($ingreso->monto, 2) }}</td>
            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($ingreso->fecha)->format('d/m/Y') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>
@endsection
