<section class="mt-10">
    <?php
    $idPunto = $_GET['idPunto'];
    $sqlMostrarDetallePunto = "SELECT * FROM puntos WHERE id = $idPunto";
    $datos = mysqli_query($con, $sqlMostrarDetallePunto);
    if ($datos->num_rows > 0) {
        while ($fila = mysqli_fetch_array($datos)) {
    ?>
            <div class="bg-gray-200">
                <div class="flex  items-center justify-center px-4">
                    <div class="max-w-4xl  bg-white w-full rounded-lg shadow-xl">
                        <div class="p-4 border-b">
                            <h2 class="text-2xl ">
                                <?php echo $fila['titulo']; ?>
                            </h2>
                            <p class="text-sm text-gray-500">
                                <?php echo $fila['fecha'];?>
                            </p>
                        </div>
                        <div>
                            <div class="p-4 border-b">
                                <p class="text-gray-600">
                                    Descripción
                                </p>
                                <textarea class="w-full h-32 md:h-48 lg:h-64 xl:h-72" readonly>
                                <?php echo $fila['descripcion']; ?>
                            </textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center items-center flex-col mt-5">
                    <h1 class="text-3xl font-bold tracking-tight flex justify-center text-black mb-6">
                        Fotos de la Actividad
                    </h1>
                    <div class="flex flex-wrap justify-center">
                        <?php
                        $carpetaPunto = "imagenes/puntos/" . $fila['id'] . "/";
                        $imagenesPunto = glob($carpetaPunto . "*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);

                        $imagenes = array();
                        foreach ($imagenesPunto as $imagen) {
                            array_push($imagenes, $imagen);
                        }
                        // Verificar si $imagenes está definida y no es null
                        if (isset($imagenes) && is_array($imagenes) && count($imagenes) > 0) {
                            // Iterar sobre las imágenes
                            foreach ($imagenes as $index => $imagen) {
                                echo '<img class="w-full md:w-1/4 h-1/2 md:h-1/2 mb-2 md:mb-0 md:mr-2 md:mt-2" src="' . $imagen . '"/>';
                            }
                        } else {
                            echo "No se encontraron imágenes";
                        }
                        ?>
                    </div>
                </div>
            </div>


    <?php
        }
    }
    ?>

</section>