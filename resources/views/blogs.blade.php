<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>List Blogs</title>

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container-md scroll-example">
            <div class="row justify-content-center fs-2 fw-bold">
                Listado de Noticias
            </div>
            <div id="listado-Noticias" class="row row-cols-1 row-cols-md-3 g-4">
            </div>
            <template id="plantilla-noticia" >
                <div class="card-group">
                    <div class="card border-secondary">
                        <img id="image" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 id="title" class="card-title fs-3 fw-bold"></h5>
                            <p class="card-text"><small id="autor" class="text-body-secondary"></small></p>
                            <p  id="content" class="card-text"></p>
                            <a id="link"  class="card-link">Mas información</a>
                        </div>
                    </div>
                </div>
            </template>

            <div class="justify-content-start mt-3 mb-2" >
                <button id="atras" class="btn btn-outline-info"><strong class="fs-3 fw-bolder"> < </strong></button>
                <span id="informacion-pagina"></span>
                <button id="siguiente" class="btn btn-outline-info"><strong class="fs-3 fw-bolder"> > </strong></button>
            </div>

        </div>

        <script>

            const listadoNoticiasDOM = document.querySelector("#listado-Noticias");
            const botonAtrasDOM = document.querySelector("#atras");
            const informacionPaginaDOM = document.querySelector("#informacion-pagina");
            const botonSiguienteDOM = document.querySelector("#siguiente");
            const plantillaNoticia = document.querySelector("#plantilla-noticia").content.firstElementChild;
            const elementosPorPagina = 10;
            let paginaActual = 1;
            const baseDeDatos = @json($blogs);
            const users = @json($users['results']);

            function avanzarPagina() {
                paginaActual = paginaActual + 1;
                renderizar();
            }
            function retrocederPagina() {
                paginaActual = paginaActual - 1;
                renderizar();
            }
            function obtenerRebanadaDeBaseDeDatos(pagina = 1) {
                const corteDeInicio = (paginaActual - 1) * elementosPorPagina;
                const corteDeFinal = corteDeInicio + elementosPorPagina;
                return baseDeDatos.slice(corteDeInicio, corteDeFinal);
            }
            function obtenerPaginasTotales() {
                return Math.ceil(baseDeDatos.length / elementosPorPagina);
            }
            function gestionarBotones() {
                // Comprobar que no se pueda retroceder
                if (paginaActual === 1) {
                    botonAtrasDOM.setAttribute("disabled", true);
                } else {
                    botonAtrasDOM.removeAttribute("disabled");
                }
                // Comprobar que no se pueda avanzar
                if (paginaActual === obtenerPaginasTotales()) {
                    botonSiguienteDOM.setAttribute("disabled", true);
                } else {
                    botonSiguienteDOM.removeAttribute("disabled");
                }
            }
            function renderizar() {

                listadoNoticiasDOM.innerHTML = "";
                const obtenerDatos = obtenerRebanadaDeBaseDeDatos(paginaActual);
                gestionarBotones();
                informacionPaginaDOM.textContent = `${paginaActual}/${obtenerPaginasTotales()}`;
                obtenerDatos.forEach(function (datosNoticia) {
                    const miNoticia = plantillaNoticia.cloneNode(true);
                    const miImagen = miNoticia.querySelector("#image");
                    miImagen.setAttribute('src', datosNoticia.urlToImage);
                    const miTitulo = miNoticia.querySelector("#title");
                    miTitulo.textContent = datosNoticia.title;
                    if (users.length > 0) {
                        let data = users.pop();
                        const miAutor = miNoticia.querySelector("#autor");
                        miAutor.textContent = data['name'].first + ' ' + data['name'].last;
                    } else {
                        const miAutor = miNoticia.querySelector("#autor");
                        miAutor.textContent = datosNoticia.author;
                    }
                    const miContexto = miNoticia.querySelector("#content");
                    miContexto.textContent = datosNoticia.description;
                    const miInfo = miNoticia.querySelector("#link");
                    miInfo.setAttribute('href', datosNoticia.url);

                    listadoNoticiasDOM.appendChild(miNoticia);
                });
            }

            botonAtrasDOM.addEventListener("click", retrocederPagina);
            botonSiguienteDOM.addEventListener("click", avanzarPagina);

            renderizar();
        </script>
    </body>
</html>
