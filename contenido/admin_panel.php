<?php
include_once 'includes/ContenidoPagina.php';
include_once 'cargar_clases.php';

AutoCarga::init();
$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);
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
    $contenido instanceof ContenidoPagina;
    $contenido->getHead2();
    ?>
    <body>
        <?php
        $contenido->getHeader2();
        $userManager = new UsuarioController();
        ?>
        <section class="is-Fondo-03">
            <?php
            $userManager->mostrarNavAdminUsuario();
            $sesion = SimpleSession::getInstancia();
            $sesion instanceof SimpleSession;
            $cuentaSession = $sesion->getEntidad(Session::CU_LOGED);
            $cuentaSession instanceof CuentaDTO;
            if ($sesion->existe(Session::US_ADMIN_LOGED)) {
                echo '<br><br>
                <div class="container-fluid w3-white is-Tamaño-ContainerXD">
                    <br><br>
                    <div class="w3-center">
                        <span class="is-Tamaño-Letra09"> 
                            <span class="glyphicon glyphicon-yen"></span>
                             Bienvenido ' . $cuentaSession->getPrimerNombre() . ' 
                            <span class="glyphicon glyphicon-ice-lolly-tasted"></span>
                        </span>
                        <br>
                        <img class="m-login-logo w3-animate-zoom" src="../media/img/AdminXD.png">
                    <br><br>
                </div>
                <br><br>
                </div>';
            }else if($sesion->existe(Session::US_SUB_ADMIN_LOGED)) {
                echo '<br><br>
                <div class="container-fluid w3-white is-Tamaño-ContainerXD">
                    <br><br>
                    <div class="w3-center">
                        <span class="is-Tamaño-Letra09"> 
                            <span class="glyphicon glyphicon-yen"></span>
                             Bienvenido ' . $cuentaSession->getPrimerNombre() . ' 
                            <span class="glyphicon glyphicon-ice-lolly-tasted"></span>
                        </span>
                        <br>
                        <img class="m-login-logo w3-animate-zoom" src="../media/img/AdminSec.png">
                    <br><br>
                </div>
                <br><br>
                </div>';
            }
            ?>
            <br><br><br>
        </section>
        <?php
        $contenido->getFooter2();
        ?>
    </body>
</html>

