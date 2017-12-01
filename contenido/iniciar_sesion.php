<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php
    include_once './includes/ContenidoPagina.php';
    include_once 'cargar_clases.php';
    AutoCarga::init();
    $contenido = ContenidoPagina::getInstancia();
    $contenido instanceof ContenidoPagina;
    $contenido->getHead();
    $sesion = SimpleSession::getInstancia();
    $sesion instanceof SimpleSession;
    $userManager = new UsuarioController();
    ?>
    <body>
        <?php
        $contenido->getHeader();
        $userManager->mostrarManagerLink();
        $contenido->mostrarRespuestaNegocio();
        if (!$sesion->existe(Session::US_LOGED)) {
            ?>
            <section class="is-Fondo-01">
                <?php
                $userManager->mostrarNavbarUsuario();
                ?>
                <div class="w3-container w3-card-8 w3-theme-d4" id="RTA"></div>
                <br><br>
                <center><div class="w3-tag w3-green w3-round" style="width: 60%;">
                        <span class="is-Title01 w3-center">Inicio de Sesión</span>
                    </div></center>
                <br>
                <form method="POST" name="log_in">
                    <div class="w3-row">
                        <div class="w3-quarter w3-container"></div>
                        <div class="w3-half w3-container w3-card-8 w3-padding w3-white w3-center head1" style="border-radius: 20px;">
                            <br>
                            <img class="m-login-logo w3-animate-zoom" src="../media/img/usuario.png">
                            <br><br>

                            <label for="user_id" class="labels">Nombre de Usuario o Correo Electrónico</label>
                            <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="user_id" id="user_id" placeholder="ID user" required onblur="valida_simple_input(this)">
                            <span class="w3-text-red w3-large">*</span>
                            <div><span class="w3-text-red w3-border-red w3-tiny" id="user_id_res"></span></div>

                            <input type="text" name="user_email" hidden id="user_email">

                            <label for="user_id" class="labels">Contraseña</label>
                            <input type="password" style="border:1px solid #000000" class="is-Input-Text-Otro" name="user_password" id="user_passwordA" placeholder="Password" required onkeydown="valida_user_passA()" onblur="valida_user_passA()">
                            <span class="w3-text-red w3-large">*</span>
                            <div><span class="w3-tiny w3-text-red" id="user_passA_res"></span></div>

                            <input type="button" class="is-Button-CarritoXD" onclick="login()" value="Iniciar Sesión">
                            <a href="inicio.php"><button class="is-Button-CancelarXD">Cancelar</button></a>
                            <br><br>
                            <div class="w3-center">
                                <a href="recuperar_contrasena.php" style="text-decoration:none;"><span class="w3-round w3-yellow w3-text-white w3-hover-amber">Olvidé mi contraseña</span></a>
                                <a href="registro_usuarios.php" style="text-decoration:none;"><span class="w3-round w3-green is-hover-Color31">¿No tienes cuenta? Regístrate</span></a>
                            </div>
                            <br><br>
                        </div>
                    </div>
                    <div class="w3-quarter w3-container"></div>
                </form>
                <br><br><br>
            </section>
            <?php
        } else {
            $userManager->mostrarNavbarUsuario();
            $cuentaSession = $sesion->getEntidad(Session::CU_LOGED);
            $cuentaSession instanceof CuentaDTO;

            echo('<br><br><div class="is-LetraColor06-Error">Hola <b>' . $cuentaSession->getPrimerNombre() . '</b>,<br>No puedes ver esta pagina <br> Ya has iniciado Sesión. :*</div><br>'
            . '<img class="m-login-logo w3-animate-zoom" src="../media/img/ErrorPagina.png"><br><br>');
        }
        ?>
        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>
