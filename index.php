<?php
include_once('includes/conexion.php');
conectar();

// Verificar si se está solicitando la generación del PDF
if (!empty($_GET['pdf']) && $_GET['pdf'] === 'ReporteActividadPorDia') {
    // Incluir el archivo necesario para la generación del PDF
    require('./fpdf/ReporteActividadPorDia.php');
    exit; // Terminar la ejecución del script después de generar el PDF
} else if (!empty($_GET['pdf']) && $_GET['pdf'] === 'ReporteActividadUnica') {
    require('./fpdf/ReporteActividadUnica.php');
    exit;
} else if (!empty($_GET['pdf']) && $_GET['pdf'] === 'ReporteInformeUnico') {
    require('./fpdf/ReporteInformeUnico.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/output.css">
    <link rel="shortcut icon" type="image/jpg" href="Imagenes/logo-delegacion.jpg">
    <title>Plataforma Digital</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>


<body class="bg-gray-200">
    <nav>
        <div class="flex bg-gray-800 text-white top-0 py-5 flex-wrap justify-around bg-silver">
            <div class="flex flex-col">
                <a href="index.php" >
                    <h1 class="text-xl text-center font-semibold">Delegación 32-33</h1>
                </a>
                <ul class="flex gap-[40px] text-m mt-2">
                    <li>
                        <a href="index.php?modulo=registro">
                            <h1 class="hidden text-lg font-semibold">Registrarse</h1>
                        </a>
                    </li>
                    <li>
                        <a href="index.php">
                            <h1 class="hidden text-lg font-semibold">Iniciar Sesión</h1>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="bg-gray-800 shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold tracking-tight text-white text-center mb-2">
                delegación.municipal3233@gmail.com
            </h1>
            <h1 class="text-lg sm:text-2xl lg:text-3xl font-bold tracking-tight text-white text-center">
                Av. Gral. Lavalle 4637
            </h1>
        </div>
    </header>


    <main>
        <?php
        if (!empty($_GET['modulo'])) {
            $modulo = $_GET['modulo'];
            include('./modulos/' . $modulo . '.php');
        } elseif (!empty($_GET['pdf'])) {
            $pdf = $_GET['pdf'];
            include('./fpdf/' . $pdf . '.php');
        } else {
        ?>
            <div class="flex w-full items-center justify-center flex-col mt-10">
                <div class="flex justify-center items-center mb-5">
                    <img class="w-1/3 h-1/3 rounded-xl" src="imagenes/logo-delegacion.jpg" alt="logo delegacion chacra 3233">
                </div>
                <a href="index.php?modulo=chacras">
                    <button class="group relative h-12 w-96 overflow-hidden rounded-2xl bg-green-500 text-lg font-bold text-white mb-5">
                        Chacras
                        <div class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/30"></div>
                    </button>
                </a>
                <a href="index.php?modulo=puntos">
                    <button class="group relative h-12 w-96 overflow-hidden rounded-2xl bg-green-500 text-lg font-bold text-white mb-5">
                        Control Mini Basurales
                        <div class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/30"></div>
                    </button>
                </a>
                <a href="index.php?modulo=informe-diario">
                    <button class="group relative h-12 w-96 overflow-hidden rounded-2xl bg-green-500 text-lg font-bold text-white mb-5">
                        Informe Diario
                        <div class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/30"></div>
                    </button>
                </a>
                <a href="index.php?modulo=tareas-apoyo">
                    <button class="group relative h-12 w-96 overflow-hidden rounded-2xl bg-green-500 text-lg font-bold text-white mb-5">
                        Tareas de Apoyo
                        <div class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/30"></div>
                    </button>
                </a>
            </div>
        <?php
        }
        ?>
    </main>

</body>

</html>