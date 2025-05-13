<!-- resources/views/misas/recibo.blade.php -->

@extends('layouts.app')

@section('title', 'Recibo de Misa')

@section('content')
  <div class="overflow-auto max-h-[80vh] bg-white/60 p-6 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-[#C1440E] mb-4">Recibo de Misa</h2>

    <div class="bg-white p-6 rounded-lg shadow-md">
      <h3 class="text-xl font-semibold text-[#F4A261] mb-2">Detalles de la Misa</h3>

      <table class="w-full text-sm">
        <tr>
          <th class="px-4 py-2">Fecha</th>
          <td class="px-4 py-2">{{ \Carbon\Carbon::parse($misa->fecha)->format('d/m/Y') }}</td>
        </tr>
        <tr>
          <th class="px-4 py-2">Hora</th>
          <td class="px-4 py-2">{{ \Carbon\Carbon::parse($misa->hora)->format('H:i') }}</td>
        </tr>
        <tr>
          <th class="px-4 py-2">Tipo de Misa</th>
          <td class="px-4 py-2">{{ $misa->tipo_misa }}</td>
        </tr>
        <tr>
          <th class="px-4 py-2">Intención</th>
          <td class="px-4 py-2">{{ $misa->intencion ?? 'No especificada' }}</td>
        </tr>
        <tr>
          <th class="px-4 py-2">Sacerdote</th>
          <td class="px-4 py-2">{{ $misa->sacerdote->nombres ?? 'Sin asignar' }}</td>
        </tr>
        <tr>
          <th class="px-4 py-2">Estado</th>
          <td class="px-4 py-2">{{ ucfirst($misa->estado) }}</td>
        </tr>
      </table>

      <div class="mt-4">
        <a href="{{ route('misas.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
          Volver al Listado de Misas
        </a>
        <a href="{{ route('misas.generateRecibo', $misa) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
          Descargar Recibo
        </a>
      </div>
    </div>
  </div>
@endsection