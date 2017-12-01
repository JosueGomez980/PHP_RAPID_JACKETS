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
    $domiDireccion = CriptManager::urlVarDecript($domiDTO->getDireccion());
    $domiTelefono = CriptManager::urlVarDecript($domiDTO->getTelefono());
    $domiLocalidad = ($domiDTO->getLocalidad());
    $domiBarrio = CriptManager::urlVarDecript($domiDTO->getBarrio());
    $domiCorrPostal = CriptManager::urlVarDecript($domiDTO->getCorreoPostal());
}
?>
<br><br>
<form method="POST" id="cambiar_domicilio" action="controlador/controllers/ControlVistas.php?m=gestion_domicilo_usuario">
    <center><div class="w3-tag w3-blue-gray w3-round" style="width: 60%;">
            <span class="is-Title01 w3-center">Cambia tu Domicilio</span>
        </div></center>
    <br>
    <div class="w3-center container-fluid w3-white" style="border-radius: 20px;">
        <br><br>
        <div class="container-fluid is-Tamaño-ContainerXD">
            <div class="form-group">
                <label class="labels col-lg-3 control-label">Direccion: </label>
                <div class="col-lg-8">
                    <input type="text" value="<?php echo($domiDireccion); ?>" style="border:1px solid #000000; width: 80%;padding: 10px 15px;border-radius: 8px;" name="domi_direccion" id="domi_direccion" placeholder="Direccion" required onblur="valida_simple_input(this)" minlength="10" maxlength="250">
                    <span class="w3-text-red w3-large">*</span>
                </div>
            </div>
            <br><br>
            <div class="form-group">
                <label class="labels col-lg-3 control-label">Telefono: </label>
                <div class="col-lg-8">
                    <input type="tel" value="<?php echo($domiTelefono); ?>" minlength="7" maxlength="10" style="border:1px solid #000000; width: 80%;padding: 10px 15px;border-radius: 8px;" name="domi_telefono" id="domi_telefono" placeholder="Telefono" required onblur="valida_simple_input(this)">
                    <span class="w3-text-red w3-large">*</span>
                </div>
            </div>
            <br><br>
            <div class="form-group">
                <label class="labels col-lg-3 control-label">Localidad: </label>
                <div class="col-lg-8">
                    <?php
                    $cuentaControl->mostrarSelectLocalidades($domiLocalidad); // Se debe para la localidad seleccionada encriptada
                    ?>
                    <span class="w3-text-red w3-large">*</span>
                </div>
            </div>
            <br><br>
            <div class="form-group">
                <label class="is-Labels-Negro-XD col-lg-3 control-label">Barrio: </label>
                <div class="col-lg-8">
                    <input type="text" value="<?php echo($domiBarrio); ?>" style="border:1px solid #000000; width: 80%;padding: 10px 15px;border-radius: 8px;" name="domi_barrio" id="domi_barrio" placeholder="Barrio" required onblur="valida_simple_input(this)">
                    <span class="w3-text-red w3-large">*</span>
                </div>
            </div>
            <br><br>
            <div class="form-group">
                <label class="is-Labels-Negro-XD col-lg-3 control-label">Correo Postal (Opcional) : </label>
                <div class="col-lg-8">
                    <input type="text" value="<?php echo($domiCorrPostal); ?>" style="border:1px solid #000000; width: 80%;padding: 10px 15px;border-radius: 8px;" name="domi_correo_postal" id="domi_correo_postal" placeholder="Correo Postal" onblur="valida_simple_input(this)">
                </div>
            </div>
            <br><br><br>
            <input type="hidden" value="OK" name="envio">
            <button type="submit" class="is-Button-CarritoXD">Aplicar</button>
            <a href="configurar_cuenta.php"><button class="is-Button-CancelarXD"  type="button">Cancelar</button></a>
        </div>
        <br>
    </div>
</form>

