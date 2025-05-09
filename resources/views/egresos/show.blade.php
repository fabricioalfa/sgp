@extends('layouts.app')

@section('title', 'Detalle del egreso')

@section('content')
  <h2 class="text-xl font-bold mb-4">Detalle del egreso</h2>

  <div class="bg-white shadow rounded p-4 text-sm space-y-3">
    <div>
      <span class="font-semibold">Fecha:</span>
      <span>{{ $egreso->fecha }}</span>
    </div>

    <div>
      <span class="font-semibold">Monto:</span>
      <span>Bs {{ number_format($egreso->monto, 2) }}</span>
    </div>

    <div>
      <span class="font-semibold">Categoría:</span>
      <span>{{ $egreso->categoria ?? '-' }}</span>
    </div>

    <div>
      <span class="font-semibold">Descripción:</span>
      <span>{{ $egreso->descripcion ?? '-' }}</span>
    </div>

    <div>
      <span class="font-semibold">ID usuario que autorizó:</span>
      <span>{{ $egreso->id_usuario_autorizador ?? 'No registrado' }}</span>
    </div>
  </div>

  <a href="{{ route('egresos.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">← Volver al listado</a>
@endsection
