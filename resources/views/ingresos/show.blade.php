@extends('layouts.app')

@section('title', 'Detalle del Ingreso')

@section('content')
  <h2 class="text-xl font-bold mb-4">Detalle del ingreso</h2>

  <div class="bg-white shadow rounded p-4 text-sm space-y-3">
    <div>
      <span class="font-semibold">Fecha:</span>
      <span>{{ $ingreso->fecha }}</span>
    </div>

    <div>
      <span class="font-semibold">Monto:</span>
      <span>Bs {{ number_format($ingreso->monto, 2) }}</span>
    </div>

    <div>
      <span class="font-semibold">Tipo de ingreso:</span>
      <span>{{ ucfirst($ingreso->tipo_ingreso) }}</span>
    </div>

    <div>
      <span class="font-semibold">Descripción:</span>
      <span>{{ $ingreso->descripcion ?? '-' }}</span>
    </div>

    <div>
      <span class="font-semibold">ID usuario que registró:</span>
      <span>{{ $ingreso->id_usuario_registro ?? 'No registrado' }}</span>
    </div>
  </div>

  <!-- Botón para generar recibo -->
  <div class="mt-4">
    <a href="{{ route('ingresos.recibo', $ingreso->id) }}" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Generar Recibo</a>
  </div>

  <a href="{{ route('ingresos.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">← Volver al listado</a>
@endsection