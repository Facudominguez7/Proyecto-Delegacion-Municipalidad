<?php
if (isset($_GET['accion']) && $_GET['accion'] == 'editar') {
    if (isset($_POST['idInforme']) && isset($_POST['titulo'])) {
        $idInforme = $_POST['idInforme'];
        $titulo = $_POST['titulo'];

        $sql = "UPDATE informes_diarios SET titulo=? WHERE id=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "si", $titulo, $idInforme);
        mysqli_stmt_execute($stmt);

        // Verificar si se produjeron errores
        if (mysqli_stmt_error($stmt)) {
            echo '<script> 
            Swal.fire({
                title: "¡Error al registrar el informe!",
                text: "Ocurrió un error al registrar el informe: ' . mysqli_stmt_error($stmt) . '",
                icon: "error",
                confirmButtonColor: "#d33",
                confirmButtonText: "Aceptar"
            }); 
        </script>';
        } else {
            echo '<script> 
                    Swal.fire({
                        title: "¡Informe actualizado correctamente!",
                        text: "El informe ha sido actualizado con éxito.",
                        icon: "success",
                        confirmButtonColor: "#4caf50",
                        confirmButtonText: "Aceptar",
                        willClose: () => {
                            window.location.href = "index.php?modulo=detalle-informe&idInforme=' . $idInforme . '";
                        }
                    }); 
                </script>';
        }
        // Cerrar la declaración preparada
        mysqli_stmt_close($stmt);
    } elseif (isset($_POST['idInforme']) && isset($_POST['fecha'])) {
        $fecha = $_POST['fecha'];
        $idInforme = $_POST['idInforme'];

        $sql = "UPDATE informes_diarios SET fecha=? WHERE id=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "si", $fecha, $idInforme);
        mysqli_stmt_execute($stmt);

        // Verificar si se produjeron errores
        if (mysqli_stmt_error($stmt)) {
            echo '<script> 
                Swal.fire({
                    title: "¡Error al registrar el informe!",
                    text: "Ocurrió un error al registrar el informe: ' . mysqli_stmt_error($stmt) . '",
                    icon: "error",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Aceptar"
                }); 
            </script>';
        } else {
            echo '<script> 
                        Swal.fire({
                            title: "¡Informe actualizado correctamente!",
                            text: "El informe ha sido actualizado con éxito.",
                            icon: "success",
                            confirmButtonColor: "#4caf50",
                            confirmButtonText: "Aceptar",
                            willClose: () => {
                                window.location.href = "index.php?modulo=detalle-informe&idInforme=' . $idInforme . '";
                            }
                        }); 
                    </script>';
        }
        // Cerrar la declaración preparada
        mysqli_stmt_close($stmt);
    } elseif ((isset($_POST['idInforme']) && isset($_POST['descripcion']))) {
        $descripcion = $_POST['descripcion'];
        $idInforme = $_POST['idInforme'];

        $sql = "UPDATE informes_diarios SET descripcion=? WHERE id=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "si", $descripcion, $idInforme);
        mysqli_stmt_execute($stmt);

        // Verificar si se produjeron errores
        if (mysqli_stmt_error($stmt)) {
            echo '<script> 
                Swal.fire({
                    title: "¡Error al registrar el informe!",
                    text: "Ocurrió un error al registrar el informe: ' . mysqli_stmt_error($stmt) . '",
                    icon: "error",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Aceptar"
                }); 
            </script>';
        } else {
            echo '<script> 
                        Swal.fire({
                            title: "¡Informe actualizado correctamente!",
                            text: "El informe ha sido actualizado con éxito.",
                            icon: "success",
                            confirmButtonColor: "#4caf50",
                            confirmButtonText: "Aceptar",
                            willClose: () => {
                                window.location.href = "index.php?modulo=detalle-informe&idInforme=' . $idInforme . '";
                            }
                        }); 
                    </script>';
        }
        // Cerrar la declaración preparadac
        mysqli_stmt_close($stmt);
    }
}

?>
<div class="mt-5 flex justify-center items-center flex-col md:flex-row md:justify-center">
    <a href="index.php?modulo=informe-diario">
        <button class="md:mb-0 mb-5  middle none center mr-4 rounded-lg bg-gray-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg hover:shadow-gray-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
            Volver
        </button>
    </a>
    <a href="index.php?pdf=ReporteInformeUnico&idInforme=<?php echo $_GET['idInforme'] ?>" target="_blank">
        <button class="md:mb-0 mb-5  middle none center mr-4 rounded-lg bg-gray-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg hover:shadow-gray-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
            Generar Reporte PDF
        </button>
    </a>
</div>
<section class="mt-10">
    <?php
    $idInforme = $_GET['idInforme'];
    $sqlMostrarDetalleInforme = "SELECT * FROM informes_diarios WHERE id = $idInforme";
    $datos = mysqli_query($con, $sqlMostrarDetalleInforme);
    if ($datos->num_rows > 0) {
        while ($fila = mysqli_fetch_array($datos)) {
    ?>
            <div class="bg-gray-200">
                <div class="flex items-center justify-center px-4">
                    <div class="max-w-4xl bg-white w-full rounded-lg shadow-xl">
                        <div class="p-4 border-b">
                            <form action="index.php?modulo=detalle-informe&accion=editar&idInforme=<?php echo $_GET['idInforme'] ?>" method="post" class="w-full">
                                <div class="flex flex-row items-center">
                                    <h2 class="text-2xl w-full">
                                        <input type="hidden" name="idInforme" value="<?php echo $fila['id']; ?>">
                                        <input class="w-full placeholder-opacity-100 placeholder-transparent border-b border-gray-300 focus:border-blue-500" type="text" name="titulo" value="<?php echo $fila['titulo']; ?>" readonly>
                                    </h2>
                                    <button class="guardar-btn hidden ml-2 w-6 h-6" type="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                        </svg>
                                    </button>
                                    <button class="editar-btn w-6 h-6 ml-2" type="button" onclick="enableEdit(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                        </svg>
                                    </button>
                                    <a href="index.php?modulo=detalle-informe&idInforme=<?php echo $idInforme ?>">
                                        <button class="cancelar-btn hidden ml-2 mb-0 mt-2 w-5 h-5" type="button" onclick="cancelEdit(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free-->
                                                <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                            </form>
                            <form action="index.php?modulo=detalle-informe&accion=editar&idInforme=<?php echo $_GET['idInforme'] ?>" method="post" class="w-full mt-5">
                                <div class="flex flex-row items-center">
                                    <p class="text-xl text-gray-500">
                                        <input type="hidden" name="idInforme" value="<?php echo $fila['id']; ?>">
                                        <input type="date" name="fecha" value="<?php echo $fila['fecha']; ?>" readonly>
                                    </p>
                                    <button class="guardar-btn hidden ml-2 w-6 h-6" type="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                        </svg>
                                    </button>
                                    <button class="editar-btn w-6 h-6 ml-2" type="button" onclick="enableEdit(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                        </svg>
                                    </button>
                                    <a href="index.php?modulo=detalle-informe&idInforme=<?php echo $idInforme ?>">
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
                            <form action="index.php?modulo=detalle-informe&accion=editar&idInforme=<?php echo $_GET['idInforme'] ?>" method="post" class="w-full mt-5">
                                <div class="flex flex-row items-center justify-between">
                                    <p class="text-gray-600 text-xl mb-4">
                                        Descripción
                                    </p>
                                    <div class="flex flex-row items-center justify-evenly">
                                        <button class="editar-btn w-6 h-6 ml-2" type="button" onclick="enableEdit(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <div class="flex justify-center items-center">
                                        <button class="guardar-btn hidden ml-2 w-6 h-6" type="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                            </svg>
                                        </button>
                                        <a href="index.php?modulo=detalle-informe&idInforme=<?php echo $idInforme ?>">
                                            <button class="cancelar-btn hidden ml-2 mb-0 mt-2 w-5 h-5" type="button" onclick="cancelEdit(this)">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free-->
                                                    <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                                </svg>
                                            </button>
                                        </a>
                                    </div>
                                </div>

                                <input type="hidden" name="idInforme" value="<?php echo $fila['id']; ?>">
                                <textarea name="descripcion" class="w-full h-32 md:h-48 lg:h-64 xl:h-72" readonly><?php echo $fila['descripcion']; ?></textarea>
                            </form>
                        </div>
                    </div>
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