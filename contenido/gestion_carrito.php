<?php
include_once 'includes/ContenidoPagina.php';
include_once 'cargar_clases.php';

AutoCarga::init();
$userManager = new UsuarioController();

$carritoManager = new CarritoComprasController();
$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarCarritoInSession();

$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;

$carritoCompras = $sesion->getEntidad(Session::CART_USER);
$carritoCompras instanceof CarritoComprasDTO;
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
    $contenido->getHead();
    ?>
    <body>
        <?php
        $contenido->getHeader();

        // Seccion para mostrar los datos, iconos del usuario que está logeado y el menu 
        ?>
        <section class="m-section">
            <div id="item_carrito"></div>
            <div id="cardUser">
                <?php
                $userManager->mostrarCardUsuario();
                ?>
            </div>
            <?php
            $carritoManager->mostrarCarritoCompleto($carritoCompras);
            ?>
        </section>
        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>
