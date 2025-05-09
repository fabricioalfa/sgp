@extends('layouts.app')

@section('title', 'Detalle del Sacramento')

@section('content')
  <h2 class="text-xl font-bold mb-4">Detalle del Sacramento</h2>

  <div class="bg-white shadow rounded p-6 text-sm space-y-4">

    {{-- Mostrar los campos del sacramento --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <p><span class="font-semibold">Tipo de sacramento:</span> {{ ucfirst($sacramento->tipo_sacramento) }}</p>
        <p><span class="font-semibold">Fecha:</span> {{ $sacramento->fecha }}</p>
        <p><span class="font-semibold">Hora:</span> {{ $sacramento->hora }}</p>
        <p><span class="font-semibold">Lugar:</span> {{ $sacramento->lugar }}</p>
      </div>

      <div>
        <p><span class="font-semibold">Nombre del receptor:</span> {{ $sacramento->nombre_receptor }}</p>
        <p><span class="font-semibold">Apellido paterno:</span> {{ $sacramento->apellido_paterno }}</p>
        <p><span class="font-semibold">Apellido materno:</span> {{ $sacramento->apellido_materno ?? '-' }}</p>
        <p><span class="font-semibold">Sexo:</span> {{ $sacramento->sexo == 'M' ? 'Masculino' : 'Femenino' }}</p>
      </div>
    </div>

    <div>
      <p><span class="font-semibold">Fecha de nacimiento:</span> {{ $sacramento->fecha_nacimiento ?? 'No registrada' }}</p>
      <p><span class="font-semibold">Registrado por usuario ID:</span> {{ $sacramento->id_usuario_registro ?? 'No especificado' }}</p>
    </div>
  </div>

  <div class="mt-6 flex gap-2">
    <a href="{{ route('sacramentos.edit', $sacramento) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
    <a href="{{ route('sacramentos.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Volver al listado</a>
  </div>
@endsection