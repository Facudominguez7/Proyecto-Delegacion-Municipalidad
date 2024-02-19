<?php
include('includes/conexion.php');
conectar();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/output.css">
    <title>Control-chacras</title>
</head>

<body class="bg-gray-200">
    <nav>
        <div class="flex bg-gray-800 text-white top-0 py-5 flex-wrap justify-around bg-silver">
            <a href="index.php">
                <h1 class="text-lg font-semibold">Delegación 32-33</h1>
            </a>
            <ul class="flex gap-[40px] text-m mt-2">
                <li>Iniciar Sesión</li>
                <li>Registrarse</li>
                <li>contact</li>
            </ul>
        </div>
    </nav>
    <main>
        <?php
        if (!empty($_GET['modulo'])) {
            include('./modulos/' . $_GET['modulo'] . '.php');
        } else {
        ?>
            <div class="flex min-h-screen w-full items-center justify-center flex-col bg-gray-100">
                <a href="index.php?modulo=chacras">
                    <button class="group relative h-12 w-64 overflow-hidden rounded-2xl bg-green-500 text-lg font-bold text-white mb-5">
                        Chacras
                        <div class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/30"></div>
                    </button>
                </a>
                <a href="index.php?modulo=puntos">
                    <button class="group relative h-12 w-64 overflow-hidden rounded-2xl bg-green-500 text-lg font-bold text-white mb-5">
                        Control mini basurales
                        <div class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/30"></div>
                    </button>
                </a>
                <button class="group relative h-12 w-64 overflow-hidden rounded-2xl bg-green-500 text-lg font-bold text-white mb-5">
                    etc
                    <div class="absolute inset-0 h-full w-full scale-0 rounded-2xl transition-all duration-300 group-hover:scale-100 group-hover:bg-white/30"></div>
                </button>
            </div>
        <?php
        }
        ?>
    </main>

</body>

</html>