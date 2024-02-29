<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
</head>
<header class="bg-gray-800 shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
            Control puntos limpios
        </h1>
        <br>
    </div>
</header>
<div class="flex justify-center flex-row mt-5 mb-2">
    <a href="index.php?modulo=puntos">
        <button class="middle none center mr-4 rounded-lg bg-gray-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg hover:shadow-gray-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
            Volver
        </button>
    </a>
    <a href="index.php?modulo=agregar-tarea-punto&idPunto=<?php echo $_GET['idPunto'] ?>">
        <button class="middle none center mr-4 rounded-lg bg-gray-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg hover:shadow-gray-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
            Agregar Tarea
        </button>
    </a>
</div>
<div class="flex flex-col lg:flex-row lg:justify-evenly mt-5">
    <div class="w-full lg:w-1/2">
        <?php
        $idPunto = $_GET['idPunto'];
        $sqlMostrarPunto = "SELECT puntos.titulo AS nombre, ST_X(ubicacion) AS latitud, ST_Y(ubicacion) AS longitud   
                FROM puntos
                WHERE id = $idPunto";
        $datos = mysqli_query($con, $sqlMostrarPunto);
        if ($datos->num_rows > 0) {
            while ($fila = mysqli_fetch_array($datos)) {
        ?>
                <input id="latidudInput" class="hidden" type="text" value="<?php echo $fila['latitud'] ?>" readonly>
                <input id="longitudInput" class="hidden" type="text" value="<?php echo $fila['longitud'] ?>" readonly>
                <input id="nombreInput" class="hidden" type="text" value="<?php echo $fila['nombre'] ?>" readonly>

                <div class="flex justify-center items-center flex-col">
                    <div id="mi_mapa" class="hidden  md:block md:w-96 md:h-96"></div>
                    <a id="googleMapsLink" href="" target="_blank" rel="noopener noreferrer">
                        <button class="mt-2 middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                            Abrir Ubicacion
                        </button>
                    </a>
                </div>

                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let latitud = document.getElementById('latidudInput').value;
                        let longitud = document.getElementById('longitudInput').value;
                        let nombreUbicacion = document.getElementById('nombreInput').value

                        let map = L.map('mi_mapa').setView([latitud, longitud], 16.4);

                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);

                        L.marker([latitud, longitud]).addTo(map).bindPopup(nombreUbicacion).openPopup();

                        let googleMapsLink = document.getElementById('googleMapsLink');
                        googleMapsLink.href = `https://www.google.com/maps/dir/?api=1&destination=${latitud},${longitud}`;
                    });
                </script>
        <?php
            }
        }
        ?>
    </div>

    <div class="w-full lg:w-4/6">
        <table class="border-collapse w-full mt-10">
            <thead>
                <tr>
                    <th class="p-3 font-bold uppercase bg-gray-400 text-white border border-gray-300 hidden xl:table-cell">Título</th>
                    <th class="p-3 font-bold uppercase bg-gray-400 text-white border border-gray-300 hidden xl:table-cell">Fecha</th>
                    <th class="p-3 font-bold uppercase bg-gray-400 text-white border border-gray-300 hidden xl:table-cell">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $idPunto = $_GET['idPunto'];
                $sqlMostrarTarea = "SELECT t.id, t.titulo, t.fecha   
                 FROM tareas_puntos AS t
                 WHERE t.idPunto = $idPunto
                 ORDER BY t.fecha DESC";
                $datos = mysqli_query($con, $sqlMostrarTarea);
                if ($datos->num_rows > 0) {
                    while ($fila = mysqli_fetch_array($datos)) {
                ?>
                        <td class="w-full xl:w-auto p-3 text-gray-800 text-center border border-b block xl:table-cell relative xl:static">
                            <span class="xl:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Título</span>
                            <?php echo $fila['titulo'] ?>
                        </td>
                        <td class="w-full xl:w-auto p-3 text-gray-800 border border-b text-center block xl:table-cell relative xl:static">
                            <span class="xl:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Fecha</span>
                            <?php echo date('d/m/Y', strtotime($fila['fecha'])); ?>
                        </td>
                        <td class="flex justify-center flex-col xl:flex-row w-full xl:w-auto p-3 text-gray-800 border border-b text-center xl:table-cell relative xl:static">
                            <?php $idPunto = $_GET['idPunto'] ?>
                            <a href="index.php?modulo=detalle-puntos&idPunto=<?php echo $fila['id'] ?>" class="text-yellow-400 hover:text-yellow-600">
                                <button class="mb-2 xl:mb-0 middle none center mr-4 rounded-lg bg-yellow-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-yellow-500/20 transition-all hover:shadow-lg hover:shadow-yellow-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                    Detalles
                                </button>
                            </a>
                            <?php $idPunto = $_GET['idPunto'] ?>
                            <a href="index.php?modulo=eliminar&idPunto=<?php echo $idPunto; ?>&id=<?php echo $fila['id'] ?>&tipo=tareas" class="text-red-400 hover:text-red-600">
                                <button class="mb-2 xl:mb-0 middle none center mr-4 rounded-lg bg-red-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                    Eliminar
                                </button>
                            </a>
                        </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                <?php
                }

                ?>

            </tbody>
        </table>
        </section>
    </div>
</div>