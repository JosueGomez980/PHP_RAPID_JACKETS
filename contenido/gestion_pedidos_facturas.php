<?php
include_once 'includes/ContenidoPagina.php';
include_once 'cargar_clases.php';

AutoCarga::init();

$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);
$contenido = ContenidoPagina::getInstancia();
$contenido instanceof ContenidoPagina;
$pedidoManager = new FacturaController();
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
            <div id="LOAD_GIF"></div>
            <div class="w3-row container-fluid w3-white w3-padding-large">
                <div class="w3-half w3-container">
                    <h4 class="w3-text-blue-gray">Ver pedidos según fechas predefinidas</h4>
                    <label class="labels">Seleccione</label>
                    <select class="m-selects w3-input" name="selectFindByFechas" id="selectFindByFechas" onchange="buscarPedidosPorFechasAdmin();">
                        <option value="FD_A">Ver pedidos solicitados hoy</option>
                        <option value="FD_B">Ver pedidos solicitados ayer</option>
                        <option value="FD_C">Ver pedidos solicitados durante la semana</option>
                        <option value="FD_D">Ver pedidos solicitados durante el mes</option>
                        <option value="FD_E">Ver pedidos solicitados durante este año</option>
                    </select>
                </div>
                <div class="w3-half w3-container">
                    <h4 class="w3-text-shadow-white">Búsqueda avanzada de pedidos</h4>
                </div>
            </div>
            <div class="w3-row w3-padding-xlarge">
                <div id="TABLA_CRUD_PEDIDOS" class="w3-responsive w3-border-black">
                    <?php
                        $pedidoManager->mostrarCrudPedidosPorFechaPredefinida("FD_A");
                    ?>
                </div>
            </div>
            
            <?php
            ?>
        </section>
        <?php
        $contenido->getFooter2();
        ?>
    </body>
</html>

