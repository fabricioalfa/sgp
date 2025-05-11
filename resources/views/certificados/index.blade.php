@extends('layouts.app')

@section('title', 'Solicitudes de Certificados')

@section('content')
<div class="container mx-auto p-4">
  <h1 class="text-2xl font-semibold mb-4">Solicitudes de Certificados</h1>

  <a href="{{ route('certificados.create') }}"
     class="mb-4 inline-block px-4 py-2 bg-green-600 text-white rounded">
    Emitir nuevo certificado
  </a>

  @if($ingresos->isEmpty())
    <p>No hay solicitudes registradas.</p>
  @else
    <table class="w-full table-auto border-collapse">
      <thead>
        <tr class="bg-gray-100">
          <th class="border px-4 py-2">#</th>
          <th class="border px-4 py-2">Descripción</th>
          <th class="border px-4 py-2">Monto (Bs.)</th>
          <th class="border px-4 py-2">Fecha</th>
        </tr>
      </thead>
      <tbody>
        @foreach($ingresos as $ingreso)
          <tr>
            <td class="border px-4 py-2">{{ $ingreso->id_ingreso }}</td>
            <td class="border px-4 py-2">{{ $ingreso->descripcion }}</td>
            <td class="border px-4 py-2">{{ number_format($ingreso->monto, 2) }}</td>
            <td class="border px-4 py-2">
              {{ \Carbon\Carbon::parse($ingreso->fecha)->format('d/m/Y') }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>
@endsection