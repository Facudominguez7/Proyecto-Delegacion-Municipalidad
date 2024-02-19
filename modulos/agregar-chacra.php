<?php
if (!empty($_GET['accion'])) {
    if ($_GET['accion'] == 'agregar') {
        $nombre = $_POST['nombre'];
        $presidente = $_POST['presidente'];
        $latitud = $_POST['latitud'];
        $longitud = $_POST['longitud'];

        // Verificación de la chacra 
        $sql_verificar = "SELECT * FROM chacras WHERE nombre = ?";
        $stmt_verificar = mysqli_prepare($con, $sql_verificar);
        mysqli_stmt_bind_param($stmt_verificar, "s", $nombre);
        mysqli_stmt_execute($stmt_verificar);
        mysqli_stmt_store_result($stmt_verificar);

        if (mysqli_stmt_num_rows($stmt_verificar) != 0) {
            echo "<script> alert('ESTA CHACRA YA EXISTE EN LA BASE DE DATOS');</script>";
        } else {
            // Insertar chacra
            $sql_insertar = "INSERT INTO chacras (nombre, presidente, ubicacion) VALUES (?, ?, ST_GeomFromText(?))";
            $stmt_insertar = mysqli_prepare($con, $sql_insertar);
            mysqli_stmt_bind_param($stmt_insertar, "sss", $nombre, $presidente, $punto);
            $punto = "POINT($latitud $longitud)";
            mysqli_stmt_execute($stmt_insertar);

            if (mysqli_stmt_error($stmt_insertar)) {
                echo "<script>alert('Error no se pudo insertar el registro');</script>";
            } else {
                echo "<script>alert('Chacra Agregada con Exito');</script>";
            }
        }
    }
    echo "<script>window.location='index.php?modulo=chacras';</script>";
}
?>
<section>
    <div class="flex items-center justify-center p-12">
        <div class="mx-auto w-full max-w-[550px]">
            <form action="index.php?modulo=agregar-chacra&accion=agregar" method="POST">
                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                        Nombre
                    </label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre de la chacra" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required/>
                </div>
                <div class="mb-5">
                    <label for="presidente" class="mb-3 block text-base font-medium text-[#07074D]">
                        Presidente
                    </label>
                    <input type="text" name="presidente" id="presidente" placeholder="Apellido y Nombre" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required/>
                </div>
                <div class="mb-5">
                    <label for="ubicacion" class="flex justify-center mb-3 text-base font-medium text-[#07074D]">
                        Ingrese la ubicación:
                    </label>
                    <label for="latitud" class="mb-3 block text-base font-medium text-[#07074D]">
                        Latitud
                    </label>
                    <input type="text" name="latitud" id="latitud" placeholder="Ej. 40.7128" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                    <label for="longitud" class="mt-2 mb-3 block text-base font-medium text-[#07074D]">
                        Longitud
                    </label>
                    <input type="text" name="longitud" id="longitud" placeholder="Ej. -74.0060" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required/>
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