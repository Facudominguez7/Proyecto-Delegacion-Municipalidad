<?php
if (!empty($_GET['accion'])) {
    if ($_GET['accion'] == 'agregar') {
        $nombre = $_POST['nombre'];
        $presidente = $_POST['presidente'];
        $telefono = $_POST['telefono'];
        $latitud = $_POST['latitud'];
        $longitud = $_POST['longitud'];

        // Verificación de la chacra 
        $sql_verificar = "SELECT * FROM chacras WHERE nombre = ?";
        $stmt_verificar = mysqli_prepare($con, $sql_verificar);
        mysqli_stmt_bind_param($stmt_verificar, "s", $nombre);
        mysqli_stmt_execute($stmt_verificar);
        mysqli_stmt_store_result($stmt_verificar);

        if (mysqli_stmt_num_rows($stmt_verificar) != 0) {
            echo "<script> alert('ESTA CHACRA YA EXISTE EN LA BASE DE DATOS');</script>";
        } else {
            // Insertar chacra
            $sql_insertar = "INSERT INTO chacras (nombre, presidente, numPresidente, ubicacion) VALUES (?, ?, ?, ST_GeomFromText(?))";
            $stmt_insertar = mysqli_prepare($con, $sql_insertar);
            mysqli_stmt_bind_param($stmt_insertar, "ssis", $nombre, $presidente, $telefono, $punto);
            $punto = "POINT($latitud $longitud)";
            mysqli_stmt_execute($stmt_insertar);

            if (mysqli_stmt_error($stmt_insertar)) {
                echo "<script>alert('Error no se pudo insertar el registro');</script>";
            } else {
                echo "<script>alert('Chacra Agregada con Exito');</script>";
            }
        }
    }
    echo "<script>window.location='index.php?modulo=chacras';</script>";
}
?>

<head>
    <script defer src="js/contenedor-fotos.js"></script>
    <script src="js/mapa.js"></script>
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
            <form action="index.php?modulo=agregar-chacra&accion=agregar" method="POST">
                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                        Nombre
                    </label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre de la chacra" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div class="mb-5">
                    <label for="presidente" class="mb-3 block text-base font-medium text-[#07074D]">
                        Presidente
                    </label>
                    <input type="text" name="presidente" id="presidente" placeholder="Apellido y Nombre" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div class="mb-5">
                    <label for="presidente" class="mb-3 block text-base font-medium text-[#07074D]">
                        Número de teléfono del Presidente
                    </label>
                    <input type="number" name="telefono" id="telefono" placeholder="telefono" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div class="mb-5">
                    <label for="ubicacion" class="flex justify-center mb-3 text-base font-medium text-[#07074D]">
                        Ubicación
                    </label>
                    <div class="mb-5">
                        <label for="ubicacion" class="flex justify-center mb-3 text-base font-medium text-[#07074D]">
                            Ingrese la ubicación de Google Maps:
                        </label>
                        <input type="text" id="ubicacionInput" placeholder="Pegue aquí el enlace de Google Maps" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                        <button type="button" id="boton-ubicacion" class="bg-[#6A64F1] py-3 px-4 mt-2 text-base font-medium text-white rounded-md outline-none">Procesar</button>
                    </div>
                    <script defer src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                    <div id="mi_mapa"></div>
                    <input type="text" name="latitud" id="latitud" placeholder="Ej. 40.7128" class="hidden w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required readonly />
                    <input type="text" name="longitud" id="longitud" placeholder="Ej. -74.0060" class="hidden w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required readonly />
                </div>
                <div>
                    <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Agregar
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>