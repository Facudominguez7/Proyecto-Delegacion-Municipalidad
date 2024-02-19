<?php
if(isset($_GET['accion'])){
    if ($_GET['accion'] == 'editar') {
        $idChacra = $_POST['id'];
        $nombre = $_POST['nombre'];
        $presidente = $_POST['presidente'];
        $dniPresidente = $_POST['dni'];
        $latitud = $_POST['latitud'];
        $longitud = $_POST['longitud'];
    
        $sqlEditarChacra = "UPDATE chacras SET nombre=?, presidente=?, dniPresidente=?, ubicacion=POINT(?, ?) WHERE id=?";
        $stmt = mysqli_prepare($con, $sqlEditarChacra);
        mysqli_stmt_bind_param($stmt, "sssddi", $nombre, $presidente, $dniPresidente, $latitud, $longitud, $idChacra);
        mysqli_stmt_execute($stmt);
    
        // Verificar si se produjeron errores
        if (mysqli_stmt_error($stmt)) {
            echo "Error al actualizar la chacra: " . mysqli_stmt_error($stmt);
        } else {
            echo "<script>alert('Chacra Actualizada con Éxito');</script>";
        }
        // Cerrar la declaración preparada
        mysqli_stmt_close($stmt);
    }
    echo "<script>window.location='index.php?modulo=chacras';</script>";
}

?>
<section>
    <div class="flex items-center justify-center p-12">
        <div class="mx-auto w-full max-w-[550px]">
            <?php
            $idChacra = $_GET['idChacra'];
            $sql = "SELECT id, nombre, presidente, dniPresidente, ST_X(ubicacion) as latitud, ST_Y(ubicacion) as longitud From chacras WHERE chacras.id = $idChacra";
            $sql = mysqli_query($con, $sql);
            if (mysqli_num_rows($sql) != 0) {
                $r = mysqli_fetch_array($sql);
            }
            ?>
            <form action="index.php?modulo=editar-chacra&accion=editar" method="POST">
                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                        Nombre
                    </label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $r['nombre'] ?>" placeholder="Nombre de la chacra" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
                <div class="mb-5">
                    <label for="presidente" class="mb-3 block text-base font-medium text-[#07074D]">
                        Presidente
                    </label>
                    <input type="text" name="presidente" id="presidente" value="<?php echo $r['presidente'] ?>" placeholder="Apellido y Nombre" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
                <div class="mb-5">
                    <label for="dni" class="mb-3 block text-base font-medium text-[#07074D]">
                        DNI del Presidente
                    </label>
                    <input type="number" name="dni" id="dni" value="<?php echo $r['dniPresidente'] ?>" placeholder="Apellido y Nombre" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
                <div class="mb-5">
                    <label for="ubicacion" class="flex justify-center mb-3 text-base font-medium text-[#07074D]">
                        Ingrese la ubicación:
                    </label>
                    <label for="latitud" class="mb-3 block text-base font-medium text-[#07074D]">
                        Latitud
                    </label>
                    <input type="text" name="latitud" id="latitud" value="<?php echo $r['latitud'] ?>" placeholder="Ej. 40.7128" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    <label for="longitud" class="mt-2 mb-3 block text-base font-medium text-[#07074D]">
                        Longitud
                    </label>
                    <input type="text" name="longitud" id="longitud" value="<?php echo $r['longitud'] ?>" placeholder="Ej. -74.0060" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    <input type="number" name="id" id="idChacra" value="<?php echo $r['id'] ?>" class="hidden w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
                <div>
                    <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Editar
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>