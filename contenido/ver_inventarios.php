<?php
require_once 'includes/ContenidoPagina.php';
require_once 'cargar_clases.php';

AutoCarga::init();
$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);

$acceso->validaEnviode("producto_id", AccesoPagina::GES_INVT);

$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;

$userManager = new UsuarioController();
$prodManager = new ProductoController();
$proMQT = new ProductoMaquetador();
$proDAO = ProductoDAO::getInstancia();
$proDAO instanceof ProductoDAO;
$prodReq = new ProductoRequest();
$proDTO = $prodReq->getProductoDTO();
$proDTO instanceof ProductoDTO;
$proDTO->setIdProducto(CriptManager::urlVarDecript($proDTO->getIdProducto()));

$inventarioControl = InventarioController::getInstancia();
$inventarioControl instanceof InventarioController;

$tablaInventarios = $inventarioControl->encontrarPorProducto($proDTO);

if (!is_null($tablaInventarios)) {
    $paginador = new PaginadorMemoria(15, 20, $tablaInventarios);
    $tablaIventariosPaginada = $paginador->firstPage();
    $paginador->init("inventarios_por_producto_paginacion.php", "TABLA_INVENTARIOS");
    $sesion->add(Session::PAGINADOR, $paginador);
    $proFinded = $proDAO->find($proDTO);
    //Obtencion de los datos para maquetar el header de esta consulta
    $nombrePro = Validador::fixTexto($proFinded->getNombre());
    $cantidadPro = $proFinded->getCantidad();
    $numInventarios = count($tablaInventarios);
    $valorTotal = Validador::formatPesos($proFinded->getPrecio() * $proFinded->getCantidad());
    $fotoUrl = $proMQT->urlFoto($proFinded->getFoto());
    //--------------------------------------------------------------
} else {
    $modal = new ModalSimple();
    $error = new Neutral();
    $error->setValor("Este producto no posee inventarios");
    $modal->addElemento($error);
    $closeBtn = new CloseBtn();
    $closeBtn->setValor("Aceptar");
    $modal->addElemento($closeBtn);
    $sesion->add(Session::NEGOCIO_RTA, $modal);
    $acceso->irPagina(AccesoPagina::GES_INVT);
}
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

    <?php
    $contenido = ContenidoPagina::getInstancia();
    $contenido instanceof ContenidoPagina;
    $contenido->getHead2();
    ?>
    <body>
        <?php
        $contenido->getHeader2();
        $contenido->mostrarRespuestaNegocio();
        ?>
        <section class="is-Fondo-03">
            <?php
            $userManager->mostrarNavAdminUsuario();
            ?>
            <div id="RTA_NEGOCIO"></div>
            <div class="w3-padding-xlarge">
                <a href="gestion_inventarios.php">
                    <button class="is-Button-Volver">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        <b>Volver a productos</b>
                    </button>
                </a>
            </div>
            <div class="container-fluid is-Tamaño-ContainerXD">
                <div class="w3-padding-xlarge">
                    <div class="w3-row w3-card-4 w3-white">
                        <div class="col-md-8">
                            <br><br>
                            <div class="container-fluid is-Tamaño-ContainerXD">
                                <span class="w3-xlarge w3-text-black"><b><?php echo($nombrePro); ?></b></span><br><br>
                                <span class="w3-large w3-text-black">Existente: </span>
                                <span class="w3-tag w3-green w3-round w3-large"><?php echo($cantidadPro); ?></span> Unds<br>
                                <span class="w3-large w3-text-black">Inventarios realizados: </span>
                                <span class="w3-tag w3-light-green w3-round w3-large"><?php echo($numInventarios); ?></span><br><br>
                                <span class="w3-large w3-text-black">Valor total de mercancía: </span>
                                <span class="w3-tag w3-blue w3-round w3-large"><?php echo($valorTotal); ?></span><br>
                            </div>
                            <br><br><br>
                        </div>
                        <div class="col-md-4 w3-center" style="padding-left: 8%;">
                            <br><br>
                            <img class="w3-card-4 img-rounded img-responsive" style="width: 190px; height: 200px;" src="<?php echo($fotoUrl); ?>" alt="" title="">
                            <br><br>
                        </div>
                        <br><br><br>
                    </div>
                </div>
            </div>
            <br>
            <div id="TABLA_INVENTARIOS">
                <?php
                $inventarioControl->mostrarTablaInventarios($tablaIventariosPaginada);
                ?>
            </div>
            <br><br>
        </section>
        <?php
        $contenido->getFooter2();
        ?>
    </body>
</html>

