@extends('layouts.app')

@section('title', 'Panel Principal')

@section('content')
@if(session('success'))
  <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
       class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 text-sm max-w-4xl mx-auto text-center shadow">
    {{ session('success') }}
  </div>
@endif

<div class="max-w-5xl mx-auto p-6" x-data="panel">
  <!-- Botón de perfil estilo ícono -->
  <div class="flex justify-end mb-4">
    <button @click="mostrarPerfil = !mostrarPerfil"
            class="bg-[#E9A209] text-white w-10 h-10 rounded-full shadow hover:bg-[#c98b07] transition flex items-center justify-center"
            title="Ver Perfil">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A12.042 12.042 0 0112 15c2.21 0 4.26.635 5.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
    </button>
  </div>

  <!-- Perfil oculto por defecto -->
  <div x-show="mostrarPerfil" x-cloak class="bg-white/60 p-6 rounded-xl shadow-lg mb-6">
    <h2 class="text-2xl font-bold text-[#C1440E] mb-6">Bienvenido, {{ $usuario->nombre_usuario }}</h2>

    <div class="grid grid-cols-1 gap-6">
      <div class="bg-[#F4A261] text-white p-4 rounded-xl shadow-md">
        <h3 class="font-semibold text-lg mb-2">Nombre de Usuario</h3>
        <p class="text-xl">{{ $usuario->nombre_usuario }}</p>
      </div>

      <div class="bg-[#F4A261] text-white p-4 rounded-xl shadow-md">
        <h3 class="font-semibold text-lg mb-2">Información Personal</h3>
        <p><strong>Nombre Completo:</strong> {{ $usuario->nombres }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</p>
        <p><strong>Correo Electrónico:</strong> {{ $usuario->correo_electronico ?? 'No registrado' }}</p>
        <p><strong>Teléfono:</strong> {{ $usuario->telefono ?? 'No registrado' }}</p>
      </div>

      <div class="bg-[#F4A261] text-white p-4 rounded-xl shadow-md">
        <h3 class="font-semibold text-lg mb-2">Rol y Estado</h3>
        <p><strong>Rol:</strong> {{ ucfirst($usuario->rol) }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($usuario->estado) }}</p>
      </div>
    </div>

    <div class="flex gap-6 mt-6 justify-center">
      <a href="{{ route('perfil.editar') }}" class="bg-[#E9A209] text-white font-semibold py-2 px-6 rounded-lg shadow hover:bg-[#c98b07] transition">
        Editar Perfil
      </a>
          </div>
  </div>

  <!-- Calendario -->
  <div class="bg-white/80 rounded-xl shadow-xl p-6">
    <h3 class="text-xl font-semibold text-[#C1440E] mb-4">Calendario de Misas y Sacramentos</h3>
    <div class="overflow-hidden rounded-lg border" style="max-height: 600px">
      <div id='calendar' class="bg-white"></div>
    </div>
  </div>
</div>

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('panel', () => ({
      mostrarPerfil: false
    }))
  });

  document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'es',
      height: 500,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: '/api/eventos',
      eventColor: '#E9A209',
      eventDidMount: function(info) {
        if (info.event.extendedProps.tipo === 'sacramento') {
          info.el.style.backgroundColor = '#C1440E';
        }
      }
    });
    calendar.render();
  });
</script>
@endsection
