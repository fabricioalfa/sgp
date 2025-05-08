@extends('layouts.app')

@section('title', 'Lista de Sacerdotes')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-bold">Sacerdotes Registrados</h2>
        <a href="{{ route('sacerdotes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Nuevo Sacerdote
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
                <th class="p-2 text-left">Apellido Paterno</th>
                <th class="p-2 text-left">Apellido Materno</th>
                <th class="p-2 text-left">Teléfono</th>
                <th class="p-2 text-left">Fecha Ordenación</th>
                <th class="p-2 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sacerdotes as $sacerdote)
                <tr class="border-b">
                    <td class="p-2">{{ $sacerdote->nombres }}</td>
                    <td class="p-2">{{ $sacerdote->apellido_paterno }}</td>
                    <td class="p-2">{{ $sacerdote->apellido_materno }}</td>
                    <td class="p-2">{{ $sacerdote->telefono ?? 'N/A' }}</td>
                    <td class="p-2">
                        @if($sacerdote->fecha_ordenacion)
                            {{ \Carbon\Carbon::parse($sacerdote->fecha_ordenacion)->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('sacerdotes.edit', $sacerdote->id_sacerdote) }}" 
                           class="text-blue-600 hover:underline">
                            Editar
                        </a>
                        <form action="{{ route('sacerdotes.destroy', $sacerdote->id_sacerdote) }}" 
                              method="POST" 
                              onsubmit="return confirm('¿Eliminar sacerdote?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection