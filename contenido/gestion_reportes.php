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
$userMGN = new UsuarioController();
$categoriaManager = new CategoriaController();
$productoMAQ = new ProductoMaquetador();
$productoDAO = ProductoDAO::getInstancia();
$productoDAO instanceof ProductoDAO;
$userDAO = UsuarioDAO::getInstancia();
$userDAO instanceof UsuarioDAO;
$userMQT = new UsuarioMaquetador();
$fullTablaUsuarios = $userDAO->findAll();
$numUsers = count($fullTablaUsuarios);
$categoriaDAO = CategoriaDAO::getInstancia();
$categoriaDAO instanceof CategoriaDAO;
$catMQR = new CategoriaMaquetador();


$inventarioManager = new InventarioController();
$inventarioDAO = InventarioDAO::getInstancia();
$inventarioDAO instanceof InventarioDAO;
$invMQR = new InventarioMaquetador();
$proMQT = new ProductoMaquetador();
$dater = new DateManager();

$tablaProductos = $productoDAO->findAll();
$tablaUsuarios = $userDAO->findAll();
$tablaCategorias = $categoriaDAO->findAll();
$tablaInventarios = $inventarioDAO->findAll();

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
        <div class="w3-container w3-card-8 w3-theme-d4" id="RTA"></div>
        <?php
        $contenido->getHeader2();
        $contenido->mostrarRespuestaNegocio();
        ?>
        <section class="is-Fondo-03">
            <?php
            $userMGN->mostrarNavAdminUsuario();
            ?>
            <div class="container-fluid is-Tamaño-ContainerXD w3-center">
                <br><br>
                <div class="container-fluid is-Tamaño-ContainerXD w3-white" style="border-radius: 20px;">
                    <br><br>
                    <input type="checkbox" id="EsteXDXD1"></input>
                    <label for="EsteXDXD1">Reportes de Producto</label>

                    <div class="EsteXDXD">
                        <div class="container-fluid w3-center" style="width: 80%;">
                            <div class="w3-btn-group w3-medium">
                                <br>
                                <button onclick="mostrarOcultarTab('reportes_Todo')" class="is-Button-SelectXD">Reporte de Todo</button>
                                <button onclick="mostrarOcultarTab('reportes_Cat')" class="is-Button-SelectXD">Reporte por Categorias</button>
                            </div>
                            <div id="reportes_Todo" class="w3-row tab w3-animate-top w3-center">
                                <br>
                                <div class="container-fluid w3-dark-gray w3-center" style="width: 70%; border-radius: 20px;">
                                    <br>
                                    <form method="GET" name="pdf" action="gestion_reportes.php">
                                        <input type="hidden" value="A" name="report">
                                        <input type="submit" class="is-Button-CarritoXD-Inverted" value="Imprimir Todo">
                                    </form>
                                    <br>
                                </div>
                                <br>
                            </div>

                            <div id="reportes_Cat" class="w3-row w3-hide tab w3-animate-top w3-center">
                                <br>
                                <div class="container-fluid w3-dark-gray w3-center" style="width: 70%; border-radius: 20px;">
                                    <br>
                                    <form method="GET" name="pdf" action="gestion_reportes.php">
                                        <input type="hidden" value="B" name="report">
                                        <?php
                                        $categoriaManager->mostrarCategoriaSelect("idCat", "idCat", null);
                                        ?>
                                        <input type="submit" class="is-Button-CarritoXD-Inverted" value="Imprimir por categoria">
                                    </form>
                                    <br>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>

                    <br>

                    <input type="checkbox" id="EsteXDXDXD1"></input>
                    <label for="EsteXDXDXD1">Reportes de Usuario</label>

                    <div class="EsteXDXDXD">
                        <br>
                        <div class="container-fluid w3-dark-gray w3-center" style="width: 70%; border-radius: 20px;">
                            <br>
                            <form method="GET" name="pdf" action="gestion_reportes.php">
                                <input type="hidden" value="C" name="report">
                                <input type="submit" class="is-Button-CarritoXD-Inverted" value="Imprimir Todo">
                            </form>
                            <br>
                        </div>
                        <br>
                    </div>

                    <br>

                    <input type="checkbox" id="EsteXD1"></input>
                    <label for="EsteXD1">Reportes de Categoria</label>

                    <div class="EsteXD">
                        <br>
                        <div class="container-fluid w3-dark-gray w3-center" style="width: 70%; border-radius: 20px;">
                            <br>
                            <form method="GET" name="pdf" action="gestion_reportes.php">
                                <input type="hidden" value="D" name="report">
                                <input type="submit" class="is-Button-CarritoXD-Inverted" value="Imprimir Todo">
                            </form>
                            <br>
                        </div>
                        <br>
                    </div>

                    <br>

                    <input type="checkbox" id="FierroteXDXD1"></input>
                    <label for="FierroteXDXD1">Reportes de Inventario</label>

                    <div class="FierroteXDXD">
                        <!--<br>
                        <div class="w3-btn-group w3-medium">
                            <br>
                            <button onclick="mostrarOcultarTab('reportes_Todo_Inv')" class="is-Button-SelectXD">Reporte de Todo</button>
                            <button onclick="mostrarOcultarTab('reportes_Inv')" class="is-Button-SelectXD">Reporte por Categorias</button>
                        </div>
                        <div id="reportes_Todo_Inv" class="w3-row tab w3-animate-top w3-center">
                            <br>
                            <div class="container-fluid w3-dark-gray w3-center" style="width: 70%; border-radius: 20px;">
                                <br>
                                <form method="GET" name="pdf" action="gestion_reportes.php">
                                    <input type="hidden" value="F" name="report">
                                    <input type="submit" class="is-Button-CarritoXD-Inverted" value="Imprimir Todo">
                                </form>
                                <br>
                            </div>
                            <br>
                        </div>
                        <div id="reportes_Inv" class="w3-row tab w3-animate-top w3-center w3-hide">-->
                            <br>
                            <div class="container-fluid w3-dark-gray w3-center" style="width: 70%; border-radius: 20px;">
                                <br>
                                <form method="GET" name="pdf" action="gestion_reportes.php">
                                    <input type="hidden" value="E" name="report">
                                    <?php
                                    $userManager->mostrarProductoSelect("idPro", "idPro", null);
                                    ?>
                                    <input type="submit" class="is-Button-CarritoXD-Inverted" value="Imprimir por Registro de Inventario">
                                </form>
                                <br>
                            </div>
                            <br>
                    </div>


                    <br><br>

                </div>
                <br><br>
            </div>
        </section>
        <?php
        $contenido->getFooter2();
        ?>
    </body>
</html>
<?php
if (isset($_GET['report'])) {
    $nombreReport = "";
    $hojaEstilos = null;
    $hojaEstilos = file_get_contents("../css/cssIsseiXD.css");
    include 'dompdf/dompdf_config.inc.php';
    $ok = TRUE;
    $contenido = null;
    switch ($_GET['report']) {
        case "A": {
                $tablaProductos = $productoDAO->findAll();
                $contenido = $productoMAQ->generarStringReporteA($tablaProductos, $hojaEstilos);
                $nombreReport = "reporte_productos_todos_";
                break;
            }
        case "B": {
                $idcat = $_GET["idCat"];
                $idCat = CriptManager::urlVarDecript($idcat);
                $proF = new ProductoDTO();
                $proF->setCategoriaIdCategoria($idCat);
                $tablaProductos = $productoDAO->findByCategoria($proF);
                if (!is_null($tablaProductos)) {
                    $contenido = $productoMAQ->generarStringReporteA($tablaProductos, $hojaEstilos);
                    $nombreReport = "reporte_productos_cat_" . $idCat;
                } else {
                    $ok = FALSE;
                    $modal = new ModalSimple();
                    $neutro = new Neutral();
                    $neutro->setValor("No se hallaron productos que esté asociados a esa categoría");
                    $modal->addElemento($neutro);
                    $closeBtn = new CloseBtn();
                    $closeBtn->setValor("Aceptar");
                    $modal->addElemento($closeBtn);
                    $sesion->add(Session::NEGOCIO_RTA, $modal);
                }
                break;
            }
        case "C": {
                $tablaUsuarios = $userDAO->findAll();
                $contenido = $userMQT->generarStringReporteA($tablaUsuarios, $hojaEstilos);
                $nombreReport = "reporte_usuario_todos_";
                break;
            }

        case "D": {
                $tablaCategorias = $categoriaDAO->findAll();
                $contenido = $catMQR->generarStringReporteA($tablaCategorias, $hojaEstilos);
                $nombreReport = "reporte_categorias_todos_";
                break;
            }

        case "E": {
                $idpro = $_GET["idPro"];
                $idPro = CriptManager::urlVarDecript($idpro);
                $invF = new InventarioDTO();
                $invF->setProductoIdProducto($idPro);
                $invProPro = $invF->getProductoIdProducto();
                $proS = new ProductoDTO();
                $proS->setIdProducto($invProPro);
                $proF = $productoDAO->find($proS);
                $tablaInventarios = $inventarioDAO->findByProducto($invF);
                if (!is_null($tablaInventarios)) {
                    $contenido = $invMQR->generarStringReporteA($tablaInventarios, $hojaEstilos, $invProPro);
                    $nombreReport = "reporte_inventarios_" . $proF->getNombre() . "_";
                } else {
                    $ok = FALSE;
                    $modal = new ModalSimple();
                    $neutro = new Neutral();
                    $neutro->setValor("No se hallaron Registros que esten asociados a este producto");
                    $modal->addElemento($neutro);
                    $closeBtn = new CloseBtn();
                    $closeBtn->setValor("Aceptar");
                    $modal->addElemento($closeBtn);
                    $sesion->add(Session::NEGOCIO_RTA, $modal);
                }
                break;
            }
        /*   
        case "F": {
                $tablaInventarios = $inventarioDAO->findAll();
                $contenido = $invMQR->generarStringReporteB($tablaInventarios, $hojaEstilos);
                $nombreReport = "reporte_inventarios_todos_";
                break;
            }
         * 
         */
    }
    if ($ok) {
        $nameOfFile = $nombreReport . $dater->formatNowDate(DateManager::FOR_PDF_NAME);
        $contenido = utf8_decode($contenido);
        $pdf = new DOMPDF();
        $pdf->load_html($contenido);
        $pdf->render();
        $doc = $pdf->output();
        $pdf->stream($nameOfFile . ".pdf");
    }
}