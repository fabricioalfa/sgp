@extends('layouts.portal')

@section('title', $actividad->titulo)

@section('content')
  <div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-6 space-y-4">
    @if($actividad->imagen)
      <img src="{{ asset($actividad->imagen) }}" alt="{{ $actividad->titulo }}" class="rounded-xl w-full object-cover h-64 mb-4">
    @endif

    <h2 class="text-3xl font-bold text-[#C1440E]">{{ $actividad->titulo }}</h2>

    <p class="text-sm text-[#573830] mb-2">
      Del {{ \Carbon\Carbon::parse($actividad->fecha_inicio)->format('d/m/Y') }}
      al {{ \Carbon\Carbon::parse($actividad->fecha_fin)->format('d/m/Y') }} <br>
      Responsable: <strong>{{ $actividad->responsable }}</strong>
    </p>

    <div class="prose max-w-none">
      {!! nl2br(e($actividad->descripcion)) !!}
    </div>

    <div class="pt-6">
      <a href="{{ route('portal') }}" class="text-[#E9A209] hover:underline">&larr; Volver al portal</a>
    </div>
  </div>
@endsection
