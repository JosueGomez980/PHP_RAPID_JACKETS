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
            ?>
            <div class="slider"> 
                <ul>
                    <img src="../media/img/imagen1.png" alt="">
                    <img src="../media/img/imagen.png" alt="">
                    <img src="../media/img/imagen1.png" alt="">
                </ul>
            </div>
        </section>
           <?php
           $contenido->getFooter();
           ?>
    </body>
</html>
