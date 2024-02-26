
document.addEventListener('DOMContentLoaded', function() {
    let latitudInput = document.getElementById('latitud');
    let longitudInput = document.getElementById('longitud');
    let map = L.map('mi_mapa').setView([-27.389449, -55.932426], 13); // Vista inicial centrada en el mapa del mundo
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    let marker;

    function onMapClick(e) {
        if (!marker) {
            marker = L.marker(e.latlng).addTo(map); // Agrega un nuevo marcador en la posición del clic
        } else {
            marker.setLatLng(e.latlng); // Actualiza la posición del marcador existente
        }
        latitudInput.value = e.latlng.lat.toFixed(6);
        longitudInput.value = e.latlng.lng.toFixed(6);
    }

    map.on('click', onMapClick);

    // Obtener la ubicación actual del usuario
    navigator.geolocation.getCurrentPosition(function(position) {
        let latitude = position.coords.latitude;
        let longitude = position.coords.longitude;
        map.setView([latitude, longitude], 13); // Centra el mapa en la ubicación actual del usuario
        if (!marker) {
            marker = L.marker([latitude, longitude]).addTo(map); // Agrega un marcador en la ubicación actual del usuario
        } else {
            marker.setLatLng([latitude, longitude]); // Actualiza la posición del marcador existente
        }
        latitudInput.value = latitude.toFixed(6);
        longitudInput.value = longitude.toFixed(6);
    }, function(error) {
        console.error('Error al obtener la ubicación: ' + error.message);
    });
});
