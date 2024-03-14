<?php
if (!empty($_GET['accion'])) {
    if ($_GET['accion'] == 'agregar') {
        $titulo = $_POST['titulo'];
        $fecha = $_POST['fecha'];
        $descripcion = $_POST['descripcion'];

        // Insertar datos en la tabla de tareas
        $sql = "INSERT INTO informes_diarios(titulo, fecha, descripcion) VALUES (?, ?, ?)";
        $stmtInforme = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmtInforme, "sss", $titulo, $fecha, $descripcion);
        mysqli_stmt_execute($stmtInforme);

        if (mysqli_error($con)) {
            echo '<script> 
                    Swal.fire({
                        title: "¡Error al registrar el informe!",
                        text: "Ocurrió un error al registrar el informe: ' . mysqli_error($con) . '",
                        icon: "error",
                        confirmButtonColor: "#d33",
                        confirmButtonText: "Aceptar"
                    }); 
                </script>';

        } else {
            echo '<script> 
                    Swal.fire({
                        title: "¡Informe registrado correctamente!",
                        text: "El informe ha sido registrada con éxito.",
                        icon: "success",
                        confirmButtonColor: "#4caf50",
                        confirmButtonText: "Aceptar",
                        willClose: () => {
                            window.location.href = "index.php?modulo=informe-diario";
                        }
                    }); 
                </script>';
        }
    }
}
?>
<section>
    <div class="flex items-center justify-center p-12">
        <div class="mx-auto w-full max-w-[550px]">
            <form action="index.php?modulo=agregar-informe-diario&accion=agregar" method="POST">
                <div class="mb-5">
                    <label for="titulo" class="mb-3 block text-base font-medium text-[#07074D]">
                        Título
                    </label>
                    <input type="text" name="titulo" id="titulo" placeholder="Título del Informe" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div class="mb-5">
                    <label for="fecha" class="mb-3 block text-base font-medium text-[#07074D]">
                        Fecha
                    </label>
                    <input type="date" name="fecha" id="fecha" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div class="mb-5">
                    <label for="descripcion" class="mb-3 block text-base font-medium text-[#07074D]">
                        Descripción
                    </label>
                    <textarea name="descripcion" id="descripcion" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required> </textarea>
                </div>
                <div>
                    <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Agregar
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>