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
            $userManager->mostrarNavbarUsuario();
            $userManager->mostrarManagerLink();
            if ($sesion->existe(Session::US_LOGED))
            {
                $cuentaSession = $sesion->getEntidad(Session::CU_LOGED);
                $cuentaSession instanceof CuentaDTO;

                echo('<br><br><div class="is-LetraColor06-Error">Hola <b>' . $cuentaSession->getPrimerNombre() . '</b>,<br>No puedes ver esta pagina <br> Ya has iniciado Sesión. :*</div><br>'
                        . '<img class="m-login-logo w3-animate-zoom" src="../media/img/ErrorPagina.png">');
            }
            else
            {
                ?>
                <br>
                <div class="is-LetraColor05">Crear Cuenta XD</div>
                <br>
                <ul class="w3-ul w3-card-8 w3-tiny w3-hoverable w3-border w3-white">
                    <li class="w3-center">Los campos con <span class="w3-text-red w3-large">*</span> son OBLIGATORIOS</li>
                    <li class="w3-center">El campo de teléfono sólo debe contener números</li>
                </ul>
                <form method="POST" id="RegistroCuenta" class="form-horizontal">
                    <div class="w3-row">
                        <br>
                        <div class="container-fluid is-Color18 is-Tamaño-ContainerXD">
                            <br>
                            <h3 class="w3-center" style="color: #76448a; font-weight:bolder;">Datos de Usuario</h3><hr class="is-Color19">

                            <div class="form-group">
                                <label for="user_id" class="labels col-lg-3 control-label">Nombre de Usuario : </label>
                                <div class="col-lg-8">
                                    <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="user_id" id="user_id" placeholder="Nickname" required onblur="valida_id_user()">
                                    <span class="w3-text-red w3-large">*</span>
                                    <div><span class="w3-text-red w3-border-red w3-tiny" id="user_id_res"></span></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_id" class="labels col-lg-3 control-label">Correo Electrónico : </label>
                                <div class="col-lg-8">
                                    <input type="email" style="border:1px solid #000000" class="is-Input-Text-Otro" name="user_email" id="user_email" placeholder="Email" required onblur="valida_user_email()">
                                    <span class="w3-text-red w3-large">*</span>
                                    <div><span class="w3-tiny w3-text-red" id="user_email_res"></span></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_id" class="labels col-lg-3 control-label">Contraseña : </label>
                                <div class="col-lg-8">
                                    <input type="password" style="border:1px solid #000000" class="is-Input-Text-Otro" name="user_password" id="user_passwordA" placeholder="Password" required onkeydown="valida_user_passA()" onblur="valida_user_passA()">
                                    <span class="w3-text-red w3-large">*</span>
                                    <div><span class="w3-tiny w3-text-red" id="user_passA_res"></span></div>
                                    <div><span class="w3-tiny" id="user_passA_res2"></span></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_id" class="labels col-lg-3 control-label">Repite la contraseña : </label>
                                <div class="col-lg-8">
                                    <input type="password" style="border:1px solid #000000" class="is-Input-Text-Otro" name="user_passwordB" id="user_passwordB" placeholder="Password" required onblur="valida_user_passB()" onpaste="avoid_paste()">
                                    <span class="w3-text-red w3-large">*</span>
                                    <div><span class="w3-tiny" id="user_passB_res"></span></div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <br>
                        <div class="container-fluid is-Color18 is-Tamaño-ContainerXD">
                            <br><h3 class="w3-center" style="color: #76448a; font-weight:bolder;">Información Personal</h3><hr style="background-color: #3333FF"><br>

                            <div class="form-group">
                                <label for="cuenta_tip_doc" class="labels col-lg-3 control-label">Tipo de Documento : </label>
                                <div class="col-lg-8">
                                    <select name="cuenta_tip_doc" id="cuenta_tip_doc" class="is-Selects">
                                        <option value="CC">CC. Cedula de Ciudadania</option>
                                        <option value="TI">TI. Tarjeta de Identidad</option>
                                        <option value="CEX">CEX. Cedula de Extranjería</option>
                                        <option value="RC">RC. Registro Civil</option>                            
                                        <option value="PST">PST. Pasaporte</option>                            
                                    </select>
                                    <span class="w3-text-red w3-large">*</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cuenta_num_doc" class="labels col-lg-3 control-label">Número de Documento : </label>
                                <div class="col-lg-8">
                                    <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_num_doc" id="cuenta_num_doc" placeholder="Numero de Documento" required onblur="valida_simple_input(this)">
                                    <span class="w3-text-red w3-large">*</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cuenta_prim_name" class="labels col-lg-3 control-label">Primer Nombre : </label>
                                <div class="col-lg-8">
                                    <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_prim_name" id="cuenta_prim_name" placeholder="Primer Nombre" required onblur="valida_simple_input(this)">
                                    <span class="w3-text-red w3-large">*</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="labels col-lg-3 control-label">Segundo Nombre : </label>
                                <div class="col-lg-8">
                                    <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_sec_name" id="cuenta_sec_name" placeholder="Segundo Nombre">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="labels col-lg-3 control-label">Primer Apellido : </label>
                                <div class="col-lg-8">
                                    <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_prim_ape" id="cuenta_prim_ape" placeholder="Primer Apellido" required onblur="valida_simple_input(this)">
                                    <span class="w3-text-red w3-large">*</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="labels col-lg-3 control-label">Segundo Apellido : </label>
                                <div class="col-lg-8">
                                    <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_sec_ape" id="cuenta_sec_ape" placeholder="Segundo Apellido">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="labels col-lg-3 control-label">Teléfono : </label>
                                <div class="col-lg-8">
                                    <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_tel" id="cuenta_tel" placeholder="Telefono de Contacto" required onblur="valida_simple_input(this)">
                                    <span class="w3-text-red w3-large">*</span>
                                </div>
                            </div>

                            <div class="w3-center w3-padding-24">
                                <input type="button" class="is-Button-CarritoXD" value="Registrarme" onclick="insertar_usuario()">
                                <a href="inicio.php"><input type="button" class="is-Button-CancelarXD" value="Cancelar"></a>
                                <input type="reset" class="is-Button-BorrarXD" value="Borrar">
                            </div>
                        </div>
                    </div>

                </form>
                <div class="w3-container w3-card-8 w3-theme-d4" id="insert_res"></div>
                <?php
            }
            ?>
            <div id="loading"></div>
            <br><br>
        </section>
        <?php
        $contenido->getFooter();
        ?>
    </body>
</html>
