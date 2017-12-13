<?php
include_once 'cargar_clases.php';
AutoCarga::init();

$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
//Validar que  en sesion exista una cuentaRescue y que se hayan enviado por url los parametros
$acceso->comprobarUserInAccountRecovery(AccesoPagina::INICIO);
$acceso->validaEnviode("token", AccesoPagina::INICIO);
$acceso->validaEnviode("user_id", AccesoPagina::INICIO);

$userControl = UsuarioController::getInstancia();
$userControl instanceof UsuarioController;
$cuentaRescueGet = new CuentaRescueDTO();
$userIdValue = (filter_input(INPUT_GET, UsuarioRequest::us_id));
$cuentaRescueGet->setToken((filter_input(INPUT_GET, "token")));
$cuentaRescueGet->setUsuarioIdUsuario(base64_decode(filter_input(INPUT_GET, UsuarioRequest::us_id)));
$userControl->validarLinkAccountRecovery($cuentaRescueGet);
?>
<!DOCTYPE html>

<html>
    <?php
    $contenido = ContenidoPagina::getInstancia();
    $contenido instanceof ContenidoPagina;
    $contenido->getHead();
    $userManager = new UsuarioController();
    ?>
    <body>
        <?php
        $contenido->getHeader();
        $contenido->mostrarRespuestaNegocio();
        ?>
        <section class="m-section">
            <div id="RTA_NEGOCIO"></div>
            <div id="RESPUESTA">
                <div class="w3-row w3-theme-l1">
                    <div class="w3-quarter w3-container"></div>
                    <div class="w3-half w3-card-8 w3-container w3-display-container w3-white">
                        <div class="w3-display-topright">
                            <img style="width: 50px; height: 50px;" class="w3-image" src="../media/img/pass_reco.png" alt="Recuperación de contraseña" title="Recuperar Contraseña">
                        </div>
                        <h3 class="w3-center w3-text-blue-grey w3-text-shadow" style="font-weight: bold">
                            Por favor, introduce el cógido que fue enviado a tu correo.
                        </h3>
                        <br>
                        <label for="codigo" class="labels">El código tiene 10 caracteres.</label>
                        <input type="text" class="input_texto" name="codigo" id="codigo" placeholder="Código" minlength="10" maxlength="10" required onblur="valida_simple_input2(this, 10, 10);">
                        <input type="hidden" value="<?php echo($userIdValue); ?>" name="<?php echo(UsuarioRequest::us_id); ?>" id="<?php echo(UsuarioRequest::us_id); ?>">
                        <br>
                        <div class="w3-center">
                            <button class="w3-btn m-boton-a w3-green" onclick="accountRescuePasoB();">Continuar</button>
                        </div>
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
