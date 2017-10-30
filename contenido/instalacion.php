<?php
include_once 'includes/ContenidoPagina.php';
require_once 'cargar_clases.php';

AutoCarga::init();
$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$contenido = ContenidoPagina::getInstancia();
$contenido instanceof ContenidoPagina;

$setupController = new SetUpController();

if ($setupController->existeTabla("USUARIO")) {
    $acceso->irPagina(AccesoPagina::INICIO);
}
?>
<html>

    <?php
    $contenido->getHead2();
    ?>
    <body>
        <?php
        $contenido->getHeaderPre();
        ?>
        <section class="m-section">
            <div class="container-fluid">
                <div class="jumbotron">
                    <h2>Bienvenido al asistente de instalacion de la base de datos</h2>
                    <div class="w3-center">
                        
                    </div>
                </div>
            </div>
        </section>
        <?php
        $contenido->getFooter2();
        ?>
    </body>
</html>

