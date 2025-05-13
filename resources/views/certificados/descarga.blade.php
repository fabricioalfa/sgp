@extends('layouts.app')

@section('title', 'Certificado Generado')

@section('content')
@php
  $rutaPDF = parse_url($pdfUrl, PHP_URL_PATH); // /storage/certificados/archivo.pdf
  $pathInterno = ltrim(str_replace('/storage/', '', $rutaPDF), '/'); // certificados/archivo.pdf
@endphp

<div class="max-w-6xl mx-auto bg-white/60 rounded-xl shadow p-6">
  <h1 class="text-2xl font-bold text-[#C1440E] mb-4">Certificado Generado</h1>

  <div class="overflow-hidden rounded-lg border border-[#F4A261] shadow">
    <iframe src="{{ $pdfUrl }}" class="w-full h-[90vh] rounded-lg"></iframe>
  </div>

  <div class="mt-6 text-right">
    <a href="{{ route('certificados.create') }}"
       class="inline-block bg-[#E9A209] hover:bg-[#c98b07] text-white font-semibold px-5 py-2 rounded-lg shadow transition">
      Volver a emisión
    </a>
  </div>
</div>

<script>
window.addEventListener("beforeunload", () => {
  fetch("{{ route('certificados.eliminarTemporal') }}", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: JSON.stringify({
      path: "{{ $pathInterno }}"
    })
  });
});
</script>
@endsection
