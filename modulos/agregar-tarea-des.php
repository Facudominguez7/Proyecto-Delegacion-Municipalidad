<?php
if (!empty($_GET['accion'])) {
    $idDes = $_GET['idDes'];
    if ($_GET['accion'] == 'agregar') {
        $titulo = $_POST['titulo'];
        $fecha = $_POST['fecha'];
        $descripcion = $_POST['descripcion'];

        /* Verificación de la tarea 
        $sql_verificar = "SELECT * FROM tareas_des WHERE titulo = ?";
        $stmt_verificar = mysqli_prepare($con, $sql_verificar);
        mysqli_stmt_bind_param($stmt_verificar, "s", $titulo);
        mysqli_stmt_execute($stmt_verificar);
        mysqli_stmt_store_result($stmt_verificar);
        */

        /*if (mysqli_stmt_num_rows($stmt_verificar) != 0) {
            echo "<script> alert('ESTA ACTIVIDAD YA EXISTE EN LA BASE DE DATOS');</script>";
        } else {
         */
            // Insertar datos en la tabla de tareas
            $sqlInsertTarea = "INSERT INTO tareas_des(titulo, fecha, descripcion, idDes) VALUES (?, ?, ?, ?)";
            $stmtTarea = mysqli_prepare($con, $sqlInsertTarea);
            mysqli_stmt_bind_param($stmtTarea, "sssi", $titulo, $fecha, $descripcion, $idDes);
            mysqli_stmt_execute($stmtTarea);

            if (mysqli_error($con)) {
                echo "<script>alert('Error al registrar la actividad: " . mysqli_error($con) . "');</script>";
            } else {
                echo "<script>alert('Actividad registrada correctamente');</script>";
                // Obtener el ID del producto recién insertado
                $tarea_id = mysqli_insert_id($con);
                // Manejar la subida de imágenes
                $carpeta_carga = "imagenes/tareas_des/" . $tarea_id . "/";

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
                        $sqlInsertImagen = "INSERT INTO fotos_des(idTareaDes, nombreArchivo) VALUES (?, ?)";
                        $stmtImagen = mysqli_prepare($con, $sqlInsertImagen);
                        mysqli_stmt_bind_param($stmtImagen, "is", $tarea_id, $nombreArchivo);
                        mysqli_stmt_execute($stmtImagen);

                        if (mysqli_error($con)) {
                            echo "<script>alert('Error al insertar el registro de la imagen en la base de datos: " . mysqli_error($con) . "');</script>";
                        } else {
                        }
                    } else {
                        echo "<script>alert('Error al mover la imagen al directorio de destino: " . $archivoDestino . "');</script>";
                    }
                }
            }
            echo "<script>window.location='index.php?modulo=tareas-des&idDes=" . $idDes . "';</script>";
        }
    }
//}
?>

<head>
    <script defer src="js/contenedor-fotos.js"></script>
</head>
<section>
    <div class="flex items-center justify-center p-12">
        <div class="mx-auto w-full max-w-[550px]">
            <form action="index.php?modulo=agregar-tarea-des&accion=agregar&idDes=<?php echo $_GET['idDes'] ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-5">
                    <label for="titulo" class="mb-3 block text-base font-medium text-[#07074D]">
                        Título
                    </label>
                    <input type="text" name="titulo" id="titulo" placeholder="Título" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div class="mb-5">
                    <label for="fecha" class="mb-3 block text-base font-medium text-[#07074D]">
                        Fecha
                    </label>
                    <input type="date" name="fecha" id="fecha" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div class="mb-5">
                    <label for="descripcion" class="mb-3 block text-base font-medium text-[#07074D]">
                        Descripción
                    </label>
                    <textarea name="descripcion" id="descripcion" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required> </textarea>
                </div>
                <div class="mb-5">
                    <label class="mb-3 block text-base font-medium text-[#07074D]" for="imagen"> Agregar Fotos</label>
                    <div style="position: relative;">
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2 mt-2" id="lista" name="lista[]" type="file" multiple onchange="mostrarVistaPrevia()">
                        <div class="flex w-full overflow-x-scroll">
                            <div id="vista_previa_container" class="flex flex-row flex-nowrap gap-2.5"></div>
                        </div>
                    </div>
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