<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once './includes/ContenidoPagina.php';
include_once 'cargar_clases.php';
AutoCarga::init();
?>
<html>
    <?php
    $contenido = ContenidoPagina::getInstancia();
    $contenido instanceof ContenidoPagina;
    $contenido->getHead();
    $sesion = SimpleSession::getInstancia();
    $sesion instanceof SimpleSession;
    $userManager = new UsuarioController();
    ?>
    <body>
        <section class="m-section">
            <?php
            $contenido->getHeader();
            $userManager->mostrarManagerLink();
            if ($sesion->existe(Session::US_LOGED)) {
                $cuentaSession = $sesion->getEntidad(Session::CU_LOGED);
                $cuentaSession instanceof CuentaDTO;

                echo('<div class="m-tituloA">HOLA <b>' . $cuentaSession->getPrimerNombre() . '</b>, ya has iniciado Sesión.</div>');
                $userManager->mostrarCardUsuario();
            } else {
                ?>
                <div class="m-tituloA">REGISTRESE EN RAPID JACKETS</div>
                <ul class="w3-ul w3-card-8 w3-tiny w3-hoverable w3-border">
                    <li>Los campos con <span class="w3-text-red w3-large">*</span> son OBLIGATORIOS</li>
                    <li>El nombre de usuario debe tener mínimo 8 caracteres, incluyendo al menos 3 números</li>
                    <li>La contraseña debe tener minimo 8 caracteres incluyendo al menos 3 numeros</li>
                    <li>El campo de teléfono sólo debe contener números</li>
                </ul>
                <form method="POST" id="RegistroCuenta">
                    <div class="w3-row">
                        <div class="w3-half w3-container w3-theme-l3">
                            <h3 class="w3-center">Datos de Usuario</h3><hr class="w3-lime">
                            <label for="user_id" class="labels">Nombre de Usuario</label>
                            <input type="text" class="input_texto" name="user_id" id="user_id" placeholder="Nickname" required onblur="valida_id_user()">
                            <span class="w3-text-red w3-large">*</span>
                            <div><span class="w3-text-red w3-border-red w3-tiny" id="user_id_res"></span></div>
                            <br>
                            <label for="user_id" class="labels">Correo Electrónico</label>
                            <input type="email" class="input_texto" name="user_email" id="user_email" placeholder="Email" required onblur="valida_user_email()">
                            <span class="w3-text-red w3-large">*</span>
                            <div><span class="w3-tiny w3-text-red" id="user_email_res"></span></div>
                            <br>
                            <label for="user_id" class="labels">Contraseña</label>
                            <input type="password" class="input_texto" name="user_password" id="user_passwordA" placeholder="Password" required onkeydown="valida_user_passA()" onblur="valida_user_passA()">
                            <span class="w3-text-red w3-large">*</span>
                            <div><span class="w3-tiny w3-text-red" id="user_passA_res"></span></div>
                            <div><span class="w3-tiny" id="user_passA_res2"></span></div>
                            <br>
                            <label for="user_id" class="labels">Repite la contraseña</label>
                            <input type="password" class="input_texto" name="user_passwordB" id="user_passwordB" placeholder="Password" required onblur="valida_user_passB()" onpaste="avoid_paste()">
                            <span class="w3-text-red w3-large">*</span>
                            <div><span class="w3-tiny" id="user_passB_res"></span></div>
                            <br>
                        </div>
                        <div class="w3-half w3-container w3-theme-l2">
                            <h3 class="w3-center">Información Personal</h3><hr class="w3-lime">
                            <label for="cuenta_tip_doc" class="labels">Tipo de Documento</label>
                            <select name="cuenta_tip_doc" id="cuenta_tip_doc" class="m-selects">
                                <option value="CC">CC. Cedula de Ciudadania</option>
                                <option value="TI">TI. Tarjeta de Identidad</option>
                                <option value="CEX">CEX. Cedula de Extranjería</option>
                                <option value="RC">RC. Registro Civil</option>                            
                                <option value="PST">PST. Pasaporte</option>                            
                            </select>
                            <span class="w3-text-red w3-large">*</span>
                            <br>
                            <label for="cuenta_num_doc" class="labels">Número de Documento</label>
                            <input type="text" class="input_texto" name="cuenta_num_doc" id="cuenta_num_doc" placeholder="Numero de Documento" required onblur="valida_simple_input(this)">
                            <span class="w3-text-red w3-large">*</span>

                            <label for="cuenta_prim_name" class="labels">Primer Nombre</label>
                            <input type="text" class="input_texto" name="cuenta_prim_name" id="cuenta_prim_name" placeholder="Primer Nombre" required onblur="valida_simple_input(this)">
                            <span class="w3-text-red w3-large">*</span>

                            <label class="labels">Segundo Nombre</label>
                            <input type="text" class="input_texto" name="cuenta_sec_name" id="cuenta_sec_name" placeholder="Segundo Nombre">
                            <br>
                            <label class="labels">Primer Apellido</label>
                            <input type="text" class="input_texto" name="cuenta_prim_ape" id="cuenta_prim_ape" placeholder="Primer Apellido" required onblur="valida_simple_input(this)">
                            <span class="w3-text-red w3-large">*</span>

                            <label class="labels">Segundo Apellido</label>
                            <input type="text" class="input_texto" name="cuenta_sec_ape" id="cuenta_sec_ape" placeholder="Segundo Apellido">
                            <br>
                            <label class="labels">Teléfono</label>
                            <input type="text" class="input_texto" name="cuenta_tel" id="cuenta_tel" placeholder="Telefono de Contacto" required onblur="valida_simple_input(this)">
                            <span class="w3-text-red w3-large">*</span>

                        </div>
                    </div>
                    <div class="w3-center w3-padding-24">
                        <input type="button" class="w3-btn w3-round-large w3-border-blue w3-theme-l1" value="Registrarme" onclick="insertar_usuario()">
                        <a href="inicio.php"><input type="button" class="w3-btn w3-round-large w3-border-blue w3-theme-l1" value="Cancelar"></a>
                        <input type="reset" class="w3-btn w3-round-large w3-border-blue w3-theme-l1" value="Borrar">
                    </div>
                </form>
                <div class="w3-container w3-card-8 w3-theme-d4" id="insert_res"></div>
                <?php
            }
            ?>
            <div id="loading"></div>
        </section>
        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>
