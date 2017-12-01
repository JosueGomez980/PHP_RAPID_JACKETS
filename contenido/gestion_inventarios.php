<?php
include_once 'includes/ContenidoPagina.php';
include_once 'cargar_clases.php';

AutoCarga::init();
$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);

$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
$userManager = new UsuarioController();
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
        <section class="is-Fondo-03">
            <?php
            $userManager->mostrarNavAdminUsuario();
            ?>
            <div id="RESPUESTA"></div>
            <!-----------------------Espacio pa el panel de búsqueda avanzada ---------------------------->
            <div class="container-fluid w3-white" style="border-radius: 20px; width: 75%;">
                <div class="container-fluid is-Tamaño-ContainerXD w3-white">
                    <br><br>
                    <label class="is-Labels-Negro-XD">Buscar por Nombre del producto</label>
                    <div class="w3-padding-4">
                        <center><input type="text" style="border: 1px solid #000;" class="is-Input-Text-Otro" name="producto_name" id="producto_name" placeholder="Nombre a buscar" onkeyup="mostrarProductosPorNombreAdminInv();"></center>
                        <center><button class="is-Button-CarritoXD" onclick="mostrarProductosPorNombreAdminInv();">Buscar</button>
                            <button onclick="document.getElementById('modal_busqueda').style.display = 'block'" class="is-Button-BusquedaXD">Búsqueda Avanzada</button></center>
                        <br><br>
                    </div>
                </div>

                <div class="w3-row w3-responsive">
                    <div id="TAB_ADV_SEARCH">
                        <!----------------------------------------------------------------------------------------->
                        <?php $proManager->mostrarModalBusquedaAvanzada('TABLA_CRUD', 'producto_busqueda_avanzada_admin_inv'); ?>
                        <!------------------------------------------------------------------------------------------------->
                    </div>
                </div>
            </div>
            <br><br>
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

