@extends('layouts.app')

@section('title', 'Logs del Sistema')

@section('content')
  <h2 class="text-2xl font-bold text-[#C1440E] mb-4">Logs del Sistema</h2>

  <div class="overflow-auto max-h-[70vh] rounded-xl shadow bg-white/60">
    <table class="w-full text-sm text-[#573830]">
      <thead class="bg-white/20 text-[#C1440E] uppercase text-xs border-b border-[#F4A261]">
        <tr>
          <th class="p-2">Fecha</th>
          <th class="p-2">Usuario</th>
          <th class="p-2">Acción</th>
          <th class="p-2">Tabla</th>
          <th class="p-2">ID</th>
          <th class="p-2">Detalle</th>
        </tr>
      </thead>
      <tbody>
        @forelse($logs as $log)
          <tr>
    <td>{{ $log->created_at }}</td>
    <td>{{ $log->usuario->nombre_usuario ?? '–' }}</td>
    <td>{{ $log->action }}</td>
    <td>{{ $log->model }}</td>
    <td>{{ $log->model_id }}</td>
    <td>{{ \Illuminate\Support\Str::limit($log->new_values, 80) }}</td>
  </tr>
        @empty
          <tr>
            <td colspan="6" class="p-4 text-center text-gray-500">
              No hay registros de logs.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
