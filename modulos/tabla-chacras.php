<header class="bg-gray-800 shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
            Tabla de Chacras
        </h1>
        <br />
    </div>
</header>
<form action="" method="post">
    <div class="flex items-center w-1/2 mx-auto bg-white rounded-lg mt-5 ">
        <div class="w-full">
            <label for="campo" class="hidden"></label>
            <input type="search" class="w-full px-4 py-1 text-gray-800 rounded-full focus:outline-none" placeholder="Buscar" id="campo" name="buscar">
        </div>
        <div>
            <button type="submit" class="flex items-center bg-blue-500 justify-center w-12 h-12 text-white rounded-r-lg" :class="(search.length > 0) ? 'bg-purple-500' : 'bg-gray-500 cursor-not-allowed'" :disabled="search.length == 0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </div>
    </div>
</form>
<div class="flex justify-center mt-10 mb-0">
    <a href="index.php?modulo=agregar-punto">
        <button class="middle none center mr-4 rounded-lg bg-gray-800 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg hover:shadow-gray-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
            Agregar Punto
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
        <tbody id="content">
         
        </tbody>
    </table>
    <script>
        getData()
        function getData(){
            let input = document.getElementById("campo").value;
            let content = document.getElementById("content");
            let url = "modulos/load.php"
            let formData = new FormData();
            formData.append('campo', input);

            fetch(url, {
                method: "POST",
                body: formData
            }).then(response => response.json())
            .then(data => {
                content.innerHTML = data
            }).catch(err => console.log(err))
        }
    </script>
</section>