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
    ?>
    <body>
        <?php
        $userManager->mostrarManagerLink();
        $contenido->getHeader();
        ?>
        <section class="m-section">
            <div id="RESPUESTA"></div>
            <div class="w3-row w3-padding-12 w3-theme-l4">
                <div class="w3-quarter w3-container"></div>
                <div class="w3-half w3-center w3-card-8">
                    <h3 class="w3-text-shadow">Recupera tu contraseña</h3>
                </div>
                <div class="w3-quarter w3-container"></div>
            </div>
        </section>
        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>
