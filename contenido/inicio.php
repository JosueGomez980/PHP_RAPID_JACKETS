<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php
    include_once 'includes/ContenidoPagina.php';
    include_once 'cargar_clases.php';

    $contenido = ContenidoPagina::getInstancia();
    $contenido instanceof ContenidoPagina;
    $contenido->getHead();

    AutoCarga::init();

    $sesion = SimpleSession::getInstancia();
    $userManager = new UsuarioController();
    ?>
    <body>
        <?php
        $contenido->getHeader();
        $contenido->mostrarRespuestaNegocio();
        // Seccion para mostrar los datos, iconos del usuario que está logeado y el menu 
        ?>
        <section class="m-section">
            <?php
            $userManager->mostrarManagerLink();
            $userManager->mostrarNavbarUsuario();
            ?>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img class="img-responsive" src="../media/img/Carrusel001.png" alt="Imagen01" style="width:100%;">
                    </div>

                    <div class="item">
                        <img class="img-responsive" src="../media/img/Carrusel002.png" alt="Imagen02" style="width:100%;">
                    </div>

                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <script>
                $(document).ready(function () {
                    // Activate Carousel
                    $("#myCarousel").carousel({interval: 4000});

                    // Enable Carousel Indicators
                    $(".item1").click(function () {
                        $("#myCarousel").carousel(0);
                    });
                    $(".item2").click(function () {
                        $("#myCarousel").carousel(1);
                    });

                    // Enable Carousel Controls

                    $(".left").click(function () {
                        $("#myCarousel").carousel("prev");
                    });
                    $(".right").click(function () {
                        $("#myCarousel").carousel("next");
                    });
                });
            </script>
        </section>
           <?php
           $contenido->getFooter();
           ?>
    </body>
</html>
