<?php
include_once 'includes/ContenidoPagina.php';
include_once 'cargar_clases.php';

AutoCarga::init();
$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);

$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
$proManager = new ProductoController();
$categoriaManager = new CategoriaController();
$productoMAQ = new ProductoMaquetador();
$productoDAO = ProductoDAO::getInstancia();
$productoDAO instanceof ProductoDAO;
$dater = new DateManager();

$tablaInventarios = $productoDAO->findAll();

$paginador = new PaginadorMemoria(15, 20, $tablaInventarios);
$tablaUsuariosPaginada = $paginador->firstPage();
$paginador->init("inventarios_paginacion.php", "TABLA_CRUD");
$sesion->add(Session::PAGINADOR, $paginador);
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
        <section class="m-section">
            <div id="RESPUESTA"></div>
            <!-----------------------Espacio pa el panel de búsqueda avanzada ---------------------------->
            <div class="w3-row">
                <div class="w3-container w3-half w3-card-4 w3-padding-8">
                    <label class="labels">Buscar por Nombre del producto</label>
                    <div class="w3-padding-4">
                        <input type="text" class="input_texto" name="producto_name" id="producto_name" placeholder="Nombre a buscar" onkeyup="mostrarProductosPorNombreAdminInv();"><br>
                        <button class="w3-btn w3-theme-d2 w3-round-medium" onclick="mostrarProductosPorNombreAdminInv();">Buscar</button>
                        <button onclick="document.getElementById('modal_busqueda').style.display = 'block'" class="w3-button w3-theme-dark w3-round-medium w3-small">Búsqueda Avanzada</button>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->

            <div class="w3-row w3-responsive">
                <div id="TAB_ADV_SEARCH">
                    <!----------------------------------------------------------------------------------------->
                    <?php $proManager->mostrarModalBusquedaAvanzada('TABLA_CRUD', 'producto_busqueda_avanzada_admin_inv'); ?>
                    <!------------------------------------------------------------------------------------------------->
                </div>
            </div>
            <div id="TABLA_CRUD">
                <?php
                $proManager->mostrarCrudTableForInventario($tablaUsuariosPaginada);
                ?>
            </div>
        </section>
        <?php
        $contenido->getFooter2();
        ?>
    </body>
</html>

