<?php
include_once 'cargar_clases.php';

AutoCarga::init();

$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$facturaManager = new FacturaController();
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);
$acceso->validaEnviode(FacturaRequest::fac_id, AccesoPagina::PED_GEST);
$contenido = ContenidoPagina::getInstancia();
$contenido instanceof ContenidoPagina;

$idPedido = CriptManager::urlVarDecript(filter_input(INPUT_GET, FacturaRequest::fac_id));
$pedidoDTO = new PedidoEntregaDTO();
$pedidoDTO->setFacturaIdFactura($idPedido);
$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
?>

<!DOCTYPE html>
<html>
    <?php
    $contenido->getHead2();
    ?>
    <body>
        <?php
        $contenido->getHeader2();
        $contenido->mostrarRespuestaNegocio();
        ?>
        <section class="m-section">
            <div class="w3-display-container">
                <button class="w3-display-topleft btn btn-info" onclick="document.location = 'gestion_pedidos_facturas.php'"  data-toggle="tooltip" data-placement="top" title="Volver a los pedidos">
                    <span class="glyphicon glyphicon-circle-arrow-left"></span> Volver
                </button>
            </div>
            <?php
            ?>
        </section>
        <?php
        $contenido->getFooter2();
        ?>
    </body>
</html>

