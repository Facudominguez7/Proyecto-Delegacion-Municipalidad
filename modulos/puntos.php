<header class="bg-gray-800 shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
            Control puntos limpios
        </h1>
        <br>
    </div>
</header>
<div class="flex justify-center mt-10 mb-0">
    <a href="index.php?modulo=agregar-punto">
        <button class="middle none center mr-4 rounded-lg bg-gray-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg hover:shadow-gray-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
            Agregar Punto
        </button>
    </a>
</div>
<div class="mt-10 flex justify-center flex-wrap gap-5 mb-10">
    <?php
    $sqlMostrarPunto = "SELECT puntos.id, puntos.fecha, puntos.descripcion, puntos.titulo, ST_X(ubicacion) AS latitud, ST_Y(ubicacion) AS longitud  FROM puntos";
    $conexion = mysqli_query($con, $sqlMostrarPunto);
    if (mysqli_num_rows($conexion) != 0) {
        while ($dato = mysqli_fetch_array($conexion)) {
            // Obtener la primera imagen de la carpeta del producto
            $carpetaPunto = "imagenes/puntos/" . $dato['id'] . "/";
            $imagenesPunto = glob($carpetaPunto . "*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);

            if (!empty($imagenesPunto)) {
                $primeraImagen = $imagenesPunto[0];
            } else {
                // Si no hay imágenes en la carpeta, puedes proporcionar una imagen predeterminada o manejarlo según tus necesidades.
                $primeraImagen = "../imagenes/default.jpg";
            }
    ?>
            <div class="relative flex w-full max-w-[26rem] flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-lg">
                <div class="relative mx-4 mt-4 overflow-hidden rounded-xl bg-blue-gray-500 bg-clip-border text-white shadow-lg shadow-blue-gray-500/40">
                    <img src="<?php echo $primeraImagen ?>" alt="<?php echo $dato['titulo']; ?>" />
                </div>
                <div class="p-6">
                    <div class="mb-3 flex items-center justify-between">
                        <h5 class="block font-sans text-xl font-medium leading-snug tracking-normal text-blue-gray-900 antialiased">
                            <?php echo $dato['titulo'] ?>
                        </h5>
                        <h5 class="block font-sans text-xl font-medium leading-snug tracking-normal text-blue-gray-900 antialiased">
                            <?php echo date('d/m/Y', strtotime($dato['fecha'])); ?>
                        </h5>
                    </div>
                    <div class="w-full">
                        <textarea class="block w-full h-28 font-sans text-base font-light leading-relaxed text-gray-700 antialiased" readonly>
                            <?php echo $dato['descripcion'] ?>
                        </textarea>
                    </div>
                </div>
                <div class="p-6 pt-3">
                    <div class="flex flex-row justify-between">
                        <a href="#">
                            <button class="block w-full select-none rounded-lg bg-blue-500 py-3.5 px-7 text-center align-middle font-sans text-sm font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" data-ripple-light="true">
                                Detalles
                            </button>
                        </a>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $dato['latitud']; ?>,<?php echo $dato['longitud']; ?>" target="_blank" rel="noopener noreferrer">
                            <button class="block w-full select-none rounded-lg bg-green-500 py-3.5 px-7 text-center align-middle font-sans text-sm font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" data-ripple-light="true">
                                Ir
                            </button>
                        </a>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>
    <!--  -->
</div>