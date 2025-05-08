@extends('layouts.app')

@section('title', 'Finanzas')

@section('content')
  <div class="max-w-7xl mx-auto p-6 bg-white shadow-sm rounded-md">
    <h2 class="text-2xl font-bold mb-6">Módulo de Finanzas</h2>

    <!-- Botones para agregar nuevos ingresos y egresos -->
    <div class="flex justify-between mb-6">
      <a href="{{ route('finanzas.create_ingreso') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Nuevo Ingreso</a>
      <a href="{{ route('finanzas.create_egreso') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Nuevo Egreso</a>
    </div>

    <!-- Resumen de finanzas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <!-- Resumen de Ingresos -->
      <div class="bg-green-100 p-4 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold text-green-800">Resumen de Ingresos</h3>
        <p class="text-2xl font-bold text-green-600">{{ number_format($ingresos->sum('monto'), 2) }} Bs</p>
        <p class="text-sm text-gray-500">Total acumulado de ingresos</p>
      </div>

      <!-- Resumen de Egresos -->
      <div class="bg-red-100 p-4 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold text-red-800">Resumen de Egresos</h3>
        <p class="text-2xl font-bold text-red-600">{{ number_format($egresos->sum('monto'), 2) }} Bs</p>
        <p class="text-sm text-gray-500">Total acumulado de egresos</p>
      </div>
    </div>

    <!-- Ingresos -->
    <div class="mb-6">
      <h3 class="text-xl font-semibold text-blue-800 mb-4">Ingresos Registrados</h3>
      <table class="w-full table-auto border-collapse">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 text-left border-b">Monto</th>
            <th class="px-4 py-2 text-left border-b">Descripción</th>
            <th class="px-4 py-2 text-left border-b">Fecha</th>
            <th class="px-4 py-2 text-left border-b">Tipo</th>
            <th class="px-4 py-2 text-center border-b">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($ingresos as $ingreso)
            <tr>
              <td class="px-4 py-2 border-b">{{ number_format($ingreso->monto, 2) }} Bs</td>
              <td class="px-4 py-2 border-b">{{ $ingreso->descripcion }}</td>
              <td class="px-4 py-2 border-b">{{ $ingreso->fecha }}</td>
              <td class="px-4 py-2 border-b">{{ $ingreso->tipo_ingreso }}</td>
              <td class="px-4 py-2 border-b text-center">
                <a href="{{ route('finanzas.edit_ingreso', $ingreso->id_ingreso) }}" class="text-blue-600 hover:underline">Editar</a> | 
                <form action="{{ route('finanzas.destroy_ingreso', $ingreso->id_ingreso) }}" method="POST" class="inline-block">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Egresos -->
    <div class="mb-6">
      <h3 class="text-xl font-semibold text-blue-800 mb-4">Egresos Registrados</h3>
      <table class="w-full table-auto border-collapse">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 text-left border-b">Monto</th>
            <th class="px-4 py-2 text-left border-b">Descripción</th>
            <th class="px-4 py-2 text-left border-b">Fecha</th>
            <th class="px-4 py-2 text-left border-b">Categoría</th>
            <th class="px-4 py-2 text-center border-b">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($egresos as $egreso)
            <tr>
              <td class="px-4 py-2 border-b">{{ number_format($egreso->monto, 2) }} Bs</td>
              <td class="px-4 py-2 border-b">{{ $egreso->descripcion }}</td>
              <td class="px-4 py-2 border-b">{{ $egreso->fecha }}</td>
              <td class="px-4 py-2 border-b">{{ $egreso->categoria }}</td>
              <td class="px-4 py-2 border-b text-center">
                <a href="{{ route('finanzas.edit_egreso', $egreso->id_egreso) }}" class="text-blue-600 hover:underline">Editar</a> | 
                <form action="{{ route('finanzas.destroy_egreso', $egreso->id_egreso) }}" method="POST" class="inline-block">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
