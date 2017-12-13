
<form name="form_acc_recovery_change_password" method="POST" id="form_acc_recovery_change_password" action="controlador/controllers/ControlVistas.php">
    <input type="hidden" name="m" value="password_recovery_part_final"> 
    <input type="hidden" name="user_id" value="#ID#"> 
    <div id="RESPUESTA" class="w3-animate-top">
        <div class="w3-row w3-theme-l4">
            <div class="w3-quarter w3-container"></div>
            <div class="w3-half w3-card-8 w3-container w3-display-container">
                <div class="w3-display-topright">
                    <img style="width: 50px; height: 50px;"class="w3-image" src="../media/img/pass_reco.png" alt="Recuperación de contraseña" title="Recuperar Contraseña">
                </div>
                <h3 class="w3-center w3-text-blue-grey w3-text-shadow" style="font-weight: bold">
                    Bueno, ahora debes cambiar tu contraseña
                </h3>
                <br>
                <label for="user_id" class="labels">Escribe una nueva contraseña</label>
                <input type="password" class="input_texto" name="user_password" id="user_passwordA" placeholder="Password" required onkeydown="valida_user_passA()" onblur="valida_user_passA()">
                <span class="w3-text-red w3-large">*</span>
                <div><span class="w3-tiny w3-text-red" id="user_passA_res"></span></div>
                <div><span class="w3-tiny" id="user_passA_res2"></span></div>
                <br>
                <label for="user_id" class="labels">Repite la nueva contraseña</label>
                <input type="password" class="input_texto" name="user_passwordB" id="user_passwordB" placeholder="Password" required onblur="valida_user_passB()" onpaste="avoid_paste()">
                <span class="w3-text-red w3-large">*</span>
                <div><span class="w3-tiny" id="user_passB_res"></span></div>
                <div class="w3-center  w3-padding-large">
                    <button class="w3-btn m-boton-a w3-green" type="submit">Cambiar Contraseña</button>
                    <button class="w3-btn m-boton-a w3-red" type="reset" onclick="window.location.replace('iniciar_sesion.php')">Cancelar</button>
                </div>
            </div>
            <div class="w3-quarter w3-container"></div>
        </div>
    </div>
</form>