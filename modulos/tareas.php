<head>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
</head>
<header class="bg-gray-800 shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
        <?php
        $idChacra = $_GET['idChacra'];
        $sqlMostrarChacra = "SELECT chacras.id, chacras.nombre, chacras.presidente, ST_X(ubicacion) AS latitud, ST_Y(ubicacion) AS longitud   
                 FROM chacras
                 WHERE chacras.id = $idChacra";
        $datos = mysqli_query($con, $sqlMostrarChacra);
        if ($datos->num_rows > 0) {
            while ($fila = mysqli_fetch_array($datos)) {
        ?>
                <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
                    Actividad <?php echo $fila['nombre'] ?>
                </h1>
                <br>
                <p class="text-3xl tracking-tight flex justify-center text-white">
                    Comisión: Pres. <?php echo $fila['presidente'] ?>
                </p>
                <br>
            <?php
            }
        } else {
            ?>
            <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
                Se perdió el registro
            </h1>
            <br />
        <?php
        }

        ?>
    </div>
</header>
<div class="flex justify-center mt-10 mb-0">
    <a href="index.php?modulo=agregar-tarea&idChacra=<?php echo $idChacra ?>">
        <button class="middle none center mr-4 rounded-lg bg-gray-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg hover:shadow-gray-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
            Agregar Tarea
        </button>
    </a>
</div>
<div class="flex flex-col lg:flex-row lg:justify-evenly mt-5">
    <div class="w-full lg:w-1/2">
            <?php
            $sqlMostrarChacra = "SELECT chacras.presidente, ST_X(ubicacion) AS latitud, ST_Y(ubicacion) AS longitud   
                FROM chacras
                WHERE chacras.id = $idChacra";
            $datos = mysqli_query($con, $sqlMostrarChacra);
            if ($datos->num_rows > 0) {
                while ($fila = mysqli_fetch_array($datos)) {
            ?>
                    <input id="latidudInput" class="hidden" type="text" value="<?php echo $fila['latitud'] ?>" readonly>
                    <input id="longitudInput" class="hidden" type="text" value="<?php echo $fila['longitud'] ?>" readonly>
                    <input id="presidenteInput" class="hidden" type="text" value="<?php echo $fila['presidente'] ?>" readonly>

                    <div class="flex justify-center items-center flex-col">
                        <div id="mi_mapa" class="hidden  md:block md:w-96 md:h-96"></div>
                        <a id="googleMapsLink" href="#" target="_blank" rel="noopener noreferrer">
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
                            let nombreUbicacion = document.getElementById('presidenteInput').value

                            let map = L.map('mi_mapa').setView([latitud, longitud], 17);

                            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);

                            L.marker([latitud, longitud]).addTo(map).bindPopup("Casa del Presidente " + nombreUbicacion).openPopup();

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
                    $sqlMostrarTarea = "SELECT tareas.id, tareas.titulo, tareas.fecha   
                 FROM tareas
                 WHERE tareas.idChacra = $idChacra";
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
                                    <?php echo $fila['fecha'] ?>
                                </td>
                                <td class="flex justify-center flex-col xl:flex-row w-full xl:w-auto p-3 text-gray-800 border border-b text-center xl:table-cell relative xl:static">
                                    <!--<span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Acciones</span>-->
                                    <a href="" class="text-green-400 hover:text-green-600">
                                        <button class="mb-2 xl:mb-0 middle none center mr-4 rounded-lg bg-green-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                            Editar
                                        </button>
                                    </a>
                                    <a href="index.php?modulo=detalle&idTarea=<?php echo $fila['id'] ?>" class="text-yellow-400 hover:text-yellow-600">
                                        <button class="mb-2 xl:mb-0 middle none center mr-4 rounded-lg bg-yellow-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-yellow-500/20 transition-all hover:shadow-lg hover:shadow-yellow-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                            Detalles
                                        </button>
                                    </a>
                                    <?php $idChacra = $_GET['idChacra']?>
                                    <a href="index.php?modulo=eliminar&idChacra=<?php echo $idChacra;?>&id=<?php echo $fila['id']?>&tipo=tareas" class="text-red-400 hover:text-red-600">
                                        <button class="mb-2 xl:mb-0 middle none center mr-4 rounded-lg bg-red-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                            Eliminar
                                        </button>
                                    </a>
                                </td>
                            </tr>
                    <?php
                        }
                    }

                    ?>

                </tbody>
            </table>
        </section>
    </div>
</div>