<!-- Leaflet CSS y JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
  window.addEventListener('DOMContentLoaded', function () {
    // === Estipendio por tipo de misa ===
    const precios = {
      @foreach($tiposMisa as $tipo => $monto)
        '{{ $tipo }}': {{ $monto }},
      @endforeach
    };
    const tipoSelect = document.getElementById('tipo_misa');
    const estipendioInput = document.getElementById('estipendio');

    function asignarEstipendio() {
      const tipo = tipoSelect.value;
      estipendioInput.value = precios[tipo] ?? 0;
    }
    tipoSelect.addEventListener('change', asignarEstipendio);
    asignarEstipendio();

    // === Mapa Leaflet ===
    const latInput = document.getElementById('latitud');
    const lngInput = document.getElementById('longitud');
    const lugarInput = document.querySelector('input[name="lugar"]');

    const defaultLat = parseFloat(latInput.value) || -16.513212;
    const defaultLng = parseFloat(lngInput.value) || -68.127465;

    const map = L.map('map').setView([defaultLat, defaultLng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker = null;
    if (latInput.value && lngInput.value) {
      marker = L.marker([latInput.value, lngInput.value]).addTo(map);
    }

    map.on('click', function (e) {
      const lat = e.latlng.lat.toFixed(6);
      const lng = e.latlng.lng.toFixed(6);
      latInput.value = lat;
      lngInput.value = lng;

      if (marker) {
        marker.setLatLng(e.latlng);
      } else {
        marker = L.marker(e.latlng).addTo(map);
      }
    });

    // === Geocodificación con restricción a La Paz ===
    let geoTimeout = null;
    lugarInput.addEventListener('input', function () {
      clearTimeout(geoTimeout);
      const lugar = lugarInput.value.trim();
      if (lugar.length < 4) return;

      geoTimeout = setTimeout(() => {
        const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(lugar)}&viewbox=-68.27,-16.45,-68.08,-16.62&bounded=1`;

        fetch(url)
          .then(res => res.json())
          .then(data => {
            if (data && data.length > 0) {
              const lat = parseFloat(data[0].lat).toFixed(6);
              const lon = parseFloat(data[0].lon).toFixed(6);
              const newLatLng = [lat, lon];

              latInput.value = lat;
              lngInput.value = lon;

              map.setView(newLatLng, 16);
              if (marker) {
                marker.setLatLng(newLatLng);
              } else {
                marker = L.marker(newLatLng).addTo(map);
              }
            }
          });
      }, 1000);
    });
  });
</script>
