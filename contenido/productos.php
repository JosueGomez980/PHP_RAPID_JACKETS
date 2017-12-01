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
        <section class="is-Fondo-01">
            <?php
            $userManager->mostrarNavbarUsuario();
            ?>
            <div class="w3-row">
                <div class="container-fluid is-Tamaño-ContainerXD">
                    <br>
                    <div class="w3-btn-group w3-medium">
                        <button onclick="mostrarOcultarTab('buscar_Categoria')" class="w3-btn w3-ripple w3-round-large is-Button-EscojerProXD">Buscar por Categoria</button>
                        <button onclick="mostrarOcultarTab('buscar_Nombre') " class="w3-btn w3-ripple w3-round-large is-Button-EscojerProXD">Buscar por Nombre</button>
                    </div>
                    <br>
                    <div class="container-fluid tab w3-animate-top" id="buscar_Categoria">
                        <div class="w3-container w3-white col-md-13" style="border-radius: 15px;">
                            <br><br>
                            <div class="container is-Tamaño-ContainerXD">
                                <label for="cuenta_tip_doc" class="is-Labels-Negro-XD" >Categoría : </label>
                                <?php
                                echo '<div class="w3-center">' . $proMQT->maquetaCategoriasForUser() . '</div>';
                                ?>
                                <br><br>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="w3-row tab w3-hide w3-animate-top" id="buscar_Nombre">
                        <div class="container-fluid w3-white col-md-13" style="border-radius: 20px;">
                            <div class="container-fluid is-Tamaño-ContainerXD w3-white">
                                <br><br>
                                <label class="is-Labels-Negro-XD">Buscar por Nombre del producto</label>
                                <div class="w3-padding-4">
                                    <center><input type="text" style="border: 1px solid #000;" class="is-Input-Text-Otro" name="producto_name" id="producto_name" placeholder="Nombre a buscar" onkeyup="mostrarProductosPorNombre();"></center>
                                    <center><button class="is-Button-CarritoXD" onclick="mostrarProductosPorNombre();">Buscar</button>
                                        <button onclick="document.getElementById('modal_busqueda').style.display = 'block'" class="is-Button-BusquedaXD">Búsqueda Avanzada</button></center>
                                    <br><br>
                                </div>
                            </div>

                            <div class="w3-row w3-responsive">
                                <div id="TAB_ADV_SEARCH">
                                    <!----------------------------------------------------------------------------------------->
                                    <?php $productoControl->mostrarModalBusquedaAvanzada('PRODUCTOS', 'producto_busqueda_avanzada_user'); ?>
                                    <!------------------------------------------------------------------------------------------------->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <center><hr class="w3-padding-4" style="background-color: #5B2C6F; width: 90%"></center>
                <div id="RTA" class="w3-center">
                    <div class="container is-Tamaño-ContainerXD w3-white" style="border-radius: 20px;">
                        <div id="PRODUCTOS" class="w3-responsive w3-center">
                            <?php
                            $productoControl->listarPorDefecto();
                            ?>
                            <br>
                        </div>
                    </div>
                </div>
                <br><br>
        </section>
        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>
