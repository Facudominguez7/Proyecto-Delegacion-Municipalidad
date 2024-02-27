document.addEventListener("DOMContentLoaded", function () {
  let latitudInput = document.getElementById("latitud");
  let longitudInput = document.getElementById("longitud");
  let map = L.map("mi_mapa").setView([-27.389449, -55.932426], 13); // Vista inicial centrada en el mapa del mundo
  L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
      '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
  }).addTo(map);

  let marker;

  function onMapClick(e) {
    if (!marker) {
      marker = L.marker(e.latlng, { draggable: true }).addTo(map); // Agrega un nuevo marcador en la posición del clic
      marker.on("dragend", function (event) {
        let markerLatLng = event.target.getLatLng();
        latitudInput.value = markerLatLng.lat.toFixed(6);
        longitudInput.value = markerLatLng.lng.toFixed(6);
      });
    } else {
      marker.setLatLng(e.latlng); // Actualiza la posición del marcador existente
    }
    latitudInput.value = e.latlng.lat.toFixed(6);
    longitudInput.value = e.latlng.lng.toFixed(6);
  }

  map.on("click", onMapClick);

  // Función para extraer las coordenadas de un enlace de Google Maps
  function extraerCoordenadasGoogleMaps(url) {
    console.log("Enlace recibido:", url); // Verifica si el enlace se recibe correctamente
    // Patrón de expresión regular para extraer las coordenadas de un enlace de Google Maps
    let regex = /@(-?\d+\.\d+),(-?\d+\.\d+)/;
    let match = url.match(regex);
    if (match && match.length >= 3) {
      let latitud = parseFloat(match[1]);
      let longitud = parseFloat(match[2]);
      console.log("Latitud:", latitud, "Longitud:", longitud); // Verifica si las coordenadas se extraen correctamente
      return [latitud, longitud];
    } else {
      return null;
    }
  }

  // Agregar evento al botón de procesamiento
  document
    .querySelector("#boton-ubicacion")
    .addEventListener("click", function (event) {
      let ubicacionInput = document.getElementById("ubicacionInput").value;
      if (ubicacionInput.trim() !== "") {
        // Extraer las coordenadas del enlace de Google Maps
        let coordenadas = extraerCoordenadasGoogleMaps(ubicacionInput);
        if (coordenadas) {
          let latitud = coordenadas[0];
          let longitud = coordenadas[1];
          map.setView([latitud, longitud], 13); // Centra el mapa en las coordenadas extraídas
          if (!marker) {
            marker = L.marker([latitud, longitud], { draggable: true }).addTo(
              map
            ); // Agrega un marcador en las coordenadas extraídas
            marker.on("dragend", function (event) {
              let markerLatLng = event.target.getLatLng();
              latitudInput.value = markerLatLng.lat.toFixed(6);
              longitudInput.value = markerLatLng.lng.toFixed(6);
            });
          } else {
            marker.setLatLng([latitud, longitud]); // Actualiza la posición del marcador existente
          }
          latitudInput.value = latitud.toFixed(6);
          longitudInput.value = longitud.toFixed(6);
        } else {
          alert("El enlace de ubicación no es válido.");
        }
      } else {
        alert("Por favor, ingrese un enlace de ubicación válido.");
      }
    });
});
