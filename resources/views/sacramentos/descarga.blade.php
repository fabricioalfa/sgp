@extends('layouts.app')

@section('title', 'Recibo de Sacramento')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow">
  <h2 class="text-2xl font-bold text-[#C1440E] mb-6">Recibo generado</h2>

  <div class="aspect-video border rounded-lg overflow-hidden shadow">
    <iframe src="data:application/pdf;base64,{{ base64_encode($pdf) }}" class="w-full h-[70vh]" frameborder="0"></iframe>
  </div>

  <div class="mt-6 flex justify-end">
    <a href="{{ route('sacramentos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Volver a la lista</a>
  </div>
</div>
@endsection
