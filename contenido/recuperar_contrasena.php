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
        <section class="is-Fondo-02">
            <?php
            $userManager->mostrarNavbarUsuario();
            ?>
            <div id="RTA2"></div>
            <div id="RESPUESTA">
                <div class="w3-quarter w3-container"></div>
                <br><br>
                <center><div class="w3-tag w3-yellow w3-round" style="width: 60%;">
                        <span class="is-Title01 w3-center">Recupera tu Contraseña</span>
                    </div></center>
                <br>
                <div class="container-fluid w3-white" style="width: 50%; border-radius: 20px;">
                    <div class="container-fluid" style="width: 80%;">
                        <br><br>
                        <!--<form name="sds" id="sd" action="controlador/controllers/ControlVistas.php" method="get">-->
                        <input type="hidden" value="password_recovery_part_a" name="m">
                        <center><label class="is-Labels-Negro-XD">Digita tu nombre de usuario (nickname) :</label>
                        <input type="text" style="border: 1px solid #000" class="input_texto" name="user_id" id="user_id" placeholder="Usuario" required onblur="valida_id_user()">
                        <span class="w3-text-red w3-large">*</span>
                        <div><span class="w3-text-red w3-border-red w3-tiny" id="user_id_res"></span></div>
                        <label for="user_id" class="is-Labels-Negro-XD">Correo Electrónico Registrado :</label>
                        <input type="email" style="border: 1px solid #000" class="input_texto" name="user_email" id="user_email" placeholder="Email" required onblur="valida_user_email()">
                        <span class="w3-text-red w3-large">*</span></center>
                        <div><span class="w3-tiny w3-text-red" id="user_email_res"></span></div>
                        <div class="w3-center  w3-padding-large">
                            <button class="is-Button-CarritoXD" onclick="accountRescuePasoA();">Continuar</button>
                            <button class="is-Button-CancelarXD" type="reset" onclick="window.location.replace('iniciar_sesion.php')">Cancelar</button>
                        </div><br><br>
                        <!--</form>-->
                    </div>
                    <div class="w3-quarter w3-container"></div>
                </div>
            </div>
            <br><br><br>
        </section>
        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>
