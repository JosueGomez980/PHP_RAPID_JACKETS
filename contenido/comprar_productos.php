<?php
include_once 'includes/ContenidoPagina.php';
include_once 'cargar_clases.php';

AutoCarga::init();
$controlAcceso = AccesoPagina::getInstacia();
$controlAcceso instanceof AccesoPagina;
$controlAcceso->comprobarCarritoTieneItems();
$controlAcceso->comprobarSesion(AccesoPagina::INICIO);

$coo = CookieManager::getInstancia();
$coo instanceof CookieManager;
$controlAcceso->comprobarLimiteFacturas(AccesoPagina::INICIO);

$contenido = ContenidoPagina::getInstancia();

$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;

$userControl = UsuarioController::getInstancia();
$userControl instanceof UsuarioController;
$facturaControl = new FacturaController();

$modal = $facturaControl->insertarFacturaDefault();
?>


<!DOCTYPE html>

<html>
    <?php
    $contenido->getHead();
    ?>
    <body>
        <?php
        $contenido->getHeader();
        ?>
        <section class="is-Fondo-02">
            <?php
            $userControl->mostrarNavbarUsuario();
            ?>
            <div class="RESPUESTA"></div>
            <?php
            $userControl->mostrarNoLoginUser();
            $modal instanceof ModalSimple;
            $modal->open();
            $modal->maquetar();
            $modal->close();
            ?>
            <div id="FACTURA_USUARIO_VISTA_1">
                <br>
                <?php
                $facturaControl->mostrarFacturaWebTipoA();
                ?>
                <br><br>
            </div>
        </section>
        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>
