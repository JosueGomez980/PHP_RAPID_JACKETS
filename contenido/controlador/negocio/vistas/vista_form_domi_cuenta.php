<?php
$acceso = new AccesoPagina();
$acceso->comprobarSesion(AccesoPagina::INICIO);
$cuentaControl = CuentaController::getInstancia();
$cuentaControl instanceof CuentaController;
$sesion = SimpleSession::getInstancia();
$sesion instanceof SimpleSession;
$cuentaSesion = $sesion->getEntidad(Session::CU_LOGED);
$cuentaSesion instanceof CuentaDTO;
$domiDireccion = "";
$domiTelefono = "";
$domiLocalidad = "";
$domiBarrio = "";
$domiCorrPostal = "";
$domiDTO = $cuentaControl->encontrarDomicilioporCuenta($cuentaSesion);
if (!is_null($domiDTO)) {
    $domiDTO instanceof DomicilioCuentaDTO;
    $domiDireccion = Validador::fixTexto(CriptManager::urlVarDecript($domiDTO->getDireccion()));
    $domiTelefono = Validador::fixTexto(CriptManager::urlVarDecript($domiDTO->getTelefono()));
    $domiLocalidad = Validador::fixTexto($domiDTO->getLocalidad());
    $domiBarrio = Validador::fixTexto(CriptManager::urlVarDecript($domiDTO->getBarrio()));
    $domiCorrPostal = Validador::fixTexto(CriptManager::urlVarDecript($domiDTO->getCorreoPostal()));
}
?>

<form method="POST" id="cambiar_domicilio" action="controlador/controllers/ControlVistas.php?m=gestion_domicilo_usuario">
    <h2 class="w3-center" style="font-weight: bold; font-family:'Comic Sans MS',sans-serif; color: #0033CC;">Cambia tu Domicilio</h2>
    <hr class="w3-green w3-padding-4">
    <div class="w3-center container-fluid w3-white">
        <br><br>
        <label style="color: #012641; -size: medium; font-weight: bolder; display: block;">Direccion: </label>
        <input type="text" value="<?php echo($domiDireccion); ?>" style="border:1px solid #000000; width: 80%;padding: 10px 15px;border-radius: 8px;" name="domi_direccion" id="domi_direccion" placeholder="Direccion" required onblur="valida_simple_input(this)" minlength="10" maxlength="250">
        <span class="w3-text-red w3-large">*</span>
        <br><br>
        <label style="color: #012641; -size: medium; font-weight: bolder; display: block;">Telefono: </label>
        <input type="tel" value="<?php echo($domiTelefono); ?>" minlength="7" maxlength="10" style="border:1px solid #000000; width: 80%;padding: 10px 15px;border-radius: 8px;" name="domi_telefono" id="domi_telefono" placeholder="Telefono" required onblur="valida_simple_input(this)">
        <span class="w3-text-red w3-large">*</span>
        <br><br>
        <label style="color: #012641; -size: medium; font-weight: bolder; display: block;">Localidad: </label>
        <?php
        $cuentaControl->mostrarSelectLocalidades($domiLocalidad); // Se debe para la localidad seleccionada encriptada
        ?>
        <span class="w3-text-red w3-large">*</span>
        <br><br>
        <label style="color: #012641; -size: medium; font-weight: bolder; display: block;">Barrio: </label>
        <input type="text" value="<?php echo($domiBarrio); ?>" style="border:1px solid #000000; width: 80%;padding: 10px 15px;border-radius: 8px;" name="domi_barrio" id="domi_barrio" placeholder="Barrio" required onblur="valida_simple_input(this)">
        <span class="w3-text-red w3-large">*</span>
        <br><br>
        <label style="color: #012641; -size: medium; font-weight: bolder; display: block;">Correo Postal (Opcional) : </label>
        <input type="text" value="<?php echo($domiCorrPostal); ?>" style="border:1px solid #000000; width: 80%;padding: 10px 15px;border-radius: 8px;" name="domi_correo_postal" id="domi_correo_postal" placeholder="Correo Postal" required onblur="valida_simple_input(this)">
        <br><br>
        <input type="hidden" value="OK" name="envio">
        <button type="submit" class="w3-btn" style="background-color: #FFF; border: 1px solid #000; color: #000;padding: 10px 15px;border-radius: 8px;">Aplicar</button>
        <a href="configurar_cuenta.php"><button class="w3-btn"  type="button" style=" background-color: #FFF; border: 1px solid #000; color: #000;padding: 10px 15px;border-radius: 8px;">Cancelar</button></a>
    </div>
</form>

