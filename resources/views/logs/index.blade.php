@extends('layouts.app')

@section('title', 'Reportes de Logs')

@section('content')
  <h2 class="text-2xl font-bold text-[#C1440E] mb-4">Historial de Cambios</h2>
  <div class="overflow-auto bg-white p-4 rounded shadow">
    <table class="w-full text-sm">
      <thead class="bg-[#F4A261]/20 text-[#C1440E] uppercase">
        <tr>
          <th class="p-2 text-left">Fecha</th>
          <th class="p-2 text-left">Usuario</th>
          <th class="p-2 text-left">Acción</th>
          <th class="p-2 text-left">Entidad</th>
          <th class="p-2 text-left">ID</th>
          <th class="p-2 text-left">Cambios</th>
        </tr>
      </thead>
      <tbody>
        @foreach($logs as $log)
          @php
            $old = json_decode($log->old_values ?? '[]', true);
            $new = json_decode($log->new_values ?? '[]', true);
            $diffs = [];
            foreach($new as $field => $valorNuevo) {
              $valorViejo = $old[$field] ?? null;
              if($log->action === 'created' || $valorViejo !== $valorNuevo) {
                $diffs[] = $field
                  . ($log->action === 'created'
                      ? ": — → {$valorNuevo}"
                      : ($log->action === 'deleted'
                          ? ": {$valorViejo} → —"
                          : ": {$valorViejo} → {$valorNuevo}"
                        )
                    );
              }
            }
          @endphp
          <tr class="border-b hover:bg-gray-50">
            <td class="p-2">{{ $log->created_at }}</td>
            <td class="p-2">{{ $log->usuario->nombre_usuario ?? '–' }}</td>
            <td class="p-2 capitalize">{{ $log->action }}</td>
            <td class="p-2">{{ class_basename($log->model) }}</td>
            <td class="p-2">{{ $log->model_id }}</td>
            <td class="p-2">
              @if(count($diffs))
                <ul class="list-disc pl-5">
                  @foreach($diffs as $d)
                    <li>{{ $d }}</li>
                  @endforeach
                </ul>
              @else
                —
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    {{-- Paginación si usas ->paginate() en lugar de ->get() --}}
    <div class="mt-4">
      {{ $logs->links() }}
    </div>
  </div>
@endsection
