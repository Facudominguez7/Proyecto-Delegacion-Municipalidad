<?php
session_start();
include_once('includes/conexion.php');
conectar();

// Verificar si se está solicitando la generación del PDF
if (!empty($_GET['pdf']) && $_GET['pdf'] === 'ReporteActividadPorDia') {
    require('./fpdf/ReporteActividadPorDia.php');
    exit;
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

<body class="bg-gray-50 text-gray-800">
    <!-- Navegación -->
    <nav class="bg-gray-800 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <a href="index.php" class="text-2xl font-bold hover:text-green-400 transition">Delegación 32-33</a>
            <ul class="flex space-x-6">
                <?php if (isset($_SESSION['nombre_usuario'])): ?>
                    <li>
                        <a href="index.php?modulo=iniciar-sesion&salir" class="hover:text-green-400 transition text-lg">
                            Cerrar Sesión
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="index.php?modulo=iniciar-sesion" class="hover:text-green-400 transition text-lg">
                            Iniciar Sesión
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Encabezado -->
    <header class="bg-gray-700 text-white text-center py-8 shadow">
        <div class="container mx-auto">
            <h1 class="text-xl sm:text-4xl font-bold mb-2">delegación.municipal3233@gmail.com</h1>
            <p class="text-lg sm:text-xl">Av. Gral. Lavalle 4654</p>
            <p class="text-lg sm:text-xl">Teléfono: 3764 669218</p>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="container mx-auto py-2 px-2 sm:px-4">
        <?php
        if (!empty($_GET['modulo'])) {
            $modulo = $_GET['modulo'];
            include('./modulos/' . $modulo . '.php');
        } else {
        ?>
            <div class="flex flex-col items-center space-y-6 mb-5">
                <img src="imagenes/logo-delegacion.png" alt="Logo Delegación Chacra 3233" class="w-full sm:w-1/3 rounded-xl shadow-lg mb-6">

                <!-- Botones -->
                <a href="index.php?modulo=chacras" class="w-full max-w-md">
                    <button class="w-full h-12 rounded-lg bg-green-600 text-lg font-bold text-white transition hover:bg-green-700 shadow-md">
                        Chacras
                    </button>
                </a>
                <a href="index.php?modulo=des" class="w-full max-w-md">
                    <button class="w-full h-12 rounded-lg bg-green-600 text-lg font-bold text-white transition hover:bg-green-700 shadow-md">
                        Plazas / Desmalezamiento
                    </button>
                </a>
                <a href="index.php?modulo=puntos" class="w-full max-w-md">
                    <button class="w-full h-12 rounded-lg bg-green-600 text-lg font-bold text-white transition hover:bg-green-700 shadow-md">
                        Control Mini Basurales
                    </button>
                </a>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 2): ?>
                    <a href="index.php?modulo=informe-diario" class="w-full max-w-md">
                        <button class="w-full h-12 rounded-lg bg-green-600 text-lg font-bold text-white transition hover:bg-green-700 shadow-md">
                            Informe Diario
                        </button>
                    </a>
                <?php endif; ?>
            </div>
        <?php
        }
        ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4 mt-auto">
        <p class="text-sm">&copy; 2024 Delegación 32-33. Todos los derechos reservados.</p>
    </footer>
</body>

</html>