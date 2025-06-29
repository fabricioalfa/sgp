@extends('layouts.app')

@section('title', $modoEdicion ? 'Editar Familiares' : 'Registrar Familiares')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white rounded-xl shadow">
  <h2 class="text-2xl font-bold text-[#C1440E] mb-6">
    {{ $modoEdicion ? 'Editar Familiares' : 'Registrar Familiares' }}
  </h2>

  <form method="POST" action="{{ route('sacramentos.familiares.' . ($modoEdicion ? 'update' : 'store'), $sacramento) }}" id="familiaresForm">
    @csrf

    <div id="fieles-container"></div>

    <div class="mt-6" id="verificacion-certificados">
      <h3 class="text-lg font-semibold text-[#C1440E] mb-2">Verificación de Certificados</h3>
      <div class="space-y-2" id="certificados-checks"></div>
      <p class="text-sm text-gray-600 italic mt-2">Marca los certificados que fueron verificados. Si faltan, el sacramento quedará observado.</p>
    </div>

    <div class="mt-6 flex justify-between">
      <a href="{{ route('sacramentos.index') }}"
         class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
        Cancelar
      </a>
      <button type="submit"
              class="bg-[#E9A209] text-white px-6 py-2 rounded-full shadow hover:bg-[#c98b07] transition">
        Guardar Familiares
      </button>
    </div>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const tipo = @json($sacramento->tipo_sacramento);
    const fielesExistentes = @json($fieles ?? []);
    const modoEdicion = @json($modoEdicion);
    const certificadosVerificados = @json(old('verificado_cert', []));
    const data = {
      bautizo: { familiares: ['padrino', 'madrina', 'padre', 'madre'], certificados: [] },
      comunion: { familiares: ['padrino', 'madrina'], certificados: ['bautizo'] },
      confirmacion: { familiares: ['padrino', 'madrina'], certificados: ['bautizo', 'comunion'] },
      matrimonio: { familiares: ['novio', 'novia', 'padre', 'madre', 'padrino', 'madrina', 'testigo_1', 'testigo_2'], certificados: ['bautizo', 'comunion', 'confirmacion'] },
    };

    const fielesContainer = document.getElementById('fieles-container');
    const certificadosChecks = document.getElementById('certificados-checks');

    const familiares = fielesExistentes.length
      ? fielesExistentes
      : (data[tipo]?.familiares || []).map(tipo => ({
          nombres: '', apellido_paterno: '', apellido_materno: '', correo_electronico: '', telefono: '', tipo_fiel: tipo
        }));

    familiares.forEach((fiel, index) => {
      const block = document.createElement('div');
      block.className = 'grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 border rounded-lg p-4';
      block.innerHTML = `
        <div>
          <label class="text-sm text-gray-700">Nombres</label>
          <input type="text" name="fieles[${index}][nombres]" class="w-full border rounded px-3 py-2" value="${fiel.nombres || ''}" required>
        </div>
        <div>
          <label class="text-sm text-gray-700">Apellido Paterno</label>
          <input type="text" name="fieles[${index}][apellido_paterno]" class="w-full border rounded px-3 py-2" value="${fiel.apellido_paterno || ''}">
        </div>
        <div>
          <label class="text-sm text-gray-700">Apellido Materno</label>
          <input type="text" name="fieles[${index}][apellido_materno]" class="w-full border rounded px-3 py-2" value="${fiel.apellido_materno || ''}">
        </div>
        <div>
          <label class="text-sm text-gray-700">Correo electrónico</label>
          <input type="email" name="fieles[${index}][correo_electronico]" class="w-full border rounded px-3 py-2" value="${fiel.correo_electronico || ''}">
        </div>
        <div>
          <label class="text-sm text-gray-700">Teléfono</label>
          <input type="text" name="fieles[${index}][telefono]" class="w-full border rounded px-3 py-2" value="${fiel.telefono || ''}">
        </div>
        <input type="hidden" name="fieles[${index}][tipo_fiel]" value="${fiel.tipo_fiel}">
        <div class="col-span-full text-sm text-gray-600 italic">Tipo: ${fiel.tipo_fiel}</div>
      `;
      fielesContainer.appendChild(block);
    });

    const certs = data[tipo]?.certificados || [];
    certs.forEach(cert => {
      const isChecked = certificadosVerificados[cert] == '1';
      const label = document.createElement('label');
      label.className = 'flex items-center space-x-2 text-sm text-gray-700';
      label.innerHTML = `
        <input type="checkbox" name="verificado_cert[${cert}]" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring focus:ring-blue-200" ${isChecked ? 'checked' : ''}>
        <span>Certificado de ${cert.charAt(0).toUpperCase() + cert.slice(1)}</span>
      `;
      certificadosChecks.appendChild(label);
    });
  });
</script>
@endsection
