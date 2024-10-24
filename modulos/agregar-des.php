<?php
if (!empty($_GET['accion'])) {
    if ($_GET['accion'] == 'agregar') {
        $titulo = $_POST['titulo'];
        $idChacra = $_POST['chacra'];
        $latitud = $_POST['latitud'];
        $longitud = $_POST['longitud'];

        // Insertar datos en la tabla de puntos
        $sql = "INSERT INTO desmalezamientos(idChacra, titulo, ubicacion) VALUES (?, ?, ST_GeomFromText(?))";
        $stmtDes = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmtDes, "iss",$idChacra, $titulo, $punto);
        $punto = "POINT($latitud $longitud)";
        mysqli_stmt_execute($stmtDes);

        if (mysqli_error($con)) {
            echo "<script>alert('Error al registrar la tarea: " . mysqli_error($con) . "');</script>";
        } else {
            echo "<script>alert('Tarea registrada correctamente');</script>";
            /*
            // Obtener el ID del producto recién insertado
            $punto_id = mysqli_insert_id($con);
            // Manejar la subida de imágenes
            $carpeta_carga = "imagenes/puntos/" . $punto_id . "/";

            if (!file_exists($carpeta_carga)) {
                if (!mkdir($carpeta_carga, 0777, true)) {
                    echo ('Error al crear el directorio: ' . $carpeta_carga);
                }
            }

            //Foreach que contiene los nombres temporales de los archivos subidos por el usuario
            foreach ($_FILES["lista"]["tmp_name"] as $key => $tmp_name) {
                //basename devuelve la ultima parte de la ruta
                $nombreArchivo = basename($_FILES["lista"]["name"][$key]);
                $archivoDestino = $carpeta_carga . $nombreArchivo;

                "Directorio de destino: " . $carpeta_carga . "<br>";
                "Archivo de destino: " . $archivoDestino . "<br>";

                // Mueve la imagen al directorio de destino del temporal
                if (move_uploaded_file($tmp_name, $archivoDestino)) {
                    // Insertar datos en la tabla de productos_files
                    $sqlInsertImagen = "INSERT INTO fotos_puntos (idPunto, nombreArchivo) VALUES (?, ?)";
                    $stmtImagen = mysqli_prepare($con, $sqlInsertImagen);
                    mysqli_stmt_bind_param($stmtImagen, "is", $punto_id, $nombreArchivo);
                    mysqli_stmt_execute($stmtImagen);

                    if (mysqli_error($con)) {
                        echo "<script>alert('Error al insertar el registro de la imagen en la base de datos: " . mysqli_error($con) . "');</script>";
                    } else {
                    }
                } else {
                    echo "<script>alert('Error al mover la imagen al directorio de destino: " . $archivoDestino . "');</script>";
                }
            }*/

            echo "<script>window.location='index.php?modulo=des';</script>";
        }
    }
}
?>

<head>
    <script defer src="js/contenedor-fotos.js"></script>
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
            <form action="index.php?modulo=agregar-des&accion=agregar" method="POST" enctype="multipart/form-data">
                <div class="mb-5">
                    <label for="titulo" class="mb-3 block text-base font-medium text-[#07074D]">
                        Dirección
                    </label>
                    <input type="text" name="titulo" id="titulo" placeholder="Dirección" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div class="mb-5">
                    <label for="chacra" class="mb-3 block text-base font-medium text-[#07074D]">
                        Seleccione la chacra
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
                        Ubicación
                    </label>
                    <div class="mb-5">
                        <label for="ubicacion" class="flex justify-center mb-3 text-base font-medium text-[#07074D]">
                            Ingrese la ubicación de Google Maps:
                        </label>
                        <input type="text" id="ubicacionInput" placeholder="Pegue aquí el enlace de Google Maps" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"  />
                        <button type="button" id="boton-ubicacion" class="bg-[#6A64F1] py-3 px-4 mt-2 text-base font-medium text-white rounded-md outline-none">Procesar</button>
                    </div>
                    <script defer src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                    <div id="mi_mapa"></div>
                    <input type="text" name="latitud" id="latitud" placeholder="Ej. 40.7128" class="hidden w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required readonly />
                    <input type="text" name="longitud" id="longitud" placeholder="Ej. -74.0060" class="hidden w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required readonly />
                </div>
                <!--
                             <div class="mb-5">
                    <label class="mb-3 block text-base font-medium text-[#07074D]" for="imagen"> Agregar Fotos</label>
                    <div style="position: relative;">
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2 mt-2" id="lista" name="lista[]" type="file" multiple onchange="mostrarVistaPrevia()">
                        <div class="flex w-full overflow-x-scroll">
                            <div id="vista_previa_container" class="flex flex-row flex-nowrap gap-2.5"></div>
                        </div>
                    </div>
                </div>
                -->
           
                <div>
                    <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Agregar
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>