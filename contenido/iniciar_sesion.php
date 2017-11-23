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
            <section class="m-section">
                <?php
                $userManager->mostrarNavbarUsuario();
                ?>
                <div class="w3-container w3-card-8 w3-theme-d4" id="RTA"></div>
                <div class="m-tituloA">INICIO DE SESIÓN</div>
                <form  name="log_in" method="post" id="login_form" onsubmit="return false;">
                    <div class="w3-row">
                        <div class="w3-quarter w3-container"></div>
                        <div class="w3-half w3-container w3-card-8 w3-padding w3-theme-l3 w3-center">
                            <img class="m-login-logo w3-animate-zoom" src="../media/img/icons_users/man-user.png">

                            <label for="user_id" class="labels">Nombre de Usuario o Correo Electrónico</label>
                            <input type="text" class="input_texto" name="user_id" id="user_id" placeholder="ID user" required onblur="valida_simple_input(this)">
                            <span class="w3-text-red w3-large">*</span>
                            <div><span class="w3-text-red w3-border-red w3-tiny" id="user_id_res"></span></div>

                            <input type="text" name="user_email" hidden id="user_email">

                            <label for="user_id" class="labels">Contraseña</label>
                            <input type="password" class="input_texto" name="user_password" id="user_passwordA" placeholder="Password" required onkeydown="valida_user_passA()" onblur="valida_user_passA()">
                            <span class="w3-text-red w3-large">*</span>
                            <div><span class="w3-tiny w3-text-red" id="user_passA_res"></span></div>

                            <input type="button" class="m-boton-a" onclick="login()" value="Iniciar Sesión">
                            <a href="inicio.php"><button class="m-boton-a">Cancelar</button></a>
                            <br><br>
                            <div class="w3-center">
                                <a href="recuperar_contrasena.php"><span class="w3-tag w3-yellow">Olvidé mi contraseña</span></a>
                                <a href="registro_usuarios.php"><span class="w3-tag w3-green">¿No tienes cuenta? Regístrate</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="w3-quarter w3-container"></div>
                </form>
                <br><br>
            </section>
            <?php
        } else {
            $cuentaSession = $sesion->getEntidad(Session::CU_LOGED);
            $cuentaSession instanceof CuentaDTO;

            echo('<div class="m-tituloA">HOLA <b>' . $cuentaSession->getPrimerNombre() . '</b>, ya has iniciado Sesión.</div>');
            $userManager->mostrarCardUsuario();
        }
        ?>

        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>
