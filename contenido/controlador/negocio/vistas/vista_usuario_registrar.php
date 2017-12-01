<form method="POST" id="nuevoUsuario" action="controlador/negocio/registrar_nuevo_usuario.php">
    <div class="w3-row" style="background-color: #BDBDBD;">
        <ul class="w3-ul w3-card-8 w3-tiny w3-border w3-white">
            <li class="w3-center">Los campos con <span class="w3-text-red">*</span> son OBLIGATORIOS</li>
            <li class="w3-center">El campo de teléfono sólo debe contener números</li>
        </ul>
        <div class="container-fluid" style="width: 95%; border-radius: 15px; background-color: #797D7F;">
            
            <br>
            <h3 class="w3-center" style="color: #fff; font-weight:bolder;">Datos de Usuario</h3><CENTER><hr style="width: 80%"></CENTER>

            <div class="form-group">
                <label for="user_id" class="is-Labels-XD col-lg-3 control-label">Nombre de Usuario : </label>
                <div class="col-lg-8">
                    <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="user_id" id="user_id" placeholder="Nickname" required onblur="valida_id_user()">
                    <span class="w3-text-red w3-large">*</span>
                    <div><span class="w3-text-red w3-border-red w3-tiny" id="user_id_res"></span></div>
                </div>
            </div>

            <div class="form-group">
                <label for="user_id" class="is-Labels-XD col-lg-3 control-label">Correo Electrónico : </label>
                <div class="col-lg-8">
                    <input type="email" style="border:1px solid #000000" class="is-Input-Text-Otro" name="user_email" id="user_email" placeholder="Email" required onblur="valida_user_email()">
                    <span class="w3-text-red w3-large">*</span>
                    <div><span class="w3-tiny w3-text-red" id="user_email_res"></span></div>
                </div>
            </div>

            <div class="form-group">
                <label for="user_id" class="is-Labels-XD col-lg-3 control-label">Contraseña : </label>
                <div class="col-lg-8">
                    <input type="password" style="border:1px solid #000000" class="is-Input-Text-Otro" name="user_password" id="user_passwordA" placeholder="Password" required onkeydown="valida_user_passA()" onblur="valida_user_passA()">
                    <span class="w3-text-red w3-large">*</span>
                    <div><span class="w3-tiny w3-text-red" id="user_passA_res"></span></div>
                    <div><span class="w3-tiny" id="user_passA_res2"></span></div>
                </div>
            </div>

            <div class="form-group">
                <label for="user_id" class="is-Labels-XD col-lg-3 control-label">Repite la contraseña : </label>
                <div class="col-lg-8">
                    <input type="password" style="border:1px solid #000000" class="is-Input-Text-Otro" name="user_passwordB" id="user_passwordB" placeholder="Password" required onblur="valida_user_passB()" onpaste="avoid_paste()">
                    <span class="w3-text-red w3-large">*</span>
                    <div><span class="w3-tiny" id="user_passB_res"></span></div>
                </div>
            </div>

            <div class="form-group">
                <label for="user_rol" class="is-Labels-XD col-lg-3 control-label">Rol : </label>
                <div class="col-lg-8">
                    <select name="rol_user" id="rol_user" class="is-Selects">
                        <option value="1" selected>Cliente Corriente</option>
                        <option value="2">Cliente Particular</option>
                        <option value="3">Institucion Educativa</option>                          
                        <option value="4">Administrador Secundario</option>                          
                    </select>
                </div>
            </div>
            <br>
        </div>
        <br>
        <div class="container-fluid" style="width: 95%; border-radius: 15px; background-color: #797D7F;">
            <br><h3 class="w3-center" style="color: #fff; font-weight:bolder;">Información Personal</h3><hr style="background-color: #3333FF"><br>

            <div class="form-group">
                <label for="cuenta_tip_doc" class="is-Labels-XD col-lg-3 control-label">Tipo de Documento : </label>
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
                <label for="cuenta_num_doc" class="is-Labels-XD col-lg-3 control-label">Número de Documento : </label>
                <div class="col-lg-8">
                    <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_num_doc" id="cuenta_num_doc" placeholder="Numero de Documento" required onblur="valida_simple_input(this)">
                    <span class="w3-text-red w3-large">*</span>
                </div>
            </div>

            <div class="form-group">
                <label for="cuenta_prim_name" class="is-Labels-XD col-lg-3 control-label">Primer Nombre : </label>
                <div class="col-lg-8">
                    <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_prim_name" id="cuenta_prim_name" placeholder="Primer Nombre" required onblur="valida_simple_input(this)">
                    <span class="w3-text-red w3-large">*</span>
                </div>
            </div>

            <div class="form-group">
                <label class="is-Labels-XD col-lg-3 control-label">Segundo Nombre : </label>
                <div class="col-lg-8">
                    <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_sec_name" id="cuenta_sec_name" placeholder="Segundo Nombre">
                </div>
            </div>

            <div class="form-group">
                <label class="is-Labels-XD col-lg-3 control-label">Primer Apellido : </label>
                <div class="col-lg-8">
                    <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_prim_ape" id="cuenta_prim_ape" placeholder="Primer Apellido" required onblur="valida_simple_input(this)">
                    <span class="w3-text-red w3-large">*</span>
                </div>
            </div>

            <div class="form-group">
                <label class="is-Labels-XD col-lg-3 control-label">Segundo Apellido : </label>
                <div class="col-lg-8">
                    <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_sec_ape" id="cuenta_sec_ape" placeholder="Segundo Apellido">
                </div>
            </div>

            <div class="form-group">
                <label class="is-Labels-XD col-lg-3 control-label">Teléfono : </label>
                <div class="col-lg-8">
                    <input type="text" style="border:1px solid #000000" class="is-Input-Text-Otro" name="cuenta_tel" id="cuenta_tel" placeholder="Telefono de Contacto" required onblur="valida_simple_input(this)">
                    <span class="w3-text-red w3-large">*</span>
                </div>
            </div>

            <div class="w3-center w3-padding-24">
                <input type="submit" class="is-Button-CarritoXD-Inverted" value="Guardar">
                <input type="reset" class="is-Button-BorrarXD-Inverted" value="Borrar">
            </div>
        </div>
        <br>
    </div>
</form>

        <!--
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
            <label for="user_rol" class="labels">Rol del Usuario</label>
            <select name="rol_user" id="rol_user" class="m-selects">
                <option value="1" selected>Cliente Corriente</option>
                <option value="2">Cliente Particular</option>
                <option value="3">Institucion Educativa</option>                          
                <option value="4">Administrador Secundario</option>                          
            </select>
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
        <input type="submit" class="w3-btn w3-round-large w3-border-blue w3-theme-l1" value="Guardar">
        <input type="reset" class="w3-btn w3-round-large w3-border-blue w3-theme-l1" value="Borrar">
    </div>
    -->


