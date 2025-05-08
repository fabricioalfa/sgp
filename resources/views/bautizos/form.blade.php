@php
  $tipos = ['bautizo' => 'Bautizo', 'comunion' => 'Primera Comunión', 'confirmacion' => 'Confirmación', 'matrimonio' => 'Matrimonio'];
@endphp

<div>
  <label class="block text-sm font-semibold">Iglesia</label>
  <input type="text" name="iglesia" value="{{ old('iglesia') }}" class="w-full border px-3 py-2 rounded" required>
</div>

<!-- Nombre del Padrino -->
<div class="grid grid-cols-2 gap-4">
  <div>
    <label class="block text-sm font-semibold">Nombre Padrino</label>
    <input type="text" name="nombre_padrino" value="{{ old('nombre_padrino') }}" class="w-full border px-3 py-2 rounded" required>
  </div>
  <div>
    <label class="block text-sm font-semibold">Apellido Paterno Padrino</label>
    <input type="text" name="apellido_paterno_padrino" value="{{ old('apellido_paterno_padrino') }}" class="w-full border px-3 py-2 rounded" required>
  </div>
</div>

<!-- Madrina -->
<div class="grid grid-cols-2 gap-4">
  <div>
    <label class="block text-sm font-semibold">Nombre Madrina</label>
    <input type="text" name="nombre_madrina" value="{{ old('nombre_madrina') }}" class="w-full border px-3 py-2 rounded" required>
  </div>
  <div>
    <label class="block text-sm font-semibold">Apellido Paterno Madrina</label>
    <input type="text" name="apellido_paterno_madrina" value="{{ old('apellido_paterno_madrina') }}" class="w-full border px-3 py-2 rounded" required>
  </div>
</div>

<!-- Sacerdote celebrante -->
<div>
  <label class="block text-sm font-semibold">Sacerdote Celebrante</label>
  <input type="text" name="sacerdote_celebrante" value="{{ old('sacerdote_celebrante') }}" class="w-full border px-3 py-2 rounded" required>
</div>
