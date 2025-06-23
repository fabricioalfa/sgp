@extends('layouts.portal')

@section('title', 'Inicio - Portal Parroquial')

@section('content')
  <section class="max-w-7xl mx-auto">
    <h2 class="text-3xl md:text-4xl font-bold text-[#C1440E] mb-8 text-center animate-fade-in">
      Bienvenidos a Nuestra Parroquia
    </h2>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 animate-fade-in">
      @forelse($actividades as $actividad)
        <div class="bg-white rounded-2xl shadow hover:shadow-xl overflow-hidden transform hover:scale-[1.01] transition duration-300">
          @if($actividad->imagen)
            <img src="{{ asset($actividad->imagen) }}"
                 alt="{{ $actividad->titulo }}"
                 class="w-full h-48 object-cover object-center">
          @endif

          <div class="p-5">
            <h3 class="text-xl font-semibold text-[#C1440E] mb-1">{{ $actividad->titulo }}</h3>
            @if($actividad->descripcion)
              <p class="text-sm text-gray-600 mb-2">
                {{ \Illuminate\Support\Str::limit(strip_tags($actividad->descripcion), 100) }}
              </p>
            @endif
            <p class="text-xs text-[#573830] mb-1">
              Del {{ \Carbon\Carbon::parse($actividad->fecha_inicio)->format('d/m/Y') }}
              al {{ \Carbon\Carbon::parse($actividad->fecha_fin)->format('d/m/Y') }}
            </p>

            <a href="{{ route('actividades.public.show', $actividad) }}"
               class="inline-block mt-3 bg-[#E9A209] text-white text-sm px-4 py-1 rounded-full hover:bg-[#c98b07] transition">
              Ver más
            </a>
          </div>
        </div>
      @empty
        <p class="text-center text-gray-600 col-span-3">No hay actividades disponibles por el momento.</p>
      @endforelse
    </div>
  </section>

  <style>
    @keyframes fade-in {
      from { opacity: 0; transform: translateY(10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
      animation: fade-in 0.5s ease-out both;
    }
  </style>
@endsection
