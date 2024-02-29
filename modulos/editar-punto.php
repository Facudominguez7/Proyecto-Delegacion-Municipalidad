<?php
if (isset($_GET['accion'])) {
    if ($_GET['accion'] == 'editar') {
        $idPunto = $_POST['id'];
        $idChacra = $_POST['chacra'];
        $titulo = $_POST['titulo'];
        $latitud = $_POST['latitud'];
        $longitud = $_POST['longitud'];

        $sql = "UPDATE puntos SET titulo=?, idChacra=?, ubicacion=POINT(?, ?) WHERE id=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sissi", $titulo, $idChacra, $latitud, $longitud, $idPunto);
        mysqli_stmt_execute($stmt);

        // Verificar si se produjeron errores
        if (mysqli_stmt_error($stmt)) {
            echo "Error al actualizar el punto: " . mysqli_stmt_error($stmt);
        } else {
            echo "<script>alert('Punto Actualizado con Éxito');</script>";
        }
        // Cerrar la declaración preparada
        mysqli_stmt_close($stmt);
    }
    echo "<script>window.location='index.php?modulo=puntos';</script>";
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
            $idPunto = $_GET['idPunto'];
            $sql = "SELECT puntos.id, puntos.titulo, chacras.nombre as nombreChacra, ST_X(puntos.ubicacion) as latitud, ST_Y(puntos.ubicacion) as longitud 
            From puntos 
            INNER JOIN chacras ON puntos.idChacra = chacras.id 
            WHERE puntos.id = $idPunto";
            $sql = mysqli_query($con, $sql);
            if (mysqli_num_rows($sql) != 0) {
                $r = mysqli_fetch_array($sql);
            }
            ?>
            <form action="index.php?modulo=editar-punto&accion=editar" method="POST">
                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                        Título
                    </label>
                    <input type="text" name="titulo" id="titulo" value="<?php echo $r['titulo'] ?>" placeholder="Nombre de la chacra" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                        Chacra Actual
                    </label>
                    <input type="text"  value="<?php echo $r['nombreChacra'] ?>" placeholder="Nombre de la chacra" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" readonly />
                    <label for="name" class="mt-2 mb-3 block text-base font-medium text-[#07074D]">
                        Seleccione la nueva chacra
                    </label>
                    <select name="chacra" id="chacra" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                        <?php
                        $sqlMostrarChacras = "SELECT chacras.nombre, chacras.id FROM chacras ORDER BY chacras.nombre DESC";
                        $stmtChacras = mysqli_prepare($con, $sqlMostrarChacras);
                        mysqli_stmt_execute($stmtChacras);
                        $resultChacras = mysqli_stmt_get_result($stmtChacras);

                        if ($resultChacras->num_rows > 0) {
                            while ($filaChacras = mysqli_fetch_array($resultChacras)) {
                        ?>
                                <option value="<?php echo $filaChacras['id'] ?>"><?php echo $filaChacras['nombre'] ?></option>
                            <?php
                            }
                        } else {
                            ?>
                            <h1>No se agregaron chacras</h1>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="ubicacion" class="flex justify-center mb-3 text-base font-medium text-[#07074D]">
                        Ingrese la nueva ubicación:
                    </label>
                    <div id="mi_mapa" class="hidden  md:block md:w-96 md:h-96"></div>
                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                    <input id="latidudInput" class="hidden" type="text" value="<?php echo $r['latitud'] ?>" readonly>
                    <input id="longitudInput" class="hidden" type="text" value="<?php echo $r['longitud'] ?>" readonly>
                    <input id="nombreInput" class="hidden" type="text" value="<?php echo $r['nombreChacra'] ?>" readonly>
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
                <div>
                    <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Editar
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>