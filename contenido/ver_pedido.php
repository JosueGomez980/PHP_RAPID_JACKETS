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

$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
$idPedidoCri = filter_input(INPUT_GET, FacturaRequest::fac_id);
$idPedido = CriptManager::urlVarDecript(filter_input(INPUT_GET, FacturaRequest::fac_id));
$pedidoDTO = new PedidoEntregaDTO();
$pedidoDTO->setFacturaIdFactura($idPedido);
$pedidoDAO = new PedidoEntregaDAO();
$pedidoFinded = $pedidoDAO->findByFactura($pedidoDTO);
if (is_null($pedidoFinded)) {
    $modal = new ModalSimple();
    $err = new Errado();
    $err->setValor("No se encontró un pedido. Revisa la url con la que accediste e intenta de nuevo");
    $modal->addElemento($err);
    $modal->setClosebtn("Aceptar");
    $sesion->add(Session::NEGOCIO_RTA, $modal);
    $acceso->irPagina(AccesoPagina::PED_GEST);
}
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

            <div id="PEDIDO_FULL">
                <div class="w3-display-container">
                    <button class="w3-display-topleft btn btn-info" onclick="document.location = 'gestion_pedidos_facturas.php'"  data-toggle="tooltip" data-placement="top" title="Volver a los pedidos">
                        <span class="glyphicon glyphicon-circle-arrow-left"></span> Volver
                    </button>
                </div>
                <div class="w3-center w3-padding-large">
                    <div class="w3-container">
                        <span class="w3-tag w3-large w3-theme-d3">Acciones rápidas</span>
                    </div>
                    <button class="btn btn-success">
                        <span class="glyphicon glyphicon-ok"> Aceptar Pedido</span>
                    </button>
                </div>

                <?php
                $facturaManager->mostrarFacturaWebTipoB($pedidoFinded);
                ?>
            </div>
        </section>
        <?php
        $contenido->getFooter2();
        ?>
    </body>
</html>

