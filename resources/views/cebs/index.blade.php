@extends('layouts.app')

@section('title', 'Lista de CEBs')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-bold">CEBs Registradas</h2>
        <a href="{{ route('cebs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Nueva CEB
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2 text-left">Nombres</th>
                <th class="p-2 text-left">Apellidos</th>
                <th class="p-2 text-left">CEB</th>
                <th class="p-2 text-left">Responsable</th>
                <th class="p-2 text-left">Teléfono</th>
                <th class="p-2 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cebs as $ceb)
                <tr class="border-b">
                    <td class="p-2">{{ $ceb->nombres_ceb }}</td>
                    <td class="p-2">{{ $ceb->apellido_pat_ceb }} {{ $ceb->apellido_mat_ceb }}</td>
                    <td class="p-2">{{ $ceb->ceb }}</td>
                    <td class="p-2">{{ $ceb->responsable }}</td>
                    <td class="p-2">{{ $ceb->telefono }}</td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('cebs.edit', $ceb->id_ceb) }}" 
                           class="text-blue-600 hover:underline">
                            Editar
                        </a>
                        <form action="{{ route('cebs.destroy', $ceb->id_ceb) }}" 
                              method="POST" 
                              onsubmit="return confirm('¿Eliminar CEB?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">
                        No hay registros de CEBs disponibles
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection