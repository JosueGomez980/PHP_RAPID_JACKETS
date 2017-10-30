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
            <div class="w3-center">
                
            </div>
            <?php
            $paginador->maquetarBarraPaginacion();
            ?>
            
            <div id="TABLA_CRUD">
                <?php
                $proManager->mostrarCrudTableForInventario($tablaUsuariosPaginada);
                ?>
            </div>
            <?php
            $paginador->maquetarBarraPaginacion();
            ?>
            
        </section>
        <?php
        $contenido->getFooter2();
        ?>
    </body>
</html>

