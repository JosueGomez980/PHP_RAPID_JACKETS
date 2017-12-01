<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductoMaquetador
 *
 * @author Josué Francisco
 */
class ProductoMaquetador implements GenericMaquetador {

    public function maquetaArrayObject(array $entidades) {
        echo('<div class="w3-row w3-container" id="productos_principal">');
        foreach ($entidades as $producto) {
            $botonCarrito = "";
            $inputCarrito = "";
            $producto instanceof ProductoDTO;
            $nombre = $producto->getNombre();
            $precio = Validador::formatPesos($producto->getPrecio());
            $idProducto = base64_encode($producto->getIdProducto());
            $idProductoUrl = CriptManager::urlVarEncript($producto->getIdProducto());
            $foto = $this->urlFoto($producto->getFoto());
            $cantidad = $producto->getCantidad();
            if ($producto->getCantidad() <= 0) {
                $inputCarrito = '<div class="w3-display-container w3-grey w3-small negri" style="height: 60px;"><div class="w3-display-middle"> PRODUCTO AGOTADO </div></div>';
//                $botonCarrito = '<div class="w3-center w3-container w3-tiny w3-padding-4 w3-gray">
//                    No está a la venta
//                </div>';
            } else {
                $inputCarrito = '<div class="w3-center"><input type="number" id="' . $idProducto . '" class="input_carrito w3-center" max="' . $cantidad . '" min="1" placeholder="Cantidad"></div>';
                $botonCarrito = '<button class="m-boton-add-carrito" onclick="agregarAlCarrito(this)">
                                        <input type="hidden" value="' . $idProducto . '">
                                        <img src="../media/img/carrito_compra.png" alt="Agregar al carrito" title="Agregar al carrito" class="m-carrito">
                                        Agregar al carrito
                                    </button>';
            }
            if ($producto->getActivo()) {
                echo('<div class="w3-col m6 l2 s10">
                        <div class="w3-card-8 w3-white m-producto-card">
                            <a href="producto_ficha_tecnica.php?producto_id=' . $idProductoUrl . '"><img src="' . $foto . '" alt="' . $nombre . '" title="' . $nombre . '" class="is-Producto-view-1-img"></a>
                            <input type="hidden" value="' . $idProducto . '">
                            <div class="w3-container w3-white m-producto-name">
                                <span><br>' . $nombre . '</span>                                
                            </div>
                            <br>
                            <div class="w3-row is-Color16">
                                <br>
                                <div class="w3-center"><input type="number" id="' . $idProducto . '" class="input_carrito w3-center" max="' . $cantidad . '" min="1" placeholder="Cantidad"></div>
                                <br>
                                <div class="w3-half w3-center" style="padding: 5%  5%";>
                                    <span class="w3-round is-Color17 w3-padding-4">' . $precio . '</span>
                                </div>
                                <div class="w3-half w3-center">
                                    <button class="is-Button-Carrito" onclick="agregarAlCarrito(this)">
                                        <input type="hidden" value="' . $idProducto . '">
                                        <img src="../media/img/carrito2.png" alt="Agregar al carrito" title="Agregar al carrito" class="m-carrito">
                                        Agregar al Carrito
                                    </button>
                                </div>
                                <br><br><br>
                            </div>
                        </div>
                    </div>');
            }
        }
        echo('</div>');
    }

    public function maquetaArrayObjectNoSession(array $entidades) {
        echo('<div class="w3-row w3-container" id="productos_principal">');
        foreach ($entidades as $producto) {
            $botonCarrito = "";
            $inputCarrito = "";
            $producto instanceof ProductoDTO;
            $nombre = $producto->getNombre();
            $precio = Validador::formatPesos($producto->getPrecio());
            $idProducto = base64_encode($producto->getIdProducto());
            $idProductoUrl = CriptManager::urlVarEncript($producto->getIdProducto());
            $foto = $this->urlFoto($producto->getFoto());
            $cantidad = $producto->getCantidad();
            if ($producto->getCantidad() <= 0) {
                $inputCarrito = '<div class="w3-display-container w3-grey w3-small negri" style="height: 60px;"><div class="w3-display-middle"> PRODUCTO AGOTADO </div></div>';
//                $botonCarrito = '<div class="w3-center w3-container w3-tiny w3-padding-4 w3-gray">
//                    No está a la venta
//                </div>';
            } else {
                $inputCarrito = '<div class="w3-center"><input type="number" id="' . $idProducto . '" class="input_carrito w3-center" max="' . $cantidad . '" min="1" placeholder="Cantidad"></div>';
                $botonCarrito = '<button class="m-boton-add-carrito" onclick="agregarAlCarrito(this)">
                                        <input type="hidden" value="' . $idProducto . '">
                                        <img src="../media/img/carrito_compra.png" alt="Agregar al carrito" title="Agregar al carrito" class="m-carrito">
                                        Agregar al carrito
                                    </button>';
            }

            if ($producto->getActivo()) {
                echo('<div class="w3-col m6 l2 s10">
                        <div class="w3-card-8 w3-white m-producto-card">
                            <a href="producto_ficha_tecnica.php?producto_id=' . $idProductoUrl . '"><img src="' . $foto . '" alt="' . $nombre . '" title="' . $nombre . '" class="is-Producto-view-1-img"></a>
                            <input type="hidden" value="' . $idProducto . '">
                            <div class="w3-container w3-white m-producto-name">
                                <span><br>' . $nombre . '</span>                                
                            </div>
                            <br>
                            <div class="w3-row is-Color16">
                                <br><br>
                                <div class="w3-center">
                                    <span class="w3-round is-Color17 w3-padding-8 w3-padding-left w3-padding-right w3-center">' . $precio . '</span>
                                </div>
                                <br><br>
                            </div>
                        </div>
                    </div>');
            }
        }
        echo('</div>');
    }

    public function urlFoto($foto) {
        if ($foto == "SIN_ASIGNAR") {
            return "../media/img/default_foto.png";
        } else {
            return $foto;
        }
    }

    public function maquetaCategoriasForUser() {
        $categoriaDAO = new CategoriaDAO();
        $categorias = $categoriaDAO->findAll();
        echo('<select name="categoria_id" id="categoria_id" class="is-Selects" onchange="findByCategoria(this);">');
        foreach ($categorias as $cat) {
            $cat instanceof CategoriaDTO;
            $idCat = $cat->getIdCategoria();
            $nombre = Validador::fixTexto($cat->getNombre());
            if ($cat->getActiva() && $cat->getIdCategoria() !== $cat->getCategoriaIdCategoria()) {
                echo('<option value="' . $idCat . '">' . $nombre . '</option>');
            }
        }
        echo('</select>');
    }

    public function maquetaObject(EntityDTO $entidad) {
        //Meto para mostrar un producto en su modod de ficha Tecnica
        $entidad instanceof ProductoDTO;
        $categoriaDAO = CategoriaDAO::getInstancia();
        $categoriaDAO instanceof CategoriaDAO;
        $catFind = new CategoriaDTO();
        $catFind->setIdCategoria($entidad->getCategoriaIdCategoria());
        $cateDTO = $categoriaDAO->find($catFind);

        $idProducto = base64_encode($entidad->getIdProducto());
        $categoriaNombre = $cateDTO->getNombre();
        $nombre = ($entidad->getNombre());
        $precio = Validador::formatPesos($entidad->getPrecio());
        $descripcion = $entidad->getDescripcion();
        $cantidadDisponible = $entidad->getCantidad();
        $urlFoto = $this->urlFoto($entidad->getFoto());



        echo('<div id="' . $entidad->getIdProducto() . '" class="w3-container w3-theme-l5">
                <br><br><br><br style="padding-left: 6%; padding-right: 20%; width: 120%;">
                
                <div id="modal_pro_full_image" class="w3-modal">
                    <span class="w3-closebtn w3-white w3-hover-red w3-container w3-padding-16 w3-display-topright w3-xlarge" onclick="hide_closebtn(this)">×</span>
                    <img src="' . $urlFoto . '" class="w3-modal-content w3-animate-zoom is-Producto-PantallaCompleta">
                </div>
                
                <div class="container-fluid w3-center">
                        <div class="col-md-3">
                            <div class="w3-card-4">
                                <img class="m-producto-mq-image" src="' . $urlFoto . '" alt="' . $nombre . '" title="' . $nombre . '" onclick="show_modal(\'modal_pro_full_image\');">
                            </div>
                            <div class="w3-container is-Color16 w3-padding-8 w3-center is-Border-XD">
                            ');

        if ($entidad->getCantidad() <= 0) {
            echo ('<<span class="w3-large w3-round w3-gray w3-padding-8 w3-padding-left w3-padding-right w3-center">Producto Agotado</span>');
        } else {
            echo ('<br><br><div class="w3-center"><input type="number" id="' . $idProducto . '" class="input_carrito w3-center" max="' . $cantidadDisponible . '" min="1" placeholder="Cantidad"></div>
                                    <br>
                                    <button class="is-Button-CarritoXD" onclick="agregarAlCarrito(this)">
                                        <input type="hidden" value="' . $idProducto . '">
                                        <img src="../media/img/carrito2.png" alt="Agregar al carrito" title="Agregar al carrito" class="m-carrito">
                                        Agregar al carrito
                                    </button>');
        }
        echo ('<br><br>
                            </div>
                        </div>

                        <div class="col-md-9" style="padding-top:3%;">
                            <div class="container-fluid w3-center" style="width: 90%;">
                                <div class="w3-container w3-card-4" style="padding-left: 5%; padding-right: 5%;">
                                    <br>
                                    <div class="w3-center is-Tamaño-Letra05">' . $nombre . '</div>
                                    <hr style="border: 1px solid #909497;">
                                    <span class="is-Tamaño-Letra06"><b>Categoria : </b>' . $categoriaNombre . '</span>
                                    <br>
                                    <div class="w3-row">
                                        <div class="w3-half w3-container w3-card-4 w3-center">
                                            <br><br>
                                            <span class="w3-large"><b>Precio : </b></span>&nbsp;
                                            <span class="w3-large w3-round is-Color26 w3-padding-8 w3-padding-left w3-padding-right w3-center"><b>' . $precio . '</b></span>
                                            <br><br><br>
                                        </div>
                                        <div class="w3-half w3-container w3-card-4 w3-center">
                                            <br><br>
                                            <span class="w3-large w3-round is-Color26 w3-padding-8 w3-padding-left w3-padding-right w3-center"><b>' . $cantidadDisponible . '</b></span>&nbsp;
                                            <span class="w3-large w3-round is-Color17 w3-padding-8 w3-padding-left w3-padding-right w3-center">Unidades Disponibles</span>
                                            <br><br><br>
                                        </div>
                                    </div>
                                    <br><br>
                                    <p class="w3-justify w3-theme-light w3-large"><span style="font-size: 22px;">
                                        ' . $descripcion . '
                                    </apan></p>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                        <br><br>
                    </div>
                <br><br><br><br>
            </div><br><br></div><br></div>');
    }

    public function maquetaObjectNoSession(EntityDTO $entidad) {
        //Meto para mostrar un producto en su modod de ficha Tecnica
        $entidad instanceof ProductoDTO;
        $categoriaDAO = CategoriaDAO::getInstancia();
        $categoriaDAO instanceof CategoriaDAO;
        $catFind = new CategoriaDTO();
        $catFind->setIdCategoria($entidad->getCategoriaIdCategoria());
        $cateDTO = $categoriaDAO->find($catFind);

        $idProducto = base64_encode($entidad->getIdProducto());
        $categoriaNombre = $cateDTO->getNombre();
        $nombre = ($entidad->getNombre());
        $precio = Validador::formatPesos($entidad->getPrecio());
        $descripcion = $entidad->getDescripcion();
        $cantidadDisponible = $entidad->getCantidad();
        $urlFoto = $this->urlFoto($entidad->getFoto());

        echo('<div id="' . $entidad->getIdProducto() . '" class="w3-container w3-theme-l5">
                <br><br><br><br style="padding-left: 6%; padding-right: 20%; width: 120%;">
                
                <div id="modal_pro_full_image" class="w3-modal">
                    <span class="w3-closebtn w3-white w3-hover-red w3-container w3-padding-16 w3-display-topright w3-xlarge" onclick="hide_closebtn(this)">×</span>
                    <img src="' . $urlFoto . '" class="w3-modal-content w3-animate-zoom is-Producto-PantallaCompleta">
                </div>
                
                <div class="container-fluid w3-center">
                        <div class="col-md-3" style="padding-top:4%;">
                            <div class="w3-card-4">
                                <img class="m-producto-mq-image" src="' . $urlFoto . '" alt="' . $nombre . '" title="' . $nombre . '" onclick="show_modal(\'modal_pro_full_image\');">
                            </div>
                            <!--<div class="w3-container is-Color16 w3-padding-8 w3-center is-Border-XD">
                                <br><br>
                                <span class="w3-round is-Color17 w3-padding-8 w3-padding-left w3-padding-right w3-center">' . $nombre . '</span> 
                                <br><br><br>
                            </div>-->
                        </div>

                        <div class="col-md-9" style="padding-top:3%;">
                            <div class="container-fluid w3-center" style="width: 90%;">
                                <div class="w3-container w3-card-4" style="padding-left: 5%; padding-right: 5%;">
                                    <br>
                                    <div class="w3-center is-Tamaño-Letra05">' . $nombre . '</div>
                                    <hr style="border: 1px solid #909497;">
                                    <span class="is-Tamaño-Letra06"><b>Categoria : </b>' . $categoriaNombre . '</span>
                                    <br>
                                    <div class="w3-row">
                                    <div class="w3-half w3-container w3-card-4 w3-center" style="width: 100%;">
                                            <br><br>
                                            <span class="w3-large"><b>Precio : </b></span>&nbsp;
                                            <span class="w3-large w3-round is-Color26 w3-padding-8 w3-padding-left w3-padding-right w3-center"><b>' . $precio . '</b></span>
                                            <br><br><br>
                                        </div>
                                    </div>
                                    <br><br>
                                    <p class="w3-justify w3-theme-light w3-large"><span style="font-size: 22px;">
                                        ' . $descripcion . '
                                    </span></p>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                        <br><br>
                    </div>
                <br><br><br><br><br><br>
            </div><br><br></div><br></div>');
    }

    public function maquetaUpdateFormProducto(ProductoDTO $producto) {
        $catDTO = new CategoriaDTO();
        $catDTO->setIdCategoria($producto->getCategoriaIdCategoria());
        $catDAO = new CategoriaDAO();
        $catFinded = $catDAO->find($catDTO);
        $categoriaManager = new CategoriaController();
        $descripcion = ($producto->getDescripcion());
        $nombre = Validador::fixTexto($producto->getNombre());
        $urlFoto = $this->urlFoto($producto->getFoto());
        $precio = $producto->getPrecio();
        $idProductoUrl = CriptManager::urlVarEncript($producto->getIdProducto());
        echo('<div class="container-fluid" style="background-color: #616161; border-radius: 10px;">
            <form method="POST" id="update_producto" name="update_producto" action="controlador/negocio/producto_update.php" enctype="multipart/form-data" class"form-horizontal">
                        <div class="container-fluid is-Tamaño-ContainerXD" style="background-color: #616161;">
                        <br><span class="w3-xlarge w3-block w3-center" style="color:#FFF;">Actualizar Producto</span><hr class="w3-white"><br>
                        <div class="container-fluid">
                            <div class="form-group">
                                <label class="labels col-lg-3 control-label">Nombre :</label>
                                <div class="col-lg-8">
                                    <input type="text" class="input_texto" name="' . ProductoRequest::pro_name . '" id="' . ProductoRequest::pro_name . '" required onblur="valida_simple_input(this)" value="' . $nombre . '">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="labels col-lg-3 control-label">Categoria asociada:</label>
                                <div class="col-lg-8">');

        $categoriaManager->mostrarCategoriaSelect(ProductoRequest::pro_id_cat, ProductoRequest::pro_id_cat, $catFinded);
        echo('</div>
            </div>
            <br>
                <input type="hidden" name="' . ProductoRequest::pro_id . '" value="' . $idProductoUrl . '" />
                <div class="form-group">
                    <label class="labels col-lg-3 control-label">Descripción :</label>
                    <div class="col-lg-8">
                        <textarea class="m-textarea" id="producto_descripcion" name="producto_descripcion" required>' . $descripcion . '</textarea>
                        <br><br>
                    </div>
                <div>
                <br><br><br>
                <label class="labels w3-center">Cambiar o colocar la imagen (Opcional)</label>
                <!---------------------------------------------------------------------------------->
                <div class="form-group">
                    <label class="labels col-lg-3 control-label">Imagen actual - </label>
                    <div class="col-lg-8">
                        <center><div class="w3-center w3-col s8 m5 l3 w3-card-12 w3-white">
                            <img src="' . $urlFoto . '" id="producto_img_vista_previa" style="width: 200px; height: auto" title="' . $nombre . '" alt="' . $nombre . '">
                        </div></center>
                        <br><br><br><br><br><br><br><br><br><br><br>
                        <input type="hidden" name="MAX_FILE_SIZE" value="' . FileUpload::DOS_MB . '" />
                        <input type="file" name="producto_image" id="producto_image" class="w3-btn w3-hover-lime w3-aqua" value="Seleccione una imagen">
                        <br><br>
                    </div>
                </div>
                <br><br>
                <div class="form-group">
                    <label class="labels col-lg-3 control-label">Precio<span class="w3-badge">$</span></label>
                    <div class="col-lg-8">
                        <input type="number" value="' . $precio . '" class="input_number" min="1" max="9999999999" name="producto_precio" id="producto_precio" onblur="valida_simple_input(this)">
                        <br>
                    </div>
                </div>
                </div>
                    <center><div class="w3-tag w3-theme-l1 w3-round" style="width: 90%; height: 70px; padding-top: 2%;">
                        <input type="submit" name="envio" id="enviar" value="Modificar"  class="is-Button-CarritoXD-Inverted">
                        <input type="reset" class="is-Button-CancelarXD-Inverted" name="cancelar" id="cancel" onclick="closeE(\'modal\');" value="Cancelar" />
                    </div></center>
                </div>
        </form>
        </div>');
    }

    public function maquetaProductosSelectXD(array $productos, $namepro, $idpro, $selected) {
        echo('<select name="' . $namepro . '" id="' . $idpro . '" class="m-selects">\n');
        if (is_object($selected) && !is_null($selected)) {
            $selected instanceof ProductoDTO;
            echo('\t<option value="' . $selected->getIdProducto() . '" selected>' . $selected->getNombre() . '</option>\n');
        } else {
            echo('\t<option value="' . 0 . '" selected>Seleccionar</option>\n');
        }
        foreach ($productos as $pro) {
            $pro instanceof ProductoDTO;
            $idPro = CriptManager::urlVarEncript($pro->getIdProducto());
            $nombre = $pro->getNombre();

            if ($pro->getActivo() && $pro->getIdProducto() !== $pro->getCategoriaIdCategoria()) {
                echo('\t<option value="' . $idPro . '">' . $nombre . '</option>\n');
            }
        }
        echo('</select>');
    }

    public function maquetaProductoDisableEnable(ProductoDTO $producto) {
        $nombre = $nombreT = Validador::fixTexto($producto->getNombre());
        if ($producto->getActivo()) {
            $nombre = "<br><br>"
                    . "<center><span class='w3-text-green'>" . $nombre . "</span></center<br>"
                    . "<center><div class='w3-tag w3-green w3-round' style='width: 60%;'>"
                    . "<span class='w3-text-white'>HABILITADO</span>"
                    . "</div></center><br>";
        } else {
            $nombre = "<br><br>"
                    . "<center><span class='w3-text-grey'>" . $nombre . "</span></center<br>"
                    . "<center><div class='w3-tag w3-grey w3-round' style='width: 60%;'>"
                    . "<span class='w3-text-white'>DESHABILITADO</span>"
                    . "</div></center><br>";
        }
        $urlFoto = $this->urlFoto($producto->getFoto());
        $idPro = $producto->getIdProducto();
        echo('<div class="container-fluid is-Tamaño-ContainerXD">
                    <div class="w3-container"></div>
                    <div class="w3-container w3-white w3-padding-4">
                        <div class="w3-row">
                        <br>');

        if ($producto->getActivo()) {
            echo ('<center><div class="w3-tag w3-red w3-round" style="width: 100%;">
                                    <span class="is-Title01 w3-center">Desactivar ' . $nombreT . ' Con ID: ' . $idPro . '</span>
                                </div></center>');
        } else {
            echo ('<center><div class="w3-tag w3-green w3-round" style="width: 100%;">
                                    <span class="is-Title01 w3-center">Activar ' . $nombreT . ' Con ID: ' . $idPro . '</span>
                                </div></center>');
        }
        echo ('<br>
                          <div class="w3-threequarter">
                            <span class="w3-large">' . $nombre . '</span>
                          </div>
                          <div class="w3-quarter">
                            <img src="' . $urlFoto . '" id="producto_img_vista_previa" style="width: 100%; height: auto" title="' . $nombreT . '" alt="' . $nombreT . '" class="w3-card-8">
                          </div> 
                        </div>
                        <br>
                        <center><div class="w3-center w3-container w3-padding-4 w3-theme-l1" style="width: 90%; border-radius: 10px;">');
        if ($producto->getActivo()) {
            echo('<button class = "is-Button-DisableXD-Inverted" onclick = "disable_enable_productoXD(\'RESPUESTA\', 0)">Desactivar</button> ');
        } else {
            echo('<button class = "is-Button-CarritoXD-Inverted" onclick = "disable_enable_productoXD(\'RESPUESTA\', 1)">Activar</button> ');
        }

        echo('<input type="reset" class="is-Button-CancelarXD-Inverted" name="cancelar" id="cancel" onclick="closeE(\'modal\');" value="Cancelar" />
              </div></center>
                <hr>
                </div>
                    <div class="w3-quarter w3-container"></div>
            </div>');
    }

    public function maquetaProductoTablaCrud(array $productos) {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $paginador = $sesion->getEntidad(Session::PAGINADOR);
        $paginador instanceof PaginadorMemoria;
        $pageActual = $paginador->getPaginaActual();
        $totalPages = $paginador->getNumeroPaginas();
        $cantidad = count($productos);
        echo('<div class="container-fluid" style="width: 93%;">
                <div class="w3-theme-l4 w3-card-4">
                <div class="w3-round-large w3-xlarge w3-container is-Color28">
                    Obtenidos ' . $cantidad . ' Productos
                    <br> <span class="w3-tag w3-round-medium w3-small is-Color29">Página ' . ($pageActual) . ' de ' . $totalPages . '</span>
                </div>  
                <table class="w3-table-all w3-small w3-responsive">
                    <tr class="w3-light-green">
                        <th>ID</th>
                        <th>NOMBRE DEL PRODUCTO</th>
                        <th>PRECIO</th>
                        <th>ESTADO</th>
                        <th>Actualizar</th>
                        <th>Activar/Desactivar</th>
                    </tr>');
        foreach ($productos as $pro) {
            $pro instanceof ProductoDTO;
            $nombre = $pro->getNombre();
            $idMostrar = $pro->getIdProducto();
            $precio = Validador::formatPesos($pro->getPrecio());
            $estado = $pro->getActivo();
            $estadoM = "";
            echo('<tr class="w3-hover-light-blue w3-white">
                        <td>' . $idMostrar . '</td>
                        <td>' . $nombre . '</td>
                        <td>' . $precio . '</td>');
            if ($estado) {
                echo('<td><span class="w3-text-green">Activo</span></td>');
                $estadoM = '<button class="w3-btn w3-tiny is-Button-CancelarXD-Inverted" onclick = "disable_enable_producto(\'RESPUESTA\', 0, \'' . $idMostrar . '\');">Desactivar</button>';
            } else {
                echo('<td><span class="w3-text-red">Inactivo</span></td>');
                $estadoM = '<button class="w3-btn w3-tiny is-Button-CarritoXD-Inverted" onclick = "disable_enable_producto(\'RESPUESTA\', 1, \'' . $idMostrar . '\');">Activar</button>';
            }
            echo('<td>
                        <img class="m-crud_icons" src="../media/img/ModificarXD Otra.png" onclick="mostrarUpdateFormProducto2(\'' . $idMostrar . '\');">
                    </td>
                    <td>
                       ' . $estadoM . ' 
                    </td>
                </tr>');
        }
        echo('</table>
            </div>
            </div>');
    }

    public function maquetaProductoTablaCrudInventario(array $productos) {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $paginador = $sesion->getEntidad(Session::PAGINADOR);
        $paginador instanceof PaginadorMemoria;
        $pageActual = $paginador->getPaginaActual();
        $totalPages = $paginador->getNumeroPaginas();
        $cantidad = count($productos);
        echo('<div class="container-fluid is-Tamaño-ContainerXD">
                <div class="w3-theme-l4 w3-card-4">
                <div class="w3-round-large w3-xlarge w3-container is-Color28">
                    Obtenidos ' . $cantidad . ' Productos
                    <br> <span class="w3-tag w3-round-medium w3-small is-Color29">Página ' . ($pageActual) . ' de ' . $totalPages . '</span>
                </div>  
                <table class="w3-table-all w3-small w3-responsive">
                    <tr class="w3-light-green">
                        <th><div class="w3-center">ID</div></th>
                        <th><div class="w3-center">NOMBRE</div></th>
                        <th><div class="w3-center">UNIDADES DISPONIBLES</div></th>
                        <th><div class="w3-center">VER INVENTARIOS</div></th>
                        <th><div class="w3-center">NUEVA CANTIDAD</div></th>
                    </tr>');
        foreach ($productos as $pro) {
            $pro instanceof ProductoDTO;
            $nombre = $pro->getNombre();
            $idMostrar = $pro->getIdProducto();
            $idCripted = CriptManager::urlVarEncript($pro->getIdProducto());
            $cantidad = $pro->getCantidad();
            echo('<tr class="w3-hover-light-blue w3-white">
                        <td><center>' . $idMostrar . '</center></td>
                        <td>' . $nombre . '</td>
                        <td><center><span class="w3-tag w3-gray w3-round">' . $cantidad . '</span></center></td>');

            echo('
                <td>
                    <div class="w3-center">
                         <a href="ver_inventarios.php?producto_id=' . $idCripted . '"><button class="btn btn-info btn-sm" id="" onclick=""  data-toggle="tooltip" data-placement="top" title="Ver inventarios realizados">
                            <span class="glyphicon glyphicon-search"></span>
                         </button></a>
                    </div>     
                </td>
                <td>
                    <div class="w3-center">
                        <button class="btn btn-success btn-sm" id="" onclick="mostrarFormNuevoInventario(\'' . $idCripted . '\')"  data-toggle="tooltip" data-placement="top" title="Agregar Inventario">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </div>
                </td>
            ');
            echo('</tr>');
        }
        echo('</table>
            </div>
            </div>');
    }

    public function generarStringReporteA(array $productos, $hojaCss) {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $cuentaAdmin = $sesion->getEntidad(Session::CU_ADMIN_LOGED);
        $cuentaAdmin instanceof CuentaDTO;
        $userAdmin = $sesion->getEntidad(Session::US_ADMIN_LOGED);
        $userAdmin instanceof UsuarioDTO;
        $idUser = utf8_decode($userAdmin->getIdUsuario());
        $nombreAdmin = utf8_decode($cuentaAdmin->getPrimerNombre() . " " . $cuentaAdmin->getPrimerApellido());
        $dater = new DateManager();
        $fecha = $dater->dateSpa1();
        $salida = null;
        $salida = '<style>' . $hojaCss . '</style>';
        $cantidad = count($productos);
        $salida .= ('  
                <div class="is-Head-XD" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <p class="is-PXD" style="text-align: right;">
                    ' . $fecha . '
                    <p class="is-PXD">
                     <center><div class="is-Imgen-Logo-Report"><img src="../media/img/LogoCreaciones.png"></div></center> 
                     <p class="is-PXD">
                        Obtenidos ' . $cantidad . ' Productos<br><br>
                        Reporte solicitado por: ' . $nombreAdmin . ' (' . $idUser . ')
                     </p>     
                </div>
               <table class="is-Tabla-Heidy">
                    <tr class="lol">
                        <th class="is-Tabla-Heidy-Tr">ID</th>
                        <th class="is-Tabla-Heidy-Tr">NOMBRE DEL PRODUCTO</th>
                        <th class="is-Tabla-Heidy-Tr">PRECIO</th>
                        <th class="is-Tabla-Heidy-Tr">ESTADO</th>
                        <th class="is-Tabla-Heidy-Tr">CANTIDAD</th>
                        <th class="is-Tabla-Heidy-Tr">CATEGORIA</th>
                        <th class="is-Tabla-Heidy-Tr">FOTO</th>
                    </tr>');
        $cateDAO = CategoriaDAO::getInstancia();
        $cateDAO instanceof CategoriaDAO;
        foreach ($productos as $pro) {
            $catSearch = new CategoriaDTO();
            $catSearch->setIdCategoria($pro->getCategoriaIdCategoria());
            $cateFinded = $cateDAO->find($catSearch);
            $pro instanceof ProductoDTO;
            $nombre = $pro->getNombre();
            $cant = $pro->getCantidad();
            $idMostrar = $pro->getIdProducto();
            $precio = Validador::formatPesos($pro->getPrecio());
            $estado = $pro->getActivo();
            $categoriaNombre = $cateFinded->getNombre();

            $salida .= '<tr class="lol">
                        <td class="is-Tabla-Heidy-Th">' . $idMostrar . '</td>
                        <td class="is-Tabla-Heidy-Th">' . $nombre . '</td>
                        <td class="is-Tabla-Heidy-Th">' . $precio . '</td>';
            if ($estado) {
                $salida .= '<td class="is-Tabla-Heidy-Th"><center>Activo</center></td>';
            } else {
                $salida .= '<td class="is-Tabla-Heidy-Th"><center>Inactivo</center></td>';
            }
            $salida .= '<td class="is-Tabla-Heidy-Th"><center>' . $cant . '</center></td>';
            $salida .= '<td class="is-Tabla-Heidy-Th">' . $categoriaNombre . '</td>';
            $salida .= '<td class="is-Tabla-Heidy-Th"><img style="width: 50px; height: 50px;" src="' . $this->urlFoto($pro->getFoto()) . '"></td>';

            $salida .= '</tr>';
        }
        $salida .= '</table>';
        return $salida;
    }

    public function maquetarBusquedaAvanzada($idRTA, $method) {
        $proDAO = new ProductoDAO();
        $range = $proDAO->getMaxMinPrice();
        $min = $range["MIN"];
        $max = $range["MAX"];
        $categoriaControl = new CategoriaController();
        ?>
        <div class="w3-modal" id="modal_busqueda">
            <div class="w3-modal-content w3-animate-zoom w3-card-4">
                <header class="container-fluid w3-gray"> 
                    <span onclick="document.getElementById('modal_busqueda').style.display = 'none';" class="w3-button w3-display-topright">&times;</span>
                    <br><br>
                    <center><div class="w3-tag w3-dark-grey w3-round" style="width: 60%;">
                            <span class="is-Title01 w3-center">Busqueda Avanzada</span>
                        </div></center>
                    <br>
                </header>
                <div class="container-fluid w3-white w3-padding-12">
                    <div class="w3-container">
                        <label class="is-Labels-Negro-XD">Según categoría</label>
                        <?php
                        $categoriaControl->mostrarCategoriaSelect(ProductoRequest::pro_id_cat, ProductoRequest::pro_id_cat, null);
                        ?>
                    </div>
                    <div class="w3-container w3-row">
                        <div class="w3-half">
                            <label for="producto_min_price" class="is-Labels-Negro-XD">Precio Mínimo</label>
                            <input style="border: 1px solid #000;" type="number" value="0" id="producto_min_price" name="producto_min_price" readonly="true" class="is-Input-Text-Otro">
                        </div>
                        <div class="w3-half">
                            <label for="producto_max_price" class="is-Labels-Negro-XD">Precio Máximo</label>
                            <input style="border: 1px solid #000;" type="number" value="0" id="producto_max_price" name="producto_max_price" readonly="true" class="is-Input-Text-Otro">
                        </div>
                    </div>
                    <div class="w3-container">
                        <div class="" id="precio_rango"></div>
                    </div>
                    <div class="w3-row w3-container w3-padding-12">
                        <label for="" class="is-Labels-Negro-XD">Nombre o palabra clave</label>
                        <input style="border: 1px solid #000;" type="text" class="is-Input-Text-Otro" name="<?php echo(ProductoRequest::pro_des); ?>" id="<?php echo(ProductoRequest::pro_des); ?>" onblur="valida_simple_input(this)">
                    </div>
                </div>
                <footer class="w3-container w3-gray">
                    <div class="w3-center w3-padding-16">
                        <button class="is-Button-CarritoXD-Inverted" onclick="closeE('modal_busqueda'); productoBusquedaAvanzada('<?php echo($idRTA); ?>', '<?php echo($method); ?>');">Buscar</button>
                        <button class="is-Button-CancelarXD-Inverted" onclick="window.location.reload();">Cancelar</button>
                    </div>
                </footer>
                <script>
                    $(function () {
                        $("#precio_rango").slider({
                            range: true,
                            min: <?php echo($min); ?>,
                            max: <?php echo($max); ?>,
                            values: [<?php echo($min) ?>, <?php echo($max); ?>],
                            step: 50,
                            slide: function (event, ui) {
                                $("#producto_max_price").val(ui.values[ 1 ]);
                                $("#producto_min_price").val(ui.values[ 0 ]);
                            }
                        });
                        $("#producto_max_price").val($("#precio_rango").slider("values", 1));
                        $("#producto_min_price").val($("#precio_rango").slider("values", 0));
                    });
                </script>
            </div>
        </div>
        <?php
    }

}
