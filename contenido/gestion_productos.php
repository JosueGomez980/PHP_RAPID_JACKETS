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
$categoriaManager = new CategoriaController();
?>

<!DOCTYPE html>

<html>
    <?php
    $contenido = ContenidoPagina::getInstancia();
    $contenido instanceof ContenidoPagina;
    $contenido->getHead2();
    ?>
    <body>
        <div class="w3-container w3-card-8 w3-theme-d4" id="RTA"></div>
        <?php
        $contenido->getHeader2();
        if ($sesion->existe(Session::NEGOCIO_RTA)) {
            $modal = $sesion->getEntidad(Session::NEGOCIO_RTA);
            $modal instanceof ModalSimple;
            $modal->open();
            $modal->maquetar();
            $modal->close();
            $sesion->removeEntidad(Session::NEGOCIO_RTA);
        }
        ?>
        <section class="m-section">

            <div class="w3-container w3-padding-12">
                <div class="w3-row w3-theme-d1">
                    <div class="w3-threequarter w3-center">
                        <button onclick="mostrarOcultarTab('new_producto');
                                cleanDV('RESPUESTA');" class="w3-btn w3-ripple w3-orange w3-round-large w3-hover-blue">Nuevo Producto</button>
                        <button onclick="mostrarOcultarTab('update_producto');
                                cleanDV('RESPUESTA');" class="w3-btn w3-ripple w3-orange w3-round-large w3-hover-blue">Modificar Producto</button>
                        <button onclick="mostrarOcultarTab('disable_enable_producto');
                                cleanDV('RESPUESTA');" class="w3-btn w3-ripple w3-orange w3-round-large w3-hover-blue">Activar/Desactivar Producto</button>
                                    <a href="gestion_productos_crud.php"><button class="w3-btn w3-ripple w3-orange w3-round-large w3-hover-blue">Ver tabla completa</button></a>
                    </div>
                </div>
                <hr class="w3-padding-4 w3-theme-dark">
                <!-- ---------------------------------------------------------------------- -->
                <div id="new_producto" class="tab w3-animate-top">
                    <span class="tit4">Registrar un nuevo producto</span><br>
                    <form method="POST" id="new_producto" name="new_producto" action="controlador/negocio/producto_insert.php" enctype="multipart/form-data">
                        <div class="w3-row">
                            <div class="w3-quarter w3-container"></div>
                            <div class="w3-half w3-container">
                                <label class="labels">Nombre</label>
                                <input type="text" class="input_texto" name="producto_name" id="producto_name" required onblur="valida_simple_input(this)" placeholder="Digite nombre del producto">
                                <label class="labels">Categoria asociada</label>
                                <?php
                                $categoriaManager->mostrarCategoriaSelect(ProductoRequest::pro_id_cat, ProductoRequest::pro_id_cat, null);
                                ?>
                                <br>
                                <label class="labels">Descripción</label>
                                <textarea class="m-textarea" id="producto_descripcion" name="producto_descripcion" required>
                                Sin descripcion disponible
                                </textarea>
                                <br><br>
                                <label class="labels">Colocar una imagen (Opcional, puede hacerlo después)</label>
                                <!---------------------------------------------------------------------------------->
                                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo(FileUpload::DOS_MB) ?>" />
                                <input onchange="" type="file" name="producto_image" id="producto_image" class="w3-btn w3-hover-amber w3-theme-dark" value="Seleccione una imagen">
                                <br><br>
                                <label class="labels">Precio<span class="w3-badge">$</span></label>
                                <input type="number" class="input_number" min="1" max="9999999999" name="producto_precio" id="producto_precio" onblur="valida_simple_input(this)">
                                <div class="w3-center w3-container w3-padding-4 w3-theme-l1">
                                    <input type="submit" name="envio" id="enviar" value="Guardar"  class="m-boton-a w3-green">
                                    <input type="reset" name="borrar" id="borrar" value="Borrar"  class="m-boton-a">
                                    <a href="admin_panel.php"><button class="m-boton-a w3-red" name="cancelar" id="cancel">Cancelar</button></a>
                                </div>
                            </div>
                            <div class="w3-quarter w3-container"></div>
                        </div>
                    </form>
                </div>
                <!-- ---------------------------------------------------------------------- -->    
                <div id="update_producto" class="tab w3-animate-top w3-hide">
                    <span class="tit4">Modifica un producto</span>
                    <div class="w3-amber">
                        <div class="w3-row">
                            <div class="w3-quarter w3-container"></div>
                            <div class="w3-half w3-container">
                                <label class="labels">Código del producto</label>
                                <input type="text" class="input_texto" name="producto_id" id="producto_id_search" required placeholder="Digite código" onblur="valida_simple_input(this)">
                                <br>
                                <div class="w3-center w3-container w3-padding-4 w3-theme-l1">
                                    <input type="submit" name="envio" id="enviar" value="Buscar"  class="m-boton-a w3-green" onclick="mostrarUpdateFormProducto('RESPUESTA')">
                                    <a href="admin_panel.php"><button class="m-boton-a w3-red" name="cancelar" id="cancel">Cancelar</button></a>
                                </div>
                                <hr>
                            </div>
                            <div class="w3-quarter w3-container"></div>
                        </div>
                    </div>

                </div>


                <!-- ---------------------------------------------------------------------- -->

                <div id="disable_enable_producto" class="tab w3-animate-top w3-hide">
                    <span class="tit4">Activar/Desactivar un producto</span>
                    <div class="w3-theme-l2">
                        <div class="w3-row">
                            <div class="w3-quarter w3-container"></div>
                            <div class="w3-half w3-container">
                                <label class="labels">Código del producto</label>
                                <input type="text" class="input_texto" name="producto_id" id="producto_id_search_2" required placeholder="Digite código" onblur="valida_simple_input(this)">
                                <br>
                                <div class="w3-center w3-container w3-padding-4 w3-theme-l1">
                                    <input type="submit" name="envio" id="enviar" value="Buscar"  class="m-boton-a w3-green" onclick="mostrarDisEnable('RESPUESTA');">
                                    <a href="admin_panel.php"><button class="m-boton-a w3-red" name="cancelar" id="cancel">Cancelar</button></a>
                                </div>
                                <hr>
                            </div>
                            <div class="w3-quarter w3-container"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="RESPUESTA"></div>
        </section>
        <?php
        $contenido->getFooter2();
        ?>
    </body>
</html>

