<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
</head>

<body>

</body>
<header class="bg-gray-800 shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
            Control puntos limpios
        </h1>
        <br>
    </div>
</header>
<form action="index.php" method="GET">
    <input type="hidden" name="modulo" value="puntos">
    <input type="hidden" name="accion" value="buscar">
    <div class="flex items-center w-1/2 mx-auto bg-white rounded-lg mt-5 " x-data="{ search: '' }">
        <div class="w-full">
            <input type="search" class="w-full px-4 py-1 text-gray-800 rounded-full focus:outline-none" placeholder="Buscar" x-model="search" name="buscar">
        </div>
        <div class="flex flex-row gap-2 ">
            <?php if (isset($_GET['buscar'])) {
            ?>
                <a href="index.php?modulo=puntos">
                    <button type="button" class="flex items-center bg-blue-500 justify-center w-12 h-12 text-white rounded-r-lg" :class="(search.length > 0) ? 'bg-purple-500' : 'bg-gray-500 cursor-not-allowed'" :disabled="search.length == 0">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M463.5 224H472c13.3 0 24-10.7 24-24V72c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1c-87.5 87.5-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H463.5z" />
                        </svg>
                    </button>
                </a>
            <?php
            } else {
            ?>
                <button type="submit" class="flex items-center bg-blue-500 justify-center w-12 h-12 text-white  rounded-r-lg" :class="(search.length > 0) ? 'bg-purple-500' : 'bg-gray-500 cursor-not-allowed'" :disabled="search.length == 0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            <?php
            }
            ?>
        </div>
    </div>
</form>
<div class="flex justify-center mt-10 mb-0">
    <a href="index.php?modulo=agregar-punto">
        <button class="middle none center mr-4 rounded-lg bg-gray-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg hover:shadow-gray-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
            Agregar Punto
        </button>
    </a>
</div>
<div class="mt-10 flex justify-center flex-wrap gap-5 mb-10">
    <?php
    if (isset($_GET['buscar'])) {
        $busqueda = $_GET['buscar'];
        $sqlbusqueda = "SELECT puntos.id, puntos.fecha, puntos.descripcion, puntos.titulo, ST_X(ubicacion) AS latitud, ST_Y(ubicacion) AS longitud  FROM puntos WHERE titulo LIKE '$busqueda%'";
        $datosBusqueda = mysqli_query($con, $sqlbusqueda);
        if ($datosBusqueda->num_rows > 0) {
            while ($filabus = mysqli_fetch_array($datosBusqueda)) {

    ?>
                <div class="relative flex w-full max-w-[26rem] flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-lg">
                    <div class="relative mx-4 mt-4 overflow-hidden rounded-xl bg-blue-gray-500 bg-clip-border text-white shadow-lg shadow-blue-gray-500/40 flex justify-center items-center">
                        <div class="map-container block w-96 h-96" data-latitud="<?php echo $filabus['latitud']; ?>" data-longitud="<?php echo $filabus['longitud']; ?>">

                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-3 flex items-center justify-between">
                            <h5 class="block font-sans text-xl font-medium leading-snug tracking-normal text-blue-gray-900 antialiased">
                                <?php echo $filabus['titulo'] ?>
                            </h5>
                            <h5 class="block font-sans text-xl font-medium leading-snug tracking-normal text-blue-gray-900 antialiased">
                                <?php echo date('d/m/Y', strtotime($filabus['fecha'])); ?>
                            </h5>
                        </div>
                        <div class="w-full">
                            <textarea class="block w-full h-28 font-sans text-base font-light leading-relaxed text-gray-700 antialiased" readonly>
                            <?php echo $filabus['descripcion'] ?>
                        </textarea>
                        </div>
                    </div>
                    <div class="p-6 pt-3">
                        <div class="flex flex-row justify-between">
                            <a href="index.php?modulo=detalle-puntos&idPunto=<?php echo $filabus['id'] ?>">
                                <button class="block w-full select-none rounded-lg bg-blue-500 py-3.5 px-7 text-center align-middle font-sans text-sm font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" data-ripple-light="true">
                                    Detalles
                                </button>
                            </a>
                            <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $filabus['latitud']; ?>,<?php echo $filabus['longitud']; ?>" target="_blank" rel="noopener noreferrer">
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
    } else {
        $sqlMostrarPunto = "SELECT puntos.id, puntos.fecha, puntos.descripcion, puntos.titulo, ST_X(ubicacion) AS latitud, ST_Y(ubicacion) AS longitud  FROM puntos";
        $conexion = mysqli_query($con, $sqlMostrarPunto);
        if (mysqli_num_rows($conexion) != 0) {
            while ($dato = mysqli_fetch_array($conexion)) {
            ?>
                <div class="relative flex w-full max-w-[26rem] flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-lg">
                    <div class="relative mx-4 mt-4 overflow-hidden rounded-xl bg-blue-gray-500 bg-clip-border text-white shadow-lg shadow-blue-gray-500/40 flex justify-center items-center">
                        <div class="map-container block w-96 h-96" data-latitud="<?php echo $dato['latitud']; ?>" data-longitud="<?php echo $dato['longitud']; ?>">

                        </div>
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
                            <a href="index.php?modulo=detalle-puntos&idPunto=<?php echo $dato['id'] ?>">
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
    }
    ?>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        // Seleccionar todos los contenedores de mapa
        let mapContainers = document.querySelectorAll('.map-container');

        // Iterar sobre los contenedores y crear el mapa para cada uno
        mapContainers.forEach(function(container) {
            let latitud = parseFloat(container.getAttribute('data-latitud'));
            let longitud = parseFloat(container.getAttribute('data-longitud'));

            // Crear el mapa en el contenedor actual
            let map = L.map(container).setView([latitud, longitud], 12);

            // Agregar capa de azulejos de OpenStreetMap al mapa
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Agregar marcador al mapa
            L.marker([latitud, longitud]).addTo(map);
        });
    });
</script>