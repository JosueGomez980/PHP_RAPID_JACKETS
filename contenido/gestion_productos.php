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
$userMNG = new UsuarioController();
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
        <section class="is-Fondo-03">
            <?php
            $userMNG->mostrarNavAdminUsuario();
            ?>
            <div class="w3-container w3-padding-12">
                <div class="w3-row">
                    <div class="container-fluid" style="width: 75%;">
                        <button onclick="mostrarOcultarTab('new_producto');
                                cleanDV('RESPUESTA');" class="is-Button-SelectXD">Nuevo Producto</button>
                        <button onclick="mostrarOcultarTab('update_producto');
                                cleanDV('RESPUESTA');" class="is-Button-SelectXD">Modificar Producto</button>
                        <button onclick="mostrarOcultarTab('disable_enable_producto');
                                cleanDV('RESPUESTA');" class="is-Button-SelectXD">Activar/Desactivar Producto</button>
                        <a href="gestion_productos_crud.php"><button class="is-Button-SelectXD">Ver tabla completa</button></a>
                    </div>
                </div>
                <br><br>
                <!-- ---------------------------------------------------------------------- -->
                <div id="new_producto" class="tab w3-animate-top">
                    <div class="container-fluid is-Tamaño-ContainerXD" style="background-color: #616A6B; border-radius:15px;">
                        <br>
                        <form method="POST" id="new_producto" name="new_producto" action="controlador/negocio/producto_insert.php" enctype="multipart/form-data">
                            <div class="w3-row"><br>
                                <div class="container-fluid" style="width: 70%;">
                                    <center><div class="w3-tag w3-green w3-round" style="width: 60%;">
                                            <span class="is-Title01 w3-center">Registrar un nuevo producto</span>
                                        </div></center><br><br>

                                    <div class="form-group">
                                        <label class="is-Labels-XD col-lg-3 control-label">Nombre : </label>
                                        <div class="col-lg-8">
                                            <input type="text" class="input_texto" name="producto_name" id="producto_name" required onblur="valida_simple_input(this)" placeholder="Digite nombre del producto">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="is-Labels-XD col-lg-3 control-label">Categoria Asociada : </label>
                                        <div class="col-lg-8">
                                            <?php
                                            $categoriaManager->mostrarCategoriaSelect(ProductoRequest::pro_id_cat, ProductoRequest::pro_id_cat, null);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="is-Labels-XD col-lg-3 control-label">Descripción : </label>
                                        <div class="col-lg-8">
                                            <textarea class="m-textarea" id="producto_descripcion" name="producto_descripcion" required>Sin descripcion disponible</textarea>
                                            <br><br>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="form-group">
                                        <label class="is-Labels-XD col-lg-3 control-label">Colocar una imagen (Opcional, puede hacerlo después): </label>
                                        <!---------------------------------------------------------------------------------->
                                        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo(FileUpload::DOS_MB) ?>" />
                                        <div class="col-lg-9">
                                            <input onchange="" type="file" name="producto_image" id="producto_image" class="w3-btn w3-hover-amber w3-theme-dark" value="Seleccione una imagen" style="width: 80%;">
                                            <br><br>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="is-Labels-XD col-lg-3 control-label">Precio Unitario <span class="w3-badge">$</span> : </label>
                                        <div class="col-lg-8">
                                            <input type="number" class="input_number" min="1" max="9999999999" name="producto_precio" id="producto_precio" onblur="valida_simple_input(this)">
                                        </div>
                                    </div>

                                    <div class="w3-center w3-container w3-padding-4">
                                        <br>
                                        <input type="submit" name="envio" id="enviar" value="Guardar"  class="is-Button-CarritoXD-Inverted">
                                        <input type="reset" name="borrar" id="borrar" value="Borrar"  class="is-Button-BorrarXD-Inverted">
                                        <a href="admin_panel.php"><button class="is-Button-CancelarXD-Inverted" name="cancelar" id="cancel">Cancelar</button></a>
                                        <br><br>
                                    </div>
                                </div>
                                <div class="w3-quarter w3-container"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <!-- ---------------------------------------------------------------------- -->    
                <div id="update_producto" class="tab w3-animate-top w3-hide">
                    <div class="container-fluid is-Tamaño-ContainerXD" style="background-color: #616A6B; border-radius:15px;">
                        <br><br>
                        <div class="container-fluid" style="width: 70%">
                            <center><div class="w3-tag w3-green w3-round" style="width: 60%;">
                                    <span class="is-Title01 w3-center">Modificar un Producto</span>
                                </div></center><br>
                            <div class="form-group">
                                <label class="labels col-lg-3 control-label">Código del producto : </label>
                                <div class="col-lg-8">
                                    <input type="text" class="input_texto" name="producto_id" id="producto_id_search" required placeholder="Digite código" onblur="valida_simple_input(this)">
                                </div>
                            </div>
                            <br><br>
                            <center><div class="w3-center w3-container w3-padding-4 w3-theme-l1" style="width: 90%; border-radius: 10px;">
                                    <input type="submit" name="envio" id="enviar" value="Buscar"  class="is-Button-CarritoXD-Inverted" onclick="mostrarUpdateFormProducto('RESPUESTA')">
                                    <a href="admin_panel.php"><button class="is-Button-CancelarXD-Inverted" name="cancelar" id="cancel">Cancelar</button></a>
                                </div></center>
                            <hr>
                            <br>
                        </div>
                        <div class="w3-quarter w3-container"></div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <!-- ---------------------------------------------------------------------- -->

        <div id="disable_enable_producto" class="tab w3-animate-top w3-hide">
            <div class="container-fluid is-Tamaño-ContainerXD" style="background-color: #616A6B; border-radius:15px;">
                <br><br>
                <div class="container-fluid" style="width: 70%">
                    <center><div class="w3-tag w3-green w3-round" style="width: 60%;">
                            <span class="is-Title01 w3-center">Activar/Desactivar un Producto</span>
                        </div></center><br>
                    <div class="form-group">
                        <label class="labels col-lg-3 control-label">Código del producto : </label>
                        <div class="col-lg-8">
                            <input type="text" class="input_texto" name="producto_id" id="producto_id_search_2" required placeholder="Digite código" onblur="valida_simple_input(this)">
                        </div>
                    </div>
                    <br><br>
                    <center><div class="w3-center w3-container w3-padding-4 w3-theme-l1" style="width: 90%; border-radius: 10px;">
                            <input type="submit" name="envio" id="enviar" value="Buscar"  class="is-Button-CarritoXD-Inverted" onclick="mostrarDisEnable('RESPUESTA');">
                            <a href="admin_panel.php"><button class="is-Button-CancelarXD-Inverted" name="cancelar" id="cancel">Cancelar</button></a>
                        </div></center>
                    <hr>
                    <br>
                </div>
                <div class="w3-quarter w3-container"></div>
            </div>
            <br><br>
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

