{{-- resources/views/estadisticas/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Estadísticas Generales')

@section('content')
  <h2 class="text-2xl font-bold text-[#C1440E] mb-6">Dashboard de Estadísticas</h2>

  {{-- Gráficos --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white/60 rounded-xl shadow p-6">
      <h3 class="text-lg font-semibold text-[#C1440E] mb-4 text-center">Ingresos vs Egresos</h3>
      <canvas id="incomeExpenseChart" class="w-full" height="200"></canvas>
    </div>

    <div class="bg-white/60 rounded-xl shadow p-6">
      <h3 class="text-lg font-semibold text-[#C1440E] mb-4 text-center">Eventos Registrados</h3>
      <canvas id="eventsChart" class="w-full" height="200"></canvas>
    </div>
  </div>

  {{-- Tarjetas numéricas --}}
  <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
    <div class="bg-white/60 rounded-xl shadow p-6 text-center">
      <div class="text-sm uppercase text-[#C1440E] mb-2">Total Ingresos (Bs)</div>
      <div class="text-3xl font-bold text-[#573830]">Bs {{ number_format($totalIngresos, 2, ',', '.') }}</div>
    </div>
    <div class="bg-white/60 rounded-xl shadow p-6 text-center">
      <div class="text-sm uppercase text-[#C1440E] mb-2">Total Egresos (Bs)</div>
      <div class="text-3xl font-bold text-[#573830]">Bs {{ number_format($totalEgresos, 2, ',', '.') }}</div>
    </div>
    <div class="bg-white/60 rounded-xl shadow p-6 text-center">
      <div class="text-sm uppercase text-[#C1440E] mb-2">Balance Neto   (Bs)</div>
      <div class="text-3xl font-bold {{ $balance < 0 ? 'text-red-600' : 'text-green-700' }}">
        Bs {{ number_format($balance, 2, ',', '.') }}
      </div>
    </div>
    <div class="bg-white/60 rounded-xl shadow p-6 text-center">
      <div class="text-sm uppercase text-[#C1440E] mb-2">Misas Registradas</div>
      <div class="text-3xl font-bold text-[#573830]">{{ $misasCount }}</div>
    </div>
    <div class="bg-white/60 rounded-xl shadow p-6 text-center">
      <div class="text-sm uppercase text-[#C1440E] mb-2">Sacramentos</div>
      <div class="text-3xl font-bold text-[#573830]">{{ $sacramentosCount }}</div>
    </div>
  </div>

  {{-- Chart.js y configuración --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      const ingresos    = parseFloat(@json($totalIngresos));
      const egresos     = parseFloat(@json($totalEgresos));
      const misasCount  = parseInt(@json($misasCount));
      const sacramCount = parseInt(@json($sacramentosCount));

      // Ingresos vs Egresos
      new Chart(
        document.getElementById('incomeExpenseChart'),
        {
          type: 'doughnut',
          data: {
            labels: ['Ingresos','Egresos'],
            datasets: [{
              data: [ingresos, egresos],
              backgroundColor: ['#E9A209','#C1440E'],
              hoverOffset: 4
            }]
          },
          options: {
            plugins: { legend: { position: 'bottom' } }
          }
        }
      );

      // Misas vs Sacramentos
      new Chart(
        document.getElementById('eventsChart'),
        {
          type: 'bar',
          data: {
            labels: ['Misas','Sacramentos'],
            datasets: [{
              label: 'Cantidad',
              data: [misasCount, sacramCount],
              backgroundColor: ['#E9A209','#C1440E'],
            }]
          },
          options: {
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
            plugins: { legend: { display: false } }
          }
        }
      );
    });
  </script>
@endsection
