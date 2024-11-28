<?php
if (isset($_GET['accion'])) {
    if ($_GET['accion'] == 'editar') {
        $idChacra = $_POST['id'];
        $nombre = $_POST['nombre'];
        $presidente = $_POST['presidente'];
        $telefono = $_POST['telefono'];
        $latitud = $_POST['latitud'];
        $longitud = $_POST['longitud'];
        $descripcion = $_POST['descripcion'];

        $sqlEditarChacra = "UPDATE chacras SET nombre=?, presidente=?, numPresidente=?, ubicacion=POINT(?, ?), descripcion=? WHERE id=?";
        $stmt = mysqli_prepare($con, $sqlEditarChacra);
        mysqli_stmt_bind_param($stmt, "ssiddsi", $nombre, $presidente, $telefono, $latitud, $longitud, $descripcion, $idChacra);
        mysqli_stmt_execute($stmt);

        // Verificar si se produjeron errores
        if (mysqli_stmt_error($stmt)) {
            echo "Error al actualizar la chacra: " . mysqli_stmt_error($stmt);
        } else {
            echo "<script>alert('Chacra Actualizada con Éxito');</script>";
        }
        // Cerrar la declaración preparada
        mysqli_stmt_close($stmt);
    }
    echo "<script>window.location='index.php?modulo=chacras';</script>";
}

?>

<head>
    <script defer src="js/mapa.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #mi_mapa {
            width: 100%;
            height: 400px;
            /* Establece una altura inicial */
            max-width: 100%;
            /* Limita el ancho máximo del mapa */
            max-height: 500px;
            /* Limita la altura máxima del mapa */
        }
    </style>
</head>
<section>
    <div class="flex items-center justify-center p-12">
        <div class="mx-auto w-full max-w-[550px]">
            <?php
            $idChacra = $_GET['idChacra'];
            $sql = "SELECT id, nombre, presidente,descripcion, numPresidente, ST_X(ubicacion) as latitud, ST_Y(ubicacion) as longitud From chacras WHERE chacras.id = $idChacra";
            $sql = mysqli_query($con, $sql);
            if (mysqli_num_rows($sql) != 0) {
                $r = mysqli_fetch_array($sql);
            }
            ?>
            <form action="index.php?modulo=editar-chacra&accion=editar" method="POST">
                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                        Nombre
                    </label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $r['nombre'] ?>" placeholder="Nombre de la chacra" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
                <div class="mb-5">
                    <label for="presidente" class="mb-3 block text-base font-medium text-[#07074D]">
                        Presidente
                    </label>
                    <input type="text" name="presidente" id="presidente" value="<?php echo $r['presidente'] ?>" placeholder="Apellido y Nombre" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
                <div class="mb-5">
                    <label for="dni" class="mb-3 block text-base font-medium text-[#07074D]">
                        Numero del Presidente
                    </label>
                    <input type="number" name="telefono" id="telefono" value="<?php echo $r['numPresidente'] ?>" placeholder="Número de Teléfono del Presidente" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
                <div class="mb-5">
                    <label for="ubicacion" class="flex justify-center mb-3 text-base font-medium text-[#07074D]">
                        Ingrese la nueva ubicación:
                    </label>
                    <div id="mi_mapa" class="hidden  md:block md:w-96 md:h-96"></div>
                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                    <input id="latidudInput" class="hidden" type="text" value="<?php echo $r['latitud'] ?>" readonly>
                    <input id="longitudInput" class="hidden" type="text" value="<?php echo $r['longitud'] ?>" readonly>
                    <input id="nombreInput" class="hidden" type="text" value="<?php echo $r['nombre'] ?>" readonly>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let latitud = parseFloat(document.getElementById('latidudInput').value);
                            let longitud = parseFloat(document.getElementById('longitudInput').value);
                            let nombreUbicacion = document.getElementById('nombreInput').value;

                            let map = L.map('mi_mapa').setView([latitud, longitud], 16.4);

                            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);

                            let marker = L.marker([latitud, longitud], {
                                draggable: true
                            }).addTo(map).bindPopup(nombreUbicacion).openPopup();

                            // Función para actualizar las coordenadas en los campos de entrada
                            function updateCoordinates(lat, lng) {
                                document.getElementById('latitud').value = lat;
                                document.getElementById('longitud').value = lng;
                            }

                            // Evento para actualizar las coordenadas cuando el marcador se mueve
                            marker.on('dragend', function(event) {
                                let marker = event.target;
                                let position = marker.getLatLng();
                                updateCoordinates(position.lat, position.lng);
                            });

                            // Evento para actualizar el marcador cuando se hace clic en el mapa
                            map.on('click', function(event) {
                                let latlng = event.latlng;
                                marker.setLatLng(latlng);
                                updateCoordinates(latlng.lat, latlng.lng);
                            });
                        });
                    </script>
                    <input type="text" name="latitud" id="latitud" placeholder="Ej. 40.7128" value="<?php echo $r['latitud'] ?>" class="hidden w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required readonly />
                    <input type="text" name="longitud" id="longitud" placeholder="Ej. -74.0060" value="<?php echo $r['longitud'] ?>" class="hidden w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required readonly />
                    <input type="number" name="id" id="idChacra" value="<?php echo $r['id'] ?>" class="hidden w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
                <div class="mb-5">
                    <label for="descripcion" class="mb-3 block text-base font-medium text-[#07074D]">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"><?php echo $r['descripcion']; ?></textarea>
                </div>
                <div>
                    <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Editar
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>