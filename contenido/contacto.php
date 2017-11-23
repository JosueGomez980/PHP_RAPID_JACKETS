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

    AutoCarga::init();
    
    $sesion = SimpleSession::getInstancia();
    $contenido = ContenidoPagina::getInstancia();
    $contenido->getHead();
    $userManager = new UsuarioController();
    $userMQT = new UsuarioMaquetador();
    ?>
    <body>
        <?php
        $contenido->getHeader();
        ?>
        <section class="m-section">
            <?php
            $userManager->mostrarNavbarUsuario();
            $userMQT->maquetarNothingXD();
            ?>
        </section>
        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>

