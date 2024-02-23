

document.addEventListener('DOMContentLoaded', function() {
    let latitudInput = document.getElementById('latitud');
    let longitudInput = document.getElementById('longitud');
    let map = L.map('mi_mapa').setView([-27.389449, -55.932426], 13); // Vista inicial centrada en el mapa del mundo
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    let marker;

    function onMapClick(e) {
        if (marker) {
            map.removeLayer(marker); // Elimina el marcador existente si hay alguno
        }
        marker = L.marker(e.latlng).addTo(map); // Agrega un nuevo marcador en la posición del clic
        latitudInput.value = e.latlng.lat.toFixed(6);
        longitudInput.value = e.latlng.lng.toFixed(6);
    }

    map.on('click', onMapClick);
});