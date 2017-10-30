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
        <section class="m-section">


            <div class="w3-row">
                <div class="w3-quarter w3-container"></div>
                <div class="w3-half">
                    <div class="w3-container w3-card-8 w3-theme-d4" id="RTA"></div>
                    <a href="gestion_productos_crud.php?report=A"><button class="w3-btn w3-green w3-large w3-round-medium">Imprimir Todo</button></a>
                    <hr class="w3-lime w3-padding-4">
                    <form method="GET" name="pdf" action="gestion_productos_crud.php">
                        <input type="hidden" value="B" name="report">
                        <?php
                        $categoriaManager->mostrarCategoriaSelect("idCat", "idCat", null);
                        ?>
                        <input type="submit" class="w3-btn w3-green w3-large w3-round-medium" value="Imprimir por categoria">
                    </form>
                    <hr class="w3-lime w3-padding-4">
                </div>
                <div class="w3-quarter w3-container"></div>
            </div>
            <div id="RESPUESTA"></div>

            <?php
            $paginador->maquetarBarraPaginacion();
            ?>
            <div id="TABLA_CRUD">
                <?php
                $userManager->mostrarCrudTable($tablaUsuariosPaginada);
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
<?php
if (isset($_GET['report'])) {
    $hojaEstilos = null;
    $hojaEstilos = file_get_contents("../css/print.css");
    include 'dompdf/dompdf_config.inc.php';
    $ok = TRUE;
    $contenido = null;
    switch ($_GET['report']) {
        case "A": {
                $tablaInventarios = $productoDAO->findAll();
                $contenido = $productoMAQ->generarStringReporteA($tablaInventarios, $hojaEstilos);
                break;
            }
        case "B": {
                $idcat = $_GET["idCat"];
                $idCat = CriptManager::urlVarDecript($idcat);
                $proF = new ProductoDTO();
                $proF->setCategoriaIdCategoria($idCat);
                $tablaInventarios = $productoDAO->findByCategoria($proF);
                if (!is_null($tablaInventarios)) {
                    $contenido = $productoMAQ->generarStringReporteA($tablaInventarios, $hojaEstilos);
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
    }
    if ($ok) {
        $nameOfFile = "reporte_productos_" . $dater->formatNowDate(DateManager::FOR_PDF_NAME);
        $contenido = utf8_decode($contenido);
        $pdf = new DOMPDF();
        $pdf->load_html($contenido);
        $pdf->render();
        $doc = $pdf->output();
        $pdf->stream($nameOfFile . ".pdf");
    }
}

