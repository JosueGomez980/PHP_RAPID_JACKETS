<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php
    include_once 'includes/ContenidoPagina.php';
    include_once 'cargar_clases.php';

    $contenido = ContenidoPagina::getInstancia();
    $contenido->getHead();

    AutoCarga::init();
    $proDAO = ProductoDAO::getInstancia();
    $proDAO instanceof ProductoDAO;
    $userManager = new UsuarioController();
    $proMQT = new ProductoMaquetador();
    $productoControl = new ProductoController();
    ?>
    <body>
        <?php
        $userManager->mostrarManagerLink();
        $contenido->getHeader();
        ?>
        <div id="CARRITO"></div>
        <section class="m-section">
            <?php
            $userManager->mostrarNavbarUsuario();
            ?>
            <div class="w3-row">
                <div class="w3-container w3-half w3-light-grey">
                    <h4 class="w3-center">Buscar por...</h4> 
                    <label  class="labels">Categoría</label>
                    <?php
                    $proMQT->maquetaCategoriasForUser();
                    ?>
                </div>
                <div class="w3-container w3-half w3-card-4 w3-padding-8">
                    <label class="labels">Buscar por Nombre del producto</label>
                    <div class="w3-padding-4">
                        <input type="text" class="input_texto" name="producto_name" id="producto_name" placeholder="Nombre a buscar" onkeyup="mostrarProductosPorNombre();"><br>
                        <button class="w3-btn w3-theme-d2 w3-round-medium" onclick="mostrarProductosPorNombre();">Buscar</button>
                        <button onclick="document.getElementById('modal_busqueda').style.display = 'block'" class="w3-button w3-theme-dark w3-round-medium w3-small">Búsqueda Avanzada</button>
                    </div>
                </div>
            </div>

            <div class="w3-row w3-responsive">
                <div id="TAB_ADV_SEARCH">
                    <!----------------------------------------------------------------------------------------->
                    <?php $productoControl->mostrarModalBusquedaAvanzada('PRODUCTOS', 'producto_busqueda_avanzada_user'); ?>
                    <!------------------------------------------------------------------------------------------------->
                </div>
            </div>

            <hr class="w3-lime w3-padding-4">
            <div id="RTA" class="w3-center">
                <div id="PRODUCTOS" class="w3-responsive w3-center w3-padding-large">
                    <?php
                    $productoControl->listarPorDefecto();
                    ?>
                </div>
            </div>
        </section>
        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>
