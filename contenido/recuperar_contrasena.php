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
$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;

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
            <?php
            $userManager->mostrarNavbarUsuario();
            ?>
            <div id="RTA2"></div>
            <div id="RESPUESTA">
                <div class="w3-row w3-theme-l4">
                    <div class="w3-quarter w3-container"></div>
                    <div class="w3-half w3-card-8 w3-container w3-display-container">
                        <div class="w3-display-topright">
                            <img style="width: 50px; height: 50px;"class="w3-image" src="../media/img/pass_reco.png" alt="Recuperación de contraseña" title="Recuperar Contraseña">
                        </div>
                        <h3 class="w3-center w3-text-brown" style="font-weight: bold">
                            Recupera tu contraseña
                        </h3>
                        <!--<form name="sds" id="sd" action="controlador/controllers/ControlVistas.php" method="get">-->
                        <input type="hidden" value="password_recovery_part_a" name="m">
                        <label class="labels">Digita tu nombre de usuario (nickname)</label>
                        <input type="text" class="input_texto" name="user_id" id="user_id" placeholder="Usuario" required onblur="valida_id_user()">
                        <span class="w3-text-red w3-large">*</span>
                        <div><span class="w3-text-red w3-border-red w3-tiny" id="user_id_res"></span></div>
                        <label for="user_id" class="labels">Correo Electrónico Registrado</label>
                        <input type="email" class="input_texto" name="user_email" id="user_email" placeholder="Email" required onblur="valida_user_email()">
                        <span class="w3-text-red w3-large">*</span>
                        <div><span class="w3-tiny w3-text-red" id="user_email_res"></span></div>
                        <br>
                        <div class="w3-center  w3-padding-large">
                            <button class="w3-btn m-boton-a w3-green" onclick="accountRescuePasoA();">Continuar</button>
                            <button class="w3-btn m-boton-a w3-red" type="reset" onclick="window.location.replace('iniciar_sesion.php')">Cancelar</button>
                        </div>
                        <!--</form>-->
                    </div>
                    <div class="w3-quarter w3-container"></div>
                </div>
            </div>
        </section>
        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>
