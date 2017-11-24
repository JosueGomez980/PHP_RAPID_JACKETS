<?php
include_once 'includes/ContenidoPagina.php';
include_once 'cargar_clases.php';

$contenido = ContenidoPagina::getInstancia();
$contenido instanceof ContenidoPagina;
$contenido->getHead();

AutoCarga::init();

$userManager = new UsuarioController();

?>
<!DOCTYPE html>

<html>

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
