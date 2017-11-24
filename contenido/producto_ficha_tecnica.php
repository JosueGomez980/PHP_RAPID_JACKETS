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
    $sesion = SimpleSession::getInstancia();
    $sesion instanceof SimpleSession;
    $userEste = new UsuarioController();

    $acceso = AccesoPagina::getInstacia();
    $acceso instanceof AccesoPagina;
    $userManager = new ProductoController();
    if (!isset($_GET[ProductoRequest::pro_id])) {
        $acceso->irPagina(AccesoPagina::INICIO);
    }
    $proDAO = ProductoDAO::getInstancia();
    $proDAO instanceof ProductoDAO;
    $productoRequest = new ProductoRequest();
    $productoGet = $productoRequest->getProductoDTO();
    $productoGet instanceof ProductoDTO;
    $productoGet->setIdProducto(CriptManager::urlVarDecript($productoGet->getIdProducto()));

    $proFinded = $proDAO->find($productoGet);
    ?>
    <body>
        <?php
        $contenido->getHeader();
        ?>
        <div id="CARRITO"></div>
        <section class="is-Fondo-02">
            <?php
            $userEste->mostrarNavbarUsuario();
            ?>
            <br><br>
            <div class="container-fluid is-Tamaño-ContainerXD">
                <?php
                if (!is_null($proFinded)) {
                    $userManager->encontrar($proFinded);
                } else {
                    $msg = new Neutral();
                    $msg->setValor("No se encontrón ningún producto :(");
                    echo($msg->toString($msg->getValor()));
                }
                ?>
            </div>
        </section>

        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>
