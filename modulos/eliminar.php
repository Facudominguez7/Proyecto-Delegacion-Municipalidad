<?php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// Definir el tipo de registro y el ID
$tipo = $_GET['tipo'];
$id = $_GET['id'];

// Verificar si se pasó el tipo y el ID en la URL
if (isset($_GET['accion'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $csrf_token = filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_STRING);
        if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
            die("Solicitud inválida por token CSRF.");
        }
    }
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        die("Método no permitido.");
    }
    switch ($_GET['accion']) {
        case 'eliminar-tareas':
            function eliminarCarpeta($carpeta)
            {
                $archivos = glob($carpeta . '/*');
                foreach ($archivos as $archivo) {
                    is_dir($archivo) ? eliminarCarpeta($archivo) : unlink($archivo);
                }
                rmdir($carpeta);
            }
            // Obtener la carpeta del producto
            $carpetaTarea = "imagenes/tareas/" . $id . "/";
            // Verificar si la carpeta existe
            if (file_exists($carpetaTarea)) {
                // Eliminar la carpeta y su contenido
                eliminarCarpeta($carpetaTarea);
            }
            // Eliminar registros de la tabla productos_files
            $sqlEliminarImagenes = "DELETE fotos_tareas FROM fotos_tareas
            INNER JOIN tareas ON fotos_tareas.idTarea = tareas.id
            WHERE tareas.id = ?";
            $stmtEliminarImagenes = mysqli_prepare($con, $sqlEliminarImagenes);
            mysqli_stmt_bind_param($stmtEliminarImagenes, "i", $id);
            mysqli_stmt_execute($stmtEliminarImagenes);

            // Verificar si se produjeron errores
            if (mysqli_error($con)) {
                echo "<script>alert('Error al eliminar registros de la tabla fotos_tareas: " . mysqli_error($con) . "');</script>";
            } else {
                // Ahora, eliminar el producto de la tabla productos
                $sqlEliminarTarea = "DELETE FROM tareas WHERE id = ?";
                $stmtEliminarTarea = mysqli_prepare($con, $sqlEliminarTarea);
                mysqli_stmt_bind_param($stmtEliminarTarea, "i", $id);
                mysqli_stmt_execute($stmtEliminarTarea);

                // Verificar si se produjeron errores
                if (mysqli_error($con)) {
                    $idChacra = $_GET['idChacra'];
                    echo '<script> 
                    Swal.fire({
                        title: "¡Error al eliminar la tarea!",
                        text: "Ocurrió un error al intentar eliminar la tarea: ' . mysqli_error($con) . '",
                        icon: "error",
                        confirmButtonColor: "#d33",
                        confirmButtonText: "Aceptar",
                        willClose: () => {
                            window.location.href = "index.php?modulo=tareas&idChacra=' . $idChacra . '";
                        }
                    }); 
                </script>';
                } else {
                    $idChacra = $_GET['idChacra'];
                    echo '<script> 
                    Swal.fire({
                        title: "¡Tarea eliminada con éxito!",
                        icon: "success",
                        confirmButtonColor: "#4caf50",
                        confirmButtonText: "Aceptar",
                        willClose: () => {
                            window.location.href = "index.php?modulo=tareas&idChacra=' . $idChacra . '";
                        }
                    }); 
                </script>';
                }
            }
            // Cerrar las declaraciones preparadas
            mysqli_stmt_close($stmtEliminarImagenes);
            mysqli_stmt_close($stmtEliminarTarea);
            break;
        case 'eliminar-chacras':
            $sql = "DELETE FROM chacras WHERE id = $id";
            $sql = mysqli_query($con, $sql);
            if (!mysqli_error($con)) {
                echo '<script> 
                Swal.fire({
                    title: "¡Chacra eliminada con éxito!",
                    icon: "success",
                    confirmButtonColor: "#4caf50",
                    confirmButtonText: "Aceptar",
                    willClose: () => {
                        window.location.href = "index.php?modulo=chacras";
                    }
                }); 
            </script>';
            } else {
                echo '<script> 
                Swal.fire({
                    title: "¡Error al eliminar la chacra!",
                    text: "Ocurrió un error al intentar eliminar la chacra: ' . mysqli_error($con) . '",
                    icon: "error",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Aceptar",
                    willClose: () => {
                        window.location.href = "index.php?modulo=chacras";
                    }
                }); 
            </script>';
            }
            break;
        case 'eliminar-puntos':
            // Eliminar el punto
            $sqlEliminarPunto = "DELETE FROM puntos WHERE id = ?";
            $stmtEliminarPunto = mysqli_prepare($con, $sqlEliminarPunto);
            mysqli_stmt_bind_param($stmtEliminarPunto, "i", $id);
            mysqli_stmt_execute($stmtEliminarPunto);

            if (!mysqli_error($con)) {
                echo '<script> 
                Swal.fire({
                    title: "¡Punto eliminado con éxito!",
                    icon: "success",
                    confirmButtonColor: "#4caf50",
                    confirmButtonText: "Aceptar",
                    willClose: () => {
                        window.location.href = "index.php?modulo=puntos";
                    }
                }); 
            </script>';
            } else {
                echo '<script> 
                Swal.fire({
                    title: "¡Error al eliminar el punto!",
                    text: "Ocurrió un error al intentar eliminar el punto: ' . mysqli_error($con) . '",
                    icon: "error",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Aceptar",
                    willClose: () => {
                        window.location.href = "index.php?modulo=puntos";
                    }
                }); 
            </script>';
            }
            mysqli_stmt_close($stmtEliminarPunto);
            break;
        case 'eliminar-informes':
            // Eliminar el Informe
            $sql = "DELETE FROM informes_diarios WHERE id = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            if (!mysqli_error($con)) {
                echo '<script> 
                        Swal.fire({
                            title: "¡Informe eliminado con éxito!",
                            icon: "success",
                            confirmButtonColor: "#4caf50",
                            confirmButtonText: "Aceptar",
                            willClose: () => {
                                window.location.href = "index.php?modulo=informe-diario";
                            }
                        }); 
                    </script>';
            } else {
                echo '<script> 
                        Swal.fire({
                            title: "¡Error al eliminar el informe!",
                            text: "Ocurrió un error al intentar eliminar el informe: ' . mysqli_error($con) . '",
                            icon: "error",
                            confirmButtonColor: "#d33",
                            confirmButtonText: "Aceptar",
                            willClose: () => {
                                window.location.href = "index.php?modulo=informe-diario";
                            }
                        }); 
                    </script>';
            }
            mysqli_stmt_close($stmt);
            break;
        case 'eliminar-des':
            // Eliminar el des
            $sqlEliminarDes = "DELETE FROM desmalezamientos WHERE id = ?";
            $stmtEliminarDes = mysqli_prepare($con, $sqlEliminarDes);
            mysqli_stmt_bind_param($stmtEliminarDes, "i", $id);
            mysqli_stmt_execute($stmtEliminarDes);

            if (!mysqli_error($con)) {
                echo '<script> 
                Swal.fire({
                    title: "¡Tarea eliminada con éxito!",
                    icon: "success",
                    confirmButtonColor: "#4caf50",
                    confirmButtonText: "Aceptar",
                    willClose: () => {
                        window.location.href = "index.php?modulo=des";
                    }
                }); 
            </script>';
            } else {
                echo '<script> 
                Swal.fire({
                    title: "¡Error al eliminar la Tarea!",
                    text: "Ocurrió un error al intentar eliminar la Tarea: ' . mysqli_error($con) . '",
                    icon: "error",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Aceptar",
                    willClose: () => {
                        window.location.href = "index.php?modulo=des";
                    }
                }); 
            </script>';
            }
            mysqli_stmt_close($stmtEliminarDes);
            break;
        case 'eliminar-tareas-des':
            // Eliminar el tareas_des
            $idDes = $_GET['idDes'];
            $sqlEliminarTareasDes = "DELETE FROM tareas_des WHERE id = ?";
            $stmtEliminarTareasDes = mysqli_prepare($con, $sqlEliminarTareasDes);
            mysqli_stmt_bind_param($stmtEliminarTareasDes, "i", $id);
            mysqli_stmt_execute($stmtEliminarTareasDes);

            if (!mysqli_error($con)) {
                echo '<script> 
                Swal.fire({
                    title: "¡Actividad eliminada con éxito!",
                    icon: "success",
                    confirmButtonColor: "#4caf50",
                    confirmButtonText: "Aceptar",
                    willClose: () => {
                        window.location.href = "index.php?modulo=tareas-des&idDes=' . $idDes . '";
                    }
                }); 
            </script>';
            } else {
                echo '<script> 
                Swal.fire({
                    title: "¡Error al eliminar la Actividad!",
                    text: "Ocurrió un error al intentar eliminar la Actividad: ' . mysqli_error($con) . '",
                    icon: "error",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Aceptar",
                    willClose: () => {
                        window.location.href = "index.php?modulo=tareas-des&idDes=' . $idDes . '";
                    }
                }); 
            </script>';
            }
            mysqli_stmt_close($stmtEliminarTareasDes);
            break;
        case 'eliminar-tareas-puntos':
            // Eliminar el tareas_puntos
            $idPunto = $_GET['idPunto'];
            $sqlEliminarTareasPuntos = "DELETE FROM tareas_puntos WHERE id = ?";
            $stmtEliminarTareasPuntos = mysqli_prepare($con, $sqlEliminarTareasPuntos);
            mysqli_stmt_bind_param($stmtEliminarTareasPuntos, "i", $id);
            mysqli_stmt_execute($stmtEliminarTareasPuntos);

            if (!mysqli_error($con)) {
                echo '<script> 
                Swal.fire({
                    title: "¡Tarea eliminada con éxito!",
                    icon: "success",
                    confirmButtonColor: "#4caf50",
                    confirmButtonText: "Aceptar",
                    willClose: () => {
                        window.location.href = "index.php?modulo=tareas-puntos&idPunto=' . $idPunto . '";
                    }
                }); 
            </script>';
            } else {
                echo '<script> 
                Swal.fire({
                    title: "¡Error al eliminar la tarea!",
                    text: "Ocurrió un error al intentar eliminar la tarea: ' . mysqli_error($con) . '",
                    icon: "error",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Aceptar",
                    willClose: () => {
                        window.location.href = "index.php?modulo=tareas-puntos&idPunto=' . $idPunto . '";
                    }
                }); 
            </script>';
            }
            mysqli_stmt_close($stmtEliminarTareasPuntos);
            break;
    }
}
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<section>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-6 offset-sm-3">
                <div class="alert alert-danger text-center">
                    <p>¿Desea confirmar la eliminación del registro?</p>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?php if ($tipo === 'tareas' || $tipo === 'chacras' || $tipo === 'puntos' || $tipo === 'informes' || $tipo === 'des' || $tipo === 'tareas-des' || $tipo === 'tareas-puntos') {
                            if (isset($_GET['idChacra']) || isset($_GET['idPunto']) || isset($_GET['idDes'])) {
                                $idChacra = $_GET['idChacra'] ?? null;
                                $idPunto = $_GET['idPunto'] ?? null;
                                $idDes = $_GET['idDes'] ?? null;
                        ?>
                                <form action="index.php?modulo=eliminar&tipo=<?php echo $tipo; ?>&accion=eliminar-<?php echo $tipo; ?>&id=<?php echo $id; ?>&idChacra=<?php echo $idChacra; ?>&idPunto=<?php echo $idPunto; ?>&idDes=<?php echo $idDes; ?>" method="POST">
                                <?php
                            } else {
                                ?>
                                    <form action="index.php?modulo=eliminar&tipo=<?php echo $tipo; ?>&accion=eliminar-<?php echo $tipo; ?>&id=<?php echo $id; ?>" method="POST">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <?php
                                }
                                    ?>
                                    <input type="hidden" name="accion" value="eliminar_registro">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="submit" name="" value="Eliminar" class=" btn btn-danger">
                                    <?php if (isset($_GET['idChacra']) || isset($_GET['idPunto']) || isset($_GET['idDes'])) {
                                        $idChacra = $_GET['idChacra'] ?? null;
                                        $idPunto = $_GET['idPunto'] ?? null;
                                        $idDes = $_GET['idDes'] ?? null;
                                    ?>
                                        <a href="index.php?modulo=<?php echo $tipo; ?>&idChacra=<?php echo $idChacra; ?>&idPunto=<?php echo $idPunto; ?>&idDes=<?php echo $idDes; ?>" class="btn btn-success">Cancelar</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="index.php?modulo=<?php echo $tipo; ?>" class="btn btn-success">Cancelar</a>
                                    <?php
                                    }
                                    ?>
                                    </form>
                                <?php } else { ?>
                                    <p>Tipo de registro no válido.</p>
                                <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>