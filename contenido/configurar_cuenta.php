<?php
include_once 'includes/ContenidoPagina.php';
include_once 'cargar_clases.php';

AutoCarga::init();
$controlAcceso = AccesoPagina::getInstacia();
$controlAcceso instanceof AccesoPagina;
$controlAcceso->comprobarSesion(AccesoPagina::INICIO);

$contenido = ContenidoPagina::getInstancia();
$contenido instanceof ContenidoPagina;

$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
$userManager = new UsuarioController();
$user = $sesion->getEntidad(Session::US_LOGED);
$cuenta = $sesion->getEntidad(Session::CU_LOGED);
$user instanceof UsuarioDTO;
$cuenta instanceof CuentaDTO;
$cuentaControl = CuentaController::getInstancia();
$cuentaControl instanceof CuentaController;
//Obtener los datos que se mostraran en el atributo value de los inputs
$email = Validador::fixTexto($user->getEmail());
$primerNombre = Validador::fixTexto($cuenta->getPrimerNombre());
$segundoNombre = Validador::fixTexto($cuenta->getSegundoNombre());
$primerApellido = Validador::fixTexto($cuenta->getPrimerApellido());
$segundoApellido = Validador::fixTexto($cuenta->getSegundoApellido());
$telefono = $cuenta->getTelefono();
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php
    $contenido->getHead();
    ?>
    <body>
        <?php
        $contenido->getHeader();
        // Seccion para mostrar los datosiconos del usuario que está logeado y el menu , iconos del usuario que está logeado y el menu 
        $contenido->mostrarRespuestaNegocio();
        ?>
        <section class="is-Fondo-01">
            <?php
            $userManager->mostrarNavbarUsuario();
            ?>
            <div class="w3-container w3-card-8 w3-theme-d4" id="RTA"></div>
            <div class="container-fluid is-Tamaño-ContainerXD">
                <div class="w3-container w3-padding-12">
                    <div class="w3-btn-group w3-medium">
                        <br>
                        <button onclick="mostrarOcultarTab('informacion_personal')" class="is-Button-SelectXD">Cambiar Información Personal</button>
                        <button onclick="mostrarOcultarTab('cambio_contrasena')" class="is-Button-SelectXD">Cambiar Contraseña</button>
                        <button onclick="mostrarOcultarTab('cambio_domicilio')" class="is-Button-SelectXD">Cambiar Domicilio</button>
                    </div>

                    <div class="w3-row tab w3-animate-top" id="informacion_personal" style="border-radius: 15px;">
                        <br><br>
                        <form method="POST" name="cambiar_informacion_personal" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                            <center><div class="w3-tag w3-blue-gray w3-round" style="width: 60%;">
                                    <span class="is-Title01 w3-center">Inicio de Sesión</span>
                                </div></center>
                            <br>
                            <div class="col-md-6 container-fluid w3-white" style="border-top-left-radius: 15px;">
                                <br><br>
                                <div class="form-group">
                                    <label class="is-Labels-Negro-XD col-lg-3 control-label">Primer Nombre : </label>
                                    <div class="col-lg-9">
                                        <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_prim_name" id="cuenta_prim_name" required onblur="valida_simple_input(this)" value="<?php echo($primerNombre); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="is-Labels-Negro-XD col-lg-3 control-label">Segundo Nombre : </label>
                                    <div class="col-lg-9">
                                        <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_sec_name" id="cuenta_sec_name" required value="<?php echo($segundoNombre); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="is-Labels-Negro-XD col-lg-3 control-label">Teléfono : </label>
                                    <div class="col-lg-9">
                                        <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_tel" id="cuenta_tel" required onblur="valida_simple_input(this)" value="<?php echo($telefono); ?>">
                                    </div>
                                </div>
                                <br><br><br><br><br><br><br><br>
                            </div>

                            <div class="col-md-6 container-fluid w3-white" style="border-top-right-radius: 15px">
                                <br><br>
                                <div class="form-group">
                                    <label class="is-Labels-Negro-XD col-lg-3 control-label">Primer Apellido : </label>
                                    <div class="col-lg-9">
                                        <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_prim_ape" id="cuenta_prim_ape" required onblur="valida_simple_input(this)" value="<?php echo($primerApellido); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="is-Labels-Negro-XD col-lg-3 control-label">Segundo Apellido : </label>
                                    <div class="col-lg-9">
                                        <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_sec_ape" id="cuenta_sec_ape" required value="<?php echo($segundoApellido); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="is-Labels-Negro-XD col-lg-3 control-label">Email : </label>
                                    <div class="col-lg-9">
                                        <input type="email" style="border:1px solid #000000" class="is-Input-Text-Otro" name="user_email" id="user_email" required onblur="valida_user_email()" value="<?php echo($email); ?>">
                                        <div><span class="w3-tiny w3-text-red" id="user_email_res"></span></div>
                                    </div>
                                </div>
                                <br><br><br><br><br><br><br><br>
                            </div>  
                        </form>
                        <div class="w3-center container-fluid w3-white" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                            <br><br>
                            <input type="submit" value="Aplicar" class="w3-btn is-Button-CarritoXD" onclick="cambiarPersonalData()">
                            <a href="inicio.php"><button class="w3-btn is-Button-CancelarXD">Cancelar</button></a>
                            <br><br>
                        </div> 
                        <br>
                    </div>

                    <div class="w3-row w3-hide tab w3-animate-top" id="cambio_contrasena">
                        <form method="POST" id="cambiar_contrasena">
                            <br><br>
                            <center><div class="w3-tag w3-blue-gray w3-round" style="width: 60%;">
                                    <span class="is-Title01 w3-center">Cambia tu Contraseña</span>
                                </div></center>
                            <br>
                            <div class="w3-center container-fluid w3-white" style="border-radius: 15px;">
                                <br><br>
                                <div class="form-group">
                                    <label for="user_id" class="is-Labels-Negro-XD col-lg-3">Contraseña nueva : </label>
                                    <div class="col-lg-8">
                                        <input type="password" style="border:1px solid #000000" class="is-Input-Text-Otro" name="user_password" id="user_passwordA" placeholder="Password" required onkeydown="valida_user_passA()" onblur="valida_user_passA()">
                                        <span class="w3-text-red w3-large">*</span>
                                        <div><span class="w3-tiny w3-text-red" id="user_passA_res"></span></div>
                                        <div><span class="w3-tiny" id="user_passA_res2"></span></div>
                                    </div>
                                </div>
                                <br><br><br>
                                <div class="form-group">
                                    <label for="user_id" class="is-Labels-Negro-XD col-lg-3">Repite La Nueva Contraseña : </label>
                                    <div class="col-lg-8">
                                        <input type="password" style="border:1px solid #000000" class="is-Input-Text-Otro" name="user_passwordB" id="user_passwordB" placeholder="Password" required onblur="valida_user_passB()" onpaste="avoid_paste()">
                                        <span class="w3-text-red w3-large">*</span>
                                    </div>
                                </div>
                                <div><span class="w3-tiny" id="user_passB_res"></span></div>
                        </form>
                        <br><br><br>
                        <div class="w3-center">
                            <input type="submit" value="Aplicar" class="is-Button-CarritoXD" onclick="cambiarPassword()">
                            <a href="inicio.php"><button class="is-Button-CancelarXD">Cancelar</button></a>
                        </div> 
                        <br>
                    </div>
                    <br><br>
                </div>
                    
                <div class="w3-row w3-hide tab w3-animate-top" id="cambio_domicilio">
                    <?php
                    $cuentaControl->mostrarFormularioDomicilioCuenta();
                    ?>
                </div>
                <!--//---------------------------------------------------------------//-->
                <br><br>
                <div class="w3-container">
                    <button class="w3-button w3-tiny w3-card-2 w3-light-green w3-padding-8" onclick="show_modal('mod_ley_datos')">Ver acerca de la norma de proteccion de datos en este sitio</button>
                </div>
                <br>
                <div class="w3-modal" id="mod_ley_datos">
                    <div class="w3-modal-content w3-animate-zoom">
                        <span class=" w3-button w3-display-topright w3-hover-red" onclick="closeE('mod_ley_datos')">&times;</span>
                        <div class="w3-row w3-white">
                            <h3 class="w3-text-theme w3-center">Política de Seguridad y Confidencialidad</h3>
                            <?php
                            require_once 'controlador/negocio/vistas/politic_datos.php';
                            ?>
                        </div>
                        <div class="w3-container w3-center">
                            <button class=" w3-btn w3-round-large w3-white w3-hover-red w3-border w3-border-red" onclick="closeE('mod_ley_datos')">Aceptar</button>
                        </div>
                    </div>
                </div>

            </div>   
        </div>
    </section>
    <?php
    $contenido->getFooter();
    ?>
</body>
</html>
