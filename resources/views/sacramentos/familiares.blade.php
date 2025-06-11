@extends('layouts.app')

@section('title', 'Registrar Familiares y Certificados')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white rounded-xl shadow">
  <h2 class="text-2xl font-bold text-[#C1440E] mb-6">Registrar Familiares y Certificados</h2>

  <form method="POST" action="{{ route('sacramentos.familiares.' . (isset($fieles) && count($fieles) ? 'update' : 'store'), $sacramento) }}" enctype="multipart/form-data" id="familiaresForm">
    @csrf

    <div id="fieles-container"></div>
    <div id="certificados-container" class="mt-6"></div>

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
    const data = {
      bautizo: { familiares: ['padrino', 'madrina', 'padre', 'madre'], certificados: [] },
      comunion: { familiares: ['padrino', 'madrina'], certificados: ['bautizo'] },
      confirmacion: { familiares: ['padrino', 'madrina'], certificados: ['bautizo', 'comunion'] },
      matrimonio: { familiares: ['novio', 'novia', 'padre', 'madre', 'padrino', 'madrina', 'testigo_1', 'testigo_2'], certificados: ['bautizo', 'comunion', 'confirmacion'] }
    };

    const fielesContainer = document.getElementById('fieles-container');
    const certificadosContainer = document.getElementById('certificados-container');

    const familiares = fielesExistentes.length
      ? fielesExistentes
      : (data[tipo]?.familiares || []).map(tipo => ({
          nombres: '',
          apellido_paterno: '',
          apellido_materno: '',
          correo_electronico: '',
          telefono: '',
          tipo_fiel: tipo
        }));

    familiares.forEach((fiel, index) => {
      const block = document.createElement('div');
      block.className = 'grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 border rounded-lg p-4';
      block.innerHTML = `
        <div>
          <label class="text-sm text-gray-700">Nombres</label>
          <input type="text" name="fieles[${index}][nombres]" class="w-full border rounded px-3 py-2" value="${fiel.nombres ? escapeHtml(fiel.nombres) : ''}" required>
        </div>
        <div>
          <label class="text-sm text-gray-700">Apellido Paterno</label>
          <input type="text" name="fieles[${index}][apellido_paterno]" class="w-full border rounded px-3 py-2" value="${fiel.apellido_paterno ? escapeHtml(fiel.apellido_paterno) : ''}">
        </div>
        <div>
          <label class="text-sm text-gray-700">Apellido Materno</label>
          <input type="text" name="fieles[${index}][apellido_materno]" class="w-full border rounded px-3 py-2" value="${fiel.apellido_materno ? escapeHtml(fiel.apellido_materno) : ''}">
        </div>
        <div>
          <label class="text-sm text-gray-700">Correo electrónico</label>
          <input type="email" name="fieles[${index}][correo_electronico]" class="w-full border rounded px-3 py-2" value="${fiel.correo_electronico ? escapeHtml(fiel.correo_electronico) : ''}">
        </div>
        <div>
          <label class="text-sm text-gray-700">Teléfono</label>
          <input type="text" name="fieles[${index}][telefono]" class="w-full border rounded px-3 py-2" value="${fiel.telefono ? escapeHtml(fiel.telefono) : ''}">
        </div>
        <input type="hidden" name="fieles[${index}][tipo_fiel]" value="${fiel.tipo_fiel}">
        <div class="col-span-full text-sm text-gray-600 italic">Tipo: ${fiel.tipo_fiel}</div>
      `;
      fielesContainer.appendChild(block);
    });

    const certificados = data[tipo]?.certificados || [];

    if (certificados.length > 0) {
      const title = document.createElement('h3');
      title.className = 'text-lg font-semibold text-[#C1440E] mb-2';
      title.textContent = 'Certificados opcionales';
      certificadosContainer.appendChild(title);

      certificados.forEach(cert => {
        const block = document.createElement('div');
        block.className = 'mb-4';
        block.innerHTML = `
          <label class="block text-sm font-medium text-gray-700">${cert} (PDF o imagen)</label>
          <input type="file" name="certificados[${cert}]" accept=".pdf,image/*" class="w-full border rounded px-3 py-2 bg-white">
        `;
        certificadosContainer.appendChild(block);
      });

      const note = document.createElement('p');
      note.className = 'text-sm text-gray-600 italic mt-2';
      note.textContent = 'Si no se adjuntan los certificados, el sacramento quedará observado.';
      certificadosContainer.appendChild(note);
    }

    function escapeHtml(text) {
      return text.replace(/&/g, "&amp;")
                 .replace(/</g, "&lt;")
                 .replace(/>/g, "&gt;")
                 .replace(/"/g, "&quot;")
                 .replace(/'/g, "&#039;");
    }
  });
</script>
@endsection
