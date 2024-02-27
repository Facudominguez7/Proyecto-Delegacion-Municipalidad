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
</head>

<body class="bg-gray-200">
    <nav>
        <div class="flex bg-gray-800 text-white top-0 py-5 flex-wrap justify-around bg-silver">
            <a href="index.php">
                <h1 class="text-lg font-semibold">Delegación 32-33</h1>
            </a>
            <!-- 
                <ul class="flex gap-[40px] text-m mt-2">
                <li>Iniciar Sesión</li>
                <li>Registrarse</li>
                <li>contact</li>
            </ul>
            -->
        </div>
    </nav>
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
                    <img class="w-1/2 h-1/2 rounded-xl" src="imagenes/logo-delegacion.jpg" alt="logo delegacion chacra 3233">
                </div>
                <a href="index.php?modulo=chacras">
                    <button class="group relative h-12 w-96 overflow-hidden rounded-2xl bg-green-500 text-lg font-bold text-white mb-5">
                        Chacras
                        <div class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/30"></div>
                    </button>
                </a>
                <a href="index.php?modulo=puntos">
                    <button class="group relative h-12 w-96 overflow-hidden rounded-2xl bg-green-500 text-lg font-bold text-white mb-5">
                        Control puntos limpios
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