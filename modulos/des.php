<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
</head>

<body>

</body>
<header class="bg-gray-800 shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
            Plazas / Desmalezamiento
        </h1>
        <br>
    </div>
</header>
<form action="index.php" method="GET">
    <input type="hidden" name="modulo" value="des">
    <input type="hidden" name="accion" value="buscar">
    <div class="flex items-center w-1/2 mx-auto bg-white rounded-lg mt-5 " x-data="{ search: '' }">
        <div class="w-full">
            <input type="search" class="w-full px-4 py-1 text-gray-800 rounded-full focus:outline-none" placeholder="Buscar" x-model="search" name="buscar">
        </div>
        <div class="flex flex-row gap-2 ">
            <?php if (isset($_GET['buscar'])) {
            ?>
                <a href="index.php?modulo=des">
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
    <a href="index.php">
        <button class="md:mb-0 mb-5  middle none center mr-4 rounded-lg bg-gray-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg hover:shadow-gray-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
            Volver
        </button>
    </a>
    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3){ ?>
        <a href="index.php?modulo=agregar-des">
            <button class="middle none center mr-4 rounded-lg bg-gray-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg hover:shadow-gray-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                Agregar Tarea
            </button>
        </a>
    <?php } ?>
</div>

<section class="mx-auto w-full max-w-full flex justify-center items-stretch pb-4 px-4 sm:px-6 lg:px-8">
    <table class="border-collapse w-full mt-10">
        <thead>
            <tr>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">CHACRA</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Dirección</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_GET['buscar'])) {
                $busqueda = $_GET['buscar'];
                $sqlbusqueda = "SELECT *, chacras.nombre AS nombreChacra FROM desmalezamientos INNER JOIN chacras ON desmalezamientos.idChacra = chacras.id  WHERE chacras.nombre LIKE '$busqueda%' OR desmalezamientos.titulo LIKE '%$busqueda%'";
                $datosBusqueda = mysqli_query($con, $sqlbusqueda);
                if ($datosBusqueda->num_rows > 0) {
                    while ($filabus = mysqli_fetch_array($datosBusqueda)) {
            ?>
                        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">CHACRA</span>
                                <?php echo $filabus['nombreChacra'] ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 border border-b text-center block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Dirección</span>
                                <?php echo $filabus['titulo'] ?>
                            </td>
                            <td class="flex justify-center flex-col lg:flex-row w-full lg:w-auto p-3 text-gray-800 border border-b text-center lg:table-cell relative lg:static">
                                <!--<span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Acciones</span>-->
                                <a href="index.php?modulo=tareas-des&idDes=<?php echo $filabus['id'] ?>" class="text-yellow-400 hover:text-yellow-600 mt-2 lg:mt-0">
                                    <button class="middle none center mr-4 rounded-lg bg-yellow-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-yellow-500/20 transition-all hover:shadow-lg hover:shadow-yellow-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                        Actividades
                                    </button>
                                </a>
                                <?php if (isset($_SESSION['rol']) && ($_SESSION['rol'] == 2 || $_SESSION['rol'] == 3)) { ?>
                                    <a href="index.php?modulo=editar-des&idDes=<?php echo $filabus['id'] ?>" class="text-green-400 hover:text-green-600 mt-2 lg:mt-0">
                                        <button class="middle none center mr-4 rounded-lg bg-green-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                            Editar
                                        </button>
                                    </a>
                                    <?php if ($_SESSION['rol'] == 2) { ?>
                                        <a href="index.php?modulo=eliminar&id=<?php echo $filabus['id'] ?>&tipo=des" class="text-red-400 hover:text-red-600 mt-2 lg:mt-0">
                                            <button class="middle none center mr-4 rounded-lg bg-red-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                                Eliminar
                                            </button>
                                        </a>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php
                    }
                }
            } else {
                $sqlMostrarChacra = "SELECT des.id, des.titulo, des.idChacra, chacras.nombre AS nombreChacra 
                FROM desmalezamientos des 
                INNER JOIN chacras ON des.idChacra = chacras.id  
                ORDER BY chacras.nombre";
                $datos = mysqli_query($con, $sqlMostrarChacra);
                if ($datos->num_rows > 0) {
                    while ($fila = mysqli_fetch_array($datos)) {
                    ?>
                        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">CHACRA</span>
                                <?php echo $fila['nombreChacra'] ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 border border-b text-center block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Dirección</span>
                                <?php echo $fila['titulo'] ?>
                            </td>
                            <td class="flex justify-center flex-col lg:flex-row w-full lg:w-auto p-3 text-gray-800 border border-b text-center lg:table-cell relative lg:static">
                                <!--<span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Acciones</span>-->
                                <a href="index.php?modulo=tareas-des&idDes=<?php echo $fila['id'] ?>" class="text-yellow-400 hover:text-yellow-600 mt-2 lg:mt-0">
                                    <button class="middle none center mr-4 rounded-lg bg-yellow-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-yellow-500/20 transition-all hover:shadow-lg hover:shadow-yellow-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                        Actividades
                                    </button>
                                </a>
                                <?php if (isset($_SESSION['rol']) && ($_SESSION['rol'] == 2 || $_SESSION['rol'] == 3)) { ?>
                                    <a href="index.php?modulo=editar-des&idDes=<?php echo $fila['id'] ?>" class="text-green-400 hover:text-green-600 mt-2 lg:mt-0">
                                        <button class="middle none center mr-4 rounded-lg bg-green-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                            Editar
                                        </button>
                                    </a>
                                    <?php if ($_SESSION['rol'] == 2) { ?>
                                        <a href="index.php?modulo=eliminar&id=<?php echo $fila['id'] ?>&tipo=des" class="text-red-400 hover:text-red-600 mt-2 lg:mt-0">
                                            <button class="middle none center mr-4 rounded-lg bg-red-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                                Eliminar
                                            </button>
                                        </a>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        </tr>
            <?php
                    }
                }
            }
            ?>
        </tbody>
    </table>
</section>
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