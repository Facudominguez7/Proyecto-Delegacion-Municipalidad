function mostrarVistaPrevia() {
    var input = document.getElementById("lista");
    var vistaPreviaContainer = document.getElementById("vista_previa_container");
    //Borra el contenido del elemento 
    vistaPreviaContainer.innerHTML = "";

    if (input.files && input.files.length > 0) {
        for (var i = 0; i < input.files.length; i++) {
            var imagenPrevia = document.createElement("img");
            imagenPrevia.src = URL.createObjectURL(input.files[i]);
            vistaPreviaContainer.appendChild(imagenPrevia);
        }
    }
}