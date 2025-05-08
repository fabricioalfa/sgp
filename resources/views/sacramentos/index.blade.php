@extends('layouts.app')

@section('title', 'Lista de Sacramentos')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-bold">Sacramentos Registrados</h2>
        <a href="{{ route('sacramentos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nuevo Sacramento</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Tipo de Sacramento</th>
                <th class="p-2">Nombre del Receptor</th>
                <th class="p-2">Fecha del Sacramento</th>
                <th class="p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sacramentos as $sacramento)
                <tr class="border-b">
                    <td class="p-2">{{ $sacramento->tipo_sacramento }}</td>
                    <td class="p-2">{{ $sacramento->nombre_receptor }} {{ $sacramento->apellido_paterno }}</td>
                    <td class="p-2">{{ $sacramento->fecha }}</td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('sacramentos.edit', $sacramento->id_sacramento) }}" class="text-blue-600 hover:underline">Editar</a>
                        <form action="{{ route('sacramentos.destroy', $sacramento->id_sacramento) }}" method="POST" onsubmit="return confirm('¿Eliminar sacramento?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
