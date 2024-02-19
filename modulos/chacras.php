<header class="bg-gray-800 shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
            Tabla de Chacras
        </h1>
        <br />
    </div>
</header>
<div class="flex justify-center mt-10 mb-0">
    <a href="index.php?modulo=agregar-chacra">
        <button class="middle none center mr-4 rounded-lg bg-gray-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg hover:shadow-gray-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
            Agregar Chacra
        </button>
    </a>
</div>
<section class="mx-auto w-full max-w-full flex justify-center items-stretch pb-4 px-4 sm:px-6 lg:px-8">
    <table class="border-collapse w-full mt-10">
        <thead>
            <tr>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Nombre</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Presidente</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sqlMostrarChacra = "SELECT chacras.id, chacras.nombre, chacras.presidente   
                 FROM chacras";
            $datos = mysqli_query($con, $sqlMostrarChacra);
            if ($datos->num_rows > 0) {
                while ($fila = mysqli_fetch_array($datos)) {
            ?>
                    <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nombre</span>
                            <?php echo $fila['nombre']?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 border border-b text-center block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Presidente</span>
                            <?php echo $fila['presidente']?>
                        </td>
                        <td class="flex justify-center flex-col lg:flex-row w-full lg:w-auto p-3 text-gray-800 border border-b text-center lg:table-cell relative lg:static">
                            <!--<span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Acciones</span>-->
                            <a href="index.php?modulo=editar-chacra&idChacra=<?php echo $fila['id']?>" class="text-green-400 hover:text-green-600 mt-2 lg:mt-0">
                                <button class="middle none center mr-4 rounded-lg bg-green-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                    Editar
                                </button>
                            </a>
                            <a href="index.php?modulo=tareas&idChacra=<?php echo $fila['id']?>" class="text-yellow-400 hover:text-yellow-600 mt-2 lg:mt-0">
                                <button class="middle none center mr-4 rounded-lg bg-yellow-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-yellow-500/20 transition-all hover:shadow-lg hover:shadow-yellow-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                    Tareas
                                </button>
                            </a>
                            <a href="index.php?modulo=eliminar&id=<?php echo $fila['id']?>&tipo=chacras" class="text-red-400 hover:text-red-600 mt-2 lg:mt-0">
                                <button class="middle none center mr-4 rounded-lg bg-red-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                    Eliminar
                                </button>
                            </a>
                        </td>
                    </tr>
            <?php
                }
            }

            ?>

        </tbody>
    </table>
</section>