@extends('layouts.app')

@section('title', 'Finanzas')

@section('content')
  <h2 class="text-2xl font-bold text-[#C1440E] mb-4">Balance de Finanzas</h2>

  <!-- Formulario de Filtros (centrado y estilizado) -->
  <div class="mb-6 flex justify-between items-center">
    <form action="{{ route('finanzas.index') }}" method="GET" class="flex gap-4 items-center">
      <div>
        <label for="fecha_inicio" class="block text-sm font-medium mb-1 text-[#573830]">Fecha de Inicio</label>
        <input type="date" name="fecha_inicio" value="{{ request()->fecha_inicio }}" class="w-48 border rounded px-3 py-2 bg-[#F4A261] text-white">
      </div>
      <div>
        <label for="fecha_fin" class="block text-sm font-medium mb-1 text-[#573830]">Fecha de Fin</label>
        <input type="date" name="fecha_fin" value="{{ request()->fecha_fin }}" class="w-48 border rounded px-3 py-2 bg-[#F4A261] text-white">
      </div>
      <div>
        <button type="submit" class="bg-[#C1440E] text-white px-4 py-2 rounded hover:bg-[#a8390b] transition-colors">Filtrar</button>
      </div>
    </form>

    <!-- Botones de Ver Ingresos y Egresos -->
    <div>
      <a href="{{ route('ingresos.index') }}" class="bg-[#E9A209] text-white px-4 py-2 rounded hover:bg-[#c98b07] mr-4">Ver Ingresos</a>
      <a href="{{ route('egresos.index') }}" class="bg-[#C1440E] text-white px-4 py-2 rounded hover:bg-[#a8390b]">Ver Egresos</a>
    </div>
  </div>

  <!-- Totales: Ingresos, Egresos y Saldo -->
  <div class="grid grid-cols-3 gap-6 mb-6">
    <div class="p-4 bg-[#F4A261] text-white rounded-lg shadow-md">
      <h3 class="font-medium text-lg mb-2">Total Ingresos</h3>
      <p class="text-2xl">{{ $totalIngresos }} Bs</p>
    </div>
    <div class="p-4 bg-[#C1440E] text-white rounded-lg shadow-md">
      <h3 class="font-medium text-lg mb-2">Total Egresos</h3>
      <p class="text-2xl">{{ $totalEgresos }} Bs</p>
    </div>
    <div class="p-4 bg-[#E9A209] text-white rounded-lg shadow-md">
      <h3 class="font-medium text-lg mb-2">Saldo</h3>
      <p class="text-2xl">{{ $saldo }} Bs</p>
    </div>
  </div>

  <!-- Mostrar Ingresos y Egresos en columnas separadas -->
  <div class="flex gap-6">
    <!-- Ingresos -->
    <div class="w-1/2 bg-white shadow-lg rounded-lg p-4">
      <h3 class="font-medium text-lg mb-2 text-[#C1440E]">Ingresos Registrados</h3>
      <table class="w-full bg-white shadow text-sm">
        <thead class="bg-[#F4A261] text-left text-white">
          <tr>
            <th class="p-2">Fecha</th>
            <th class="p-2">Monto</th>
            <th class="p-2">Descripción</th>
            <th class="p-2">Tipo de Ingreso</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($ingresos as $ingreso)
            <tr class="border-b">
              <td class="p-2">{{ $ingreso->fecha }}</td>
              <td class="p-2">{{ $ingreso->monto }} Bs</td>
              <td class="p-2">{{ $ingreso->descripcion }}</td>
              <td class="p-2">{{ ucfirst($ingreso->tipo_ingreso) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Egresos -->
    <div class="w-1/2 bg-white shadow-lg rounded-lg p-4">
      <h3 class="font-medium text-lg mb-2 text-[#C1440E]">Egresos Registrados</h3>
      <table class="w-full bg-white shadow text-sm">
        <thead class="bg-[#F4A261] text-left text-white">
          <tr>
            <th class="p-2">Fecha</th>
            <th class="p-2">Monto</th>
            <th class="p-2">Descripción</th>
            <th class="p-2">Categoría</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($egresos as $egreso)
            <tr class="border-b">
              <td class="p-2">{{ $egreso->fecha }}</td>
              <td class="p-2">{{ $egreso->monto }} Bs</td>
              <td class="p-2">{{ $egreso->descripcion }}</td>
              <td class="p-2">{{ $egreso->categoria }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection
