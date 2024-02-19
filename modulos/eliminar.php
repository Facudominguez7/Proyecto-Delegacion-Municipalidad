<?php
// Definir el tipo de registro y el ID
$tipo = $_GET['tipo'];
$id = $_GET['id'];

// Verificar si se pasó el tipo y el ID en la URL
if (isset($_GET['accion'])) {
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
                    echo "<script>alert('Error al eliminar la tarea: " . mysqli_error($con) . "');</script>";
                } else {
                    echo "<script>alert('Tarea Eliminada con éxito');</script>";
                }
            }
            // Cerrar las declaraciones preparadas
            mysqli_stmt_close($stmtEliminarImagenes);
            mysqli_stmt_close($stmtEliminarTarea);

            $idChacra = $_GET['idChacra'];
            echo "<script>window.location='index.php?modulo=tareas&idChacra=" . $idChacra . "';</script>";
            break;
        case 'eliminar-chacras':
            echo $sql = "DELETE FROM chacras WHERE id = $id";
            $sql = mysqli_query($con, $sql);
            if (!mysqli_error($con)) {
                echo "<script> alert('Chacra eliminada con éxito');</script>";
            } else {
                echo "<script> alert('ERROR, no se pudo eliminar');</script>";
            }
            echo "<script>window.location='index.php?modulo=chacras';</script>";
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
                        <?php if ($tipo === 'tareas' || $tipo === 'chacras') {
                            if (isset($_GET['idChacra'])) {
                                $idChacra = $_GET['idChacra'];
                        ?>
                                <form action="index.php?modulo=eliminar&tipo=<?php echo $tipo; ?>&accion=eliminar-<?php echo $tipo; ?>&id=<?php echo $id; ?>&idChacra=<?php echo $idChacra; ?>" method="POST">
                                <?php
                            } else {
                                ?>
                                    <form action="index.php?modulo=eliminar&tipo=<?php echo $tipo; ?>&accion=eliminar-<?php echo $tipo; ?>&id=<?php echo $id; ?>" method="POST">
                                    <?php
                                }
                                    ?>

                                    <input type="hidden" name="accion" value="eliminar_registro">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="submit" name="" value="Eliminar" class=" btn btn-danger">
                                    <?php if (isset($_GET['idChacra'])) {
                                        $idChacra = $_GET['idChacra'];
                                    ?>
                                        <a href="index.php?modulo=<?php echo $tipo; ?>&idChacra=<?php echo $idChacra; ?>" class="btn btn-success">Cancelar</a>
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