{{-- resources/views/components/stats-card.blade.php --}}
@props([
  'label',
  'value',
  'isCurrency' => false,
])

<div class="bg-white/60 rounded-xl shadow p-6 text-center">
  <div class="text-sm uppercase text-[#C1440E] mb-2">{{ $label }}</div>
  <div class="text-3xl font-bold text-[#573830]">
    @if($isCurrency) $@endif{{ $value }}
  </div>
</div>
