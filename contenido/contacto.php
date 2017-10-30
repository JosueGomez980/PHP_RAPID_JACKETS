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
    ?>
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
            <div id="cardUser">
                <?php
                $userManager->mostrarCardUsuario();
                ?>
            </div>
        </section>
        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>

