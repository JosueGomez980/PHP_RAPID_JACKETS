<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once 'includes/ContenidoPagina.php';
include_once 'cargar_clases.php';

AutoCarga::init();
?>
<html>
    <?php
    $contenido = ContenidoPagina::getInstancia();
    $contenido->getHead();
    $userManager = new UsuarioController();
    $userMQT = new UsuarioMaquetador();
    ?>
    <body>
        <?php
        $userManager->mostrarManagerLink();
        $contenido->getHeader();
        ?>
        <section class="is-Fondo-02">
            <?php
            $userManager->mostrarManagerLink();
            $userManager->mostrarNavbarUsuario();
            $userMQT->maquetarNothingXD();
            ?>
        </section>
        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>
