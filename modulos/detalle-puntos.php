<?php
if (isset($_GET['accion']) && $_GET['accion'] == 'editar') {
    if (isset($_POST['idPunto']) && isset($_POST['titulo'])) {
        $idPunto = $_POST['idPunto'];
        $titulo = $_POST['titulo'];

        $sqlEditarPunto = "UPDATE tareas_puntos SET titulo=? WHERE id=?";
        $stmt = mysqli_prepare($con, $sqlEditarPunto);
        mysqli_stmt_bind_param($stmt, "si", $titulo, $idPunto);
        mysqli_stmt_execute($stmt);

        // Verificar si se produjeron errores
        if (mysqli_stmt_error($stmt)) {
            echo "Error al actualizar el punto: " . mysqli_stmt_error($stmt);
        } else {
            echo "<script>alert('Punto Actualizado con Éxito');</script>";
        }
        // Cerrar la declaración preparada
        mysqli_stmt_close($stmt);

        // Redirigir de vuelta a la página de detalle de la Punto
        echo "<script>window.location='index.php?modulo=detalle-puntos&idPunto=" . $idPunto . "';</script>";
    } elseif (isset($_POST['idPunto']) && isset($_POST['fecha'])) {
        $fecha = $_POST['fecha'];
        $idPunto = $_POST['idPunto'];

        $sqlEditarPunto = "UPDATE tareas_puntos SET fecha=? WHERE id=?";
        $stmt = mysqli_prepare($con, $sqlEditarPunto);
        mysqli_stmt_bind_param($stmt, "si", $fecha, $idPunto);
        mysqli_stmt_execute($stmt);

        // Verificar si se produjeron errores
        if (mysqli_stmt_error($stmt)) {
            echo "Error al actualizar el punto: " . mysqli_stmt_error($stmt);
        } else {
            echo "<script>alert('Punto Actualizado con Éxito');</script>";
        }
        // Cerrar la declaración preparada
        mysqli_stmt_close($stmt);
        // Redirigir de vuelta a la página de detalle de la Punto
        echo "<script>window.location='index.php?modulo=detalle-puntos&idPunto=" . $idPunto . "';</script>";
    } elseif ((isset($_POST['idPunto']) && isset($_POST['descripcion']))) {
        $descripcion = $_POST['descripcion'];
        $idPunto = $_POST['idPunto'];

        $sqlEditarPunto = "UPDATE tareas_puntos SET descripcion=? WHERE id=?";
        $stmt = mysqli_prepare($con, $sqlEditarPunto);
        mysqli_stmt_bind_param($stmt, "si", $descripcion, $idPunto);
        mysqli_stmt_execute($stmt);

        // Verificar si se produjeron errores
        if (mysqli_stmt_error($stmt)) {
            echo "Error al actualizar el Punto: " . mysqli_stmt_error($stmt);
        } else {
            echo "<script>alert('Punto Actualizado con Éxito');</script>";
        }
        // Cerrar la declaración preparada
        mysqli_stmt_close($stmt);
        // Redirigir de vuelta a la página de detalle de la Punto
        echo "<script>window.location='index.php?modulo=detalle-puntos&idPunto=" . $idPunto . "';</script>";
    }
}

?>
<div class="mt-5 ml-60 flex justify-start">
    <?php $idPunto = $_GET['idPunto'] ?>
    <a href="index.php?modulo=tareas-puntos&idPunto=<?php echo $idPunto ?>">
        <button class="md:mb-0 mb-5  middle none center mr-4 rounded-lg bg-gray-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg hover:shadow-gray-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
            Volver
        </button>
    </a>
</div>
<section class="mt-10">
    <?php
    $idPunto = $_GET['id'];
    $sqlMostrarDetallePunto = "SELECT * FROM tareas_puntos WHERE id = $idPunto";
    $datos = mysqli_query($con, $sqlMostrarDetallePunto);
    if ($datos->num_rows > 0) {
        while ($fila = mysqli_fetch_array($datos)) {
    ?>
            <div class="flex items-center justify-center px-4">
                <div class="max-w-4xl bg-white w-full rounded-lg shadow-xl">
                    <div class="p-4 border-b">
                        <form action="index.php?modulo=detalle-puntos&accion=editar" method="post" class="w-full">
                            <div class="flex flex-row items-center">
                                <h2 class="text-2xl w-full">
                                    <input type="hidden" name="idPunto" value="<?php echo $fila['id']; ?>">
                                    <input class="w-full placeholder-opacity-100 placeholder-transparent border-b border-gray-300 focus:border-blue-500" type="text" name="titulo" value="<?php echo $fila['titulo']; ?>" readonly>
                                </h2>
                                <button class="guardar-btn hidden ml-2 w-6 h-6" type="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                    </svg>
                                </button>
                                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3){ ?>
                                    <button class="editar-btn w-6 h-6 ml-2" type="button" onclick="enableEdit(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                        </svg>
                                    </button>
                                <?php } ?>
                                <a href="index.php?modulo=detalle-puntos&idPunto=<?php echo $idPunto ?>">
                                    <button class="cancelar-btn hidden ml-2 mb-0 mt-2 w-5 h-5" type="button" onclick="cancelEdit(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free-->
                                            <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                        </svg>
                                    </button>
                                </a>
                            </div>
                        </form>
                        <form class="mt-5 mb-5" action="index.php?modulo=detalle-puntos&accion=editar&idPunto=<?php echo $_GET['idPunto'] ?>" method="post">
                            <div class="flex flex-row items-center">
                                <p class="text-xl text-gray-500">
                                    <input type="hidden" name="idPunto" value="<?php echo $fila['id']; ?>">
                                    <input type="date" name="fecha" value="<?php echo $fila['fecha']; ?>" readonly>
                                </p>
                                <button class="guardar-btn hidden ml-2 w-6 h-6" type="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                    </svg>
                                </button>
                                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3){ ?>
                                    <button class="editar-btn w-6 h-6 ml-2" type="button" onclick="enableEdit(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                        </svg>
                                    </button>
                                <?php } ?>
                                <a href="index.php?modulo=detalle-puntos&idPunto=<?php echo $idPunto ?>">
                                    <button class="cancelar-btn hidden ml-2 mb-0 mt-2 w-5 h-5" type="button" onclick="cancelEdit(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free-->
                                            <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                        </svg>
                                    </button>
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="p-4 border-b">
                        <form action="index.php?modulo=detalle-puntos&accion=editar&idPunto=<?php echo $_GET['idPunto'] ?>" method="post">
                            <div class="flex flex-row items-center justify-between">
                                <p class="text-gray-600 text-xl mb-4">
                                    Descripción
                                </p>
                                <div class="flex flex-row items-center justify-evenly">
                                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3){ ?>
                                        <button class="editar-btn w-6 h-6 ml-2" type="button" onclick="enableEdit(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                            </svg>
                                        </button>

                                    <?php } ?>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <div class="flex justify-center items-center">
                                    <button class="guardar-btn hidden ml-2 w-6 h-6" type="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                        </svg>
                                    </button>
                                    <a href="index.php?modulo=detalle-puntos&idPunto=<?php echo $idPunto ?>">
                                        <button class="cancelar-btn hidden ml-2 mb-0 mt-2 w-5 h-5" type="button" onclick="cancelEdit(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free-->
                                                <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                            </div>

                            <input type="hidden" name="idPunto" value="<?php echo $fila['id']; ?>">
                            <textarea name="descripcion" class="w-full h-32 md:h-48 lg:h-64 xl:h-72" readonly><?php echo $fila['descripcion']; ?></textarea>
                        </form>
                    </div>
                </div>
            </div>
            <div class="flex justify-center items-center flex-col mt-5">
                <h1 class="text-3xl font-bold tracking-tight flex justify-center text-black mb-6">
                    Fotos de la Actividad
                </h1>
                <div class="flex flex-wrap justify-center">
                    <?php
                    $carpetaPunto = "imagenes/tareas_puntos/" . $fila['id'] . "/";
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



    <?php
        }
    }
    ?>

</section>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const editarButtons = document.querySelectorAll('.editar-btn');

        editarButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Ocultar todos los botones de edición
                document.querySelectorAll('.editar-btn').forEach(function(btn) {
                    btn.classList.add('hidden');
                });
                // Mostrar solo el botón de guardar correspondiente al formulario
                const form = button.closest('form');
                form.querySelector('.guardar-btn').classList.remove('hidden');
                form.querySelector('.cancelar-btn').classList.remove('hidden');
            });
        });
    });

    function enableEdit(button) {
        // Obtener el formulario padre del botón
        const form = button.closest('form');
        // Obtener todos los textarea dentro del formulario
        const textareas = form.querySelectorAll('textarea');
        // Obtener todos los input dentro del formulario
        const inputs = form.querySelectorAll('input');

        // Iterar sobre todos los textarea y remover el atributo "readonly"
        textareas.forEach(textarea => {
            textarea.removeAttribute('readonly');
        });

        // Iterar sobre todos los input y remover el atributo "readonly"
        inputs.forEach(input => {
            input.removeAttribute('readonly');
        });

        // Obtener el botón de guardar dentro del formulario
        const saveButton = form.querySelector('button[type="submit"]');
        // Mostrar el botón de guardar
        saveButton.classList.remove('hidden');
        // Ocultar el botón de edición
        button.classList.add('hidden');
    }
</script>