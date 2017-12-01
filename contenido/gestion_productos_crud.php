<?php
include_once 'includes/ContenidoPagina.php';
include_once 'cargar_clases.php';
AutoCarga::init();
$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);


$userManager = new ProductoController();
$userMGN = NEW UsuarioController();
$categoriaManager = new CategoriaController();
$productoControl = ProductoController::getInstancia();
$productoControl instanceof ProductoController;
$productoMAQ = new ProductoMaquetador();
$productoDAO = ProductoDAO::getInstancia();
$productoDAO instanceof ProductoDAO;
$dater = new DateManager();

$tablaInventarios = $productoDAO->findAll();

$paginador = new PaginadorMemoria(20, 20, $tablaInventarios);
$tablaUsuariosPaginada = $paginador->firstPage();
$paginador->init("producto_paginacion.php", "TABLA_CRUD");
$sesion->add(Session::PAGINADOR, $paginador);
ob_start();
?>

<!DOCTYPE html>

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
            $userMGN->mostrarNavAdminUsuario();
            ?>
            <div class="w3-padding-xlarge">
                <a href="gestion_productos.php">
                    <button class="is-Button-Volver">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        <b>Volver</b>
                    </button>
                </a>
            </div>
            <br>
            <!-----------------------Espacio pa el panel de búsqueda avanzada ---------------------------->
            <div class="container-fluid w3-white" style="border-radius: 20px; width: 75%;">
                <div class="container-fluid is-Tamaño-ContainerXD w3-white">
                    <br><br>
                    <label class="is-Labels-Negro-XD">Buscar por Nombre del producto</label>
                    <div class="w3-padding-4">
                        <center><input type="text" style="border: 1px solid #000;" class="is-Input-Text-Otro" name="producto_name" id="producto_name" placeholder="Nombre a buscar" onkeyup="mostrarProductosPorNombreAdmin();"></center>
                        <center><button class="is-Button-CarritoXD" onclick="mostrarProductosPorNombreAdmin();">Buscar</button>
                            <button onclick="document.getElementById('modal_busqueda').style.display = 'block'" class="is-Button-BusquedaXD">Búsqueda Avanzada</button></center>
                        <br><br>
                    </div>
                </div>

                <div class="w3-row w3-responsive">
                    <div id="TAB_ADV_SEARCH">
                        <!----------------------------------------------------------------------------------------->
                        <?php $productoControl->mostrarModalBusquedaAvanzada('TABLA_CRUD', 'producto_busqueda_avanzada_admin'); ?>
                        <!------------------------------------------------------------------------------------------------->
                    </div>
                </div>
            </div>
            <br><br>
            <!--<div class="w3-row">
                <div class="w3-container w3-half w3-card-4 w3-padding-8">
                    <label class="labels">Buscar por Nombre del producto</label>
                    <div class="w3-padding-4">
                        <input type="text" class="input_texto" name="producto_name" id="producto_name" placeholder="Nombre a buscar" onkeyup="mostrarProductosPorNombreAdmin();"><br>
                        <button class="w3-btn w3-theme-d2 w3-round-medium" onclick="mostrarProductosPorNombreAdmin();">Buscar</button>
                        <button onclick="document.getElementById('modal_busqueda').style.display = 'block'" class="w3-button w3-theme-dark w3-round-medium w3-small">Búsqueda Avanzada</button>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->

            <!--<div class="w3-row w3-responsive">
                <div id="TAB_ADV_SEARCH">
            <!----------------------------------------------------------------------------------------->
            <?php $productoControl->mostrarModalBusquedaAvanzada('TABLA_CRUD', 'producto_busqueda_avanzada_admin'); ?>
            <!------------------------------------------------------------------------------------------------->
            <!--</div>
        </div>-->
            <div id="RESPUESTA"></div>
            <div id="TABLA_CRUD">
                <?php
                $userManager->mostrarCrudTable($tablaUsuariosPaginada);
                ?>
            </div>
            <br><br>
        </section>  
        <?php
        $contenido->getFooter2();
        ?>

    </body>

</html>

