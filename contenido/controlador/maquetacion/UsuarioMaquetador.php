<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioMaquetador
 *
 * @author SOPORTE
 */
class UsuarioMaquetador implements GenericMaquetador {

//Metodo para formatear el rol a frase entendible
    private function formatRolUser($rol) {
        $rolString = "";
        switch ($rol) {
            case UsuarioDAO::ROL_USER:
                $rolString = "Cliente Corriente";
                break;
            case UsuarioDAO::ROL_COLEGIO:
                $rolString = "Institucion Educativa";
                break;
            case UsuarioDAO::ROL_PARTICULAR:
                $rolString = "Cliente Particular";
                break;
            case UsuarioDAO::ROL_SUB_ADMIN:
                $rolString = "Administrador (Secundario)";
                break;
            case UsuarioDAO::ROL_MAIN_ADMIN:
                $rolString = "ADMINISTRADOR PRINCIPAL";
                break;
        }
        return $rolString;
    }

    private function formatRolToInt($rolPre) {
        $rol = 0;
        switch ($rolPre) {

            case UsuarioDAO::ROL_USER:
                $rol = 1;
                break;
            case UsuarioDAO::ROL_COLEGIO:
                $rol = 3;
                break;
            case UsuarioDAO::ROL_PARTICULAR:
                $rol = 2;
                break;
            case UsuarioDAO::ROL_SUB_ADMIN:
                $rol = 4;
                break;
            case UsuarioDAO::ROL_MAIN_ADMIN:
                $rol = 5;
                break;
        }
        return $rol;
    }

    public function maquetaArrayObject(array $entidades) {
        echo("");
    }

    public function maquetaObject(EntityDTO $entidad) {
        $entidad instanceof UsuarioDTO;
        $id = $entidad->getIdUsuario();
        $rol = $entidad->getRol();
        $estado = $entidad->getEstado();
        $email = $entidad->getEmail();
        $salida = '<div class="w3-row">
                <div class="w3-container w3-half w3-card-8 w3-theme-d3 w3-padding-32">
                    <img class="m-simple-user-img" src="../media/img/icons_users/man-user.png">
                    <ul class="w3-ul w3-border-bottom">
                        <li><span class="w3-large">ID del Usuario</span><br><span class="m-text-sub1">' . $id . '</span></li>
                        <li><span class="w3-large">ROL</span><br><span class="m-text-sub1">' . $rol . '</span></li>
                        <li><span class="w3-large">ESTADO</span><br><span class="m-text-sub1">' . $estado . '</span></li>
                        <li><span class="w3-large">EMAIL</span><br><span class="m-text-sub1">' . $email . '</span></li>
                    </ul>
                </div>
            </div>';
        echo($salida);
    }

    public function maquetaCardSesion(UsuarioDTO $user, CuentaDTO $cuenta) {
        $idUser = Validador::fixTexto($user->getIdUsuario());
        $nombre = Validador::fixTexto($cuenta->getPrimerNombre());
        $apellido = Validador::fixTexto($cuenta->getPrimerApellido());
        $nombres = $nombre . " " . $apellido;
        $salida = '<hr><div class="w3-row">
                <div class="w3-container w3-theme-d2 w3-half w3-right">
                    <div class="w3-row">
                        <div class="w3-quarter">
                            <img class="m-user-in-sesion-img" src="../media/img/icons_users/man-user.png">
                        </div>
                        <div class="w3-theme-l5 w3-container w3-threequarter">
                            <ul class="w3-ul w3-tiny">
                                <li><span class="w3-text-theme">NOMBRE: <b>' . $nombres . '</b></span></li>
                                <li><span class="w3-text-theme">TU USERNAME: <b>' . $idUser . '</b></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="w3-right w3-container w3-padding-4 w3-card-2">
                        <a href="controlador/negocio/unlog.php"><button class="w3-btn w3-blue w3-tiny w3-text-white w3-round-large m-c-v">Salir<img class="m-user-admin-icons" src="../media/img/icons_users/logout.png" ></button></a>
                        <a href="configurar_cuenta.php"><button class="w3-btn w3-blue w3-tiny w3-text-white w3-round-large m-c-v">Configuración<img class="m-user-admin-icons" src="../media/img/icons_users/config_cuenta.png" ></button></a>
                    </div>
                </div>
            </div>';
        echo($salida);
    }

    public function maquetarManagerLink($userName) {
        echo('<div class="m-manager-tools w3-col l3 m5 s12 w3-container w3-animate-right">
                <img src="../media/img/icons_users/man-with-sunglasses-and-suit.png" style="width: 25px; height: auto; margin: auto;">
                <span class="w3-small w3-text-green">Bienvenido ' . $userName . ' (Administrador)</span><br>
                <a href="admin_panel.php" target="_blank"><button class="w3-btn w3-green w3-round-xlarge w3-tiny">IR A PANEL DE ADMINISTRADOR</button></a>
                <a href="controlador/negocio/unlog.php"><button class="w3-btn w3-green w3-round-xlarge w3-tiny">SALIR</button></a>
            </div>');
    }

    public function maquetaSubManagerLink($userName) {
        echo('<div class="m-manager-tools w3-col l3 m5 s12 w3-container w3-animate-right">
                <img src="../media/img/icons_users/man-with-sunglasses-and-suit.png" style="width: 25px; height: auto; margin: auto;">
                <span class="w3-small w3-text-blue">Bienvenido ' . $userName . ' (Administrador)</span><br>
                <a href="admin_panel.php" target="_blank"><button class="w3-btn w3-blue w3-round-xlarge w3-tiny">IR A PANEL DE ADMINISTRADOR</button></a>
                <a href="controlador/negocio/unlog.php"><button class="w3-btn w3-blue w3-round-xlarge w3-tiny">SALIR</button></a>
            </div>');
    }

    //Metodo reservado para maquetar la tabla de crud de usuarios. (Solo accesible por el administrador)
    public function maquetarCrudUsuarios(array $tablaUsuarios) {

        echo('<div class="w3-row w3-responsive w3-block">
                    <table class="w3-table-all w3-hoverable w3-responsive w3-small w3-striped">
                        <tr class="w3-theme-d3">
                            <th style="width: 10%; max-width: 10%">ACCIONES</th>
                            <th style="width: 25%; max-width: 25%">ID USUARIO</th>
                            <th style="width: 20%; max-width: 20%">ROL</th>
                            <th style="width: 20%; max-width: 20%">ESTADO</th>
                            <th style="width: 25%; max-width: 25%">EMAIL</th>
                        </tr>');
        foreach ($tablaUsuarios as $user) {
            $user instanceof UsuarioDTO;
            $idUsuario = Validador::fixTexto($user->getIdUsuario());
            $idUsuarioCrip = CriptManager::urlVarEncript($idUsuario);
            $estado = ($user->getEstado());

            $rol = $user->getRol();
            $rolUser = $this->formatRolUser($rol);

            $estadoUser = "";
            if ($estado == "ENABLED") {
                $estadoUser = "ACTIVO";
            } else {
                $estadoUser = "INACTIVO";
            }
            $email = Validador::fixTexto($user->getEmail());

//            <button onclick="mostrarAdvancedConfigUser(\'' . $idUsuarioCrip . '\')" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Configuracion Avanzada">
//                                        <span class="glyphicon glyphicon-cog"></span>
//                                    </button>
            echo('
               <tr>
                    <td> 
                        <div class="btn-group">
                            <button onclick="mostrarFormModificarUsuario(\'' . $idUsuarioCrip . '\')" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Editar">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
            ');
            if ($user->getEstado() == UsuarioDAO::EST_ACTIVO) {
                echo (' <button  onclick="disableEnableUsuario(\'' . $idUsuarioCrip . '\')" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Desactivar">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>');
            } else {
                echo('
                       <button  onclick="disableEnableUsuario(\'' . $idUsuarioCrip . '\')" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Activar">
                             <span class="glyphicon glyphicon-ok"></span>
                       </button> 
                ');
            }
            echo('
                           

                        </div>
                    </td>
                    <td>' . $idUsuario . '</td>
                    <td>' . $rolUser . '</td>
                    <td>' . $estadoUser . '</td>
                    <td>' . $email . '</td>
                </tr> 
            ');
        }
        echo('</table>
                </div>');
    }

    public function maquetarFormUpdateUsuario(UsuarioDTO $user, CuentaDTO $account) {
        $modal = new ModalSimple();
        $closeBtn = new CloseBtn();
        $closeBtn->setValor("Cancelar");
        $modal->addElemento($closeBtn);
        $idUsuario = $user->getIdUsuario();
        $email = Validador::fixTexto($user->getEmail());
        $rolInt = $this->formatRolToInt($user->getRol());
        $rolHtml = $this->formatRolUser($user->getRol());
        $tipDoc = $account->getTipoDocumento();
        $strTipDoc = "";
        switch ($tipDoc) {
            case "CC":
                $strTipDoc = "Cedula de Ciudadania";
                break;
            case "TI":
                $strTipDoc = "Tarjeta de Identidad";
                break;
            case "CEX":
                $strTipDoc = "Cedula de Extranjeria";
                break;
            case "RC":
                $strTipDoc = "Registro Civil";
                break;
            case "PST":
                $strTipDoc = "Pasaporte";
                break;
        }
        $numDoc = $account->getNumDocumento();
        $primName = $account->getPrimerNombre();
        $secName = $account->getSegundoNombre();
        $primApe = $account->getPrimerApellido();
        $secApe = $account->getSegundoApellido();
        $telefono = $account->getTelefono();
        $modal->open();
        echo('
            <ul class="w3-ul w3-card-8 w3-tiny w3-hoverable w3-border">
                <li>Los campos con <span class="w3-text-red w3-large">*</span> son OBLIGATORIOS</li>
                <li>Para cambiar la contraseña digite una nueva, de lo contrario deje el campo vacio</li>
                <li>La contraseña debe tener minimo 8 caracteres incluyendo al menos 3 numeros</li>
                <li>El campo de teléfono sólo debe contener números</li>
            </ul>
            <form method="POST" id="modificarUsuario" action="controlador/negocio/usuario_modificar.php">
                <div class="w3-row">
                    <div class="w3-half w3-container w3-theme-d1">
                        <h3 class="w3-center">Datos de Usuario</h3><hr class="w3-lime">
                        
                        <input type="hidden" name="user_id" id="user_id" value="' . $idUsuario . '">
                        
                        <label for="user_id" class="labels">Correo Electrónico</label>
                        <input type="email" class="input_texto" name="user_email" id="user_email" placeholder="Email" required onblur="valida_user_email()" value="' . $email . '">
                        <span class="w3-text-red w3-large">*</span>
                        <div><span class="w3-tiny w3-text-red" id="user_email_res"></span></div>
                        <br>
                        <label for="user_id" class="labels">Contraseña</label>
                        <input type="password" class="input_texto" name="user_password" id="user_passwordA" placeholder="Password" onkeydown="valida_user_passA()" onblur="valida_user_passA()">
                        <span class="w3-text-red w3-large">*</span>
                        <div><span class="w3-tiny w3-text-red" id="user_passA_res"></span></div>
                        <div><span class="w3-tiny" id="user_passA_res2"></span></div>
                        <br>
                        <label for="user_id" class="labels">Repite la contraseña</label>
                        <input type="password" class="input_texto" name="user_passwordB" id="user_passwordB" placeholder="Password" onblur="valida_user_passB()" onpaste="avoid_paste()">
                        <span class="w3-text-red w3-large">*</span>
                        <div><span class="w3-tiny" id="user_passB_res"></span></div>
                        <br>
                        <label for="rol_user" class="labels">Rol del Usuario</label>
                        <select name="rol_user" id="rol_user" class="m-selects">
                            <option value="' . $rolInt . '" selected>' . $rolHtml . '</option>
                            <option value="1">Cliente Corriente</option>
                            <option value="2">Cliente Particular</option>
                            <option value="3">Institucion Educativa</option>                          
                            <option value="4">Administrador (Secundario)</option>                          
                        </select>
                    </div>
                    <div class="w3-half w3-container w3-theme-d1">
                        <h3 class="w3-center">Información Personal</h3><hr class="w3-lime">
                        <label for="cuenta_tip_doc" class="labels">Tipo de Documento</label>
                        <select name="cuenta_tip_doc" id="cuenta_tip_doc" class="m-selects">
                            <option value="' . $tipDoc . '" selected >' . $strTipDoc . '</option>
                            <option value="CC">CC. Cedula de Ciudadania</option>
                            <option value="TI">TI. Tarjeta de Identidad</option>
                            <option value="CEX">CEX. Cedula de Extranjería</option>
                            <option value="RC">RC. Registro Civil</option>                            
                            <option value="PST">PST. Pasaporte</option>                            
                        </select>
                        <span class="w3-text-red w3-large">*</span>
                        <br>
                        <label for="cuenta_num_doc" class="labels">Número de Documento</label>
                        <input type="text" value="' . $numDoc . '" class="input_texto" name="cuenta_num_doc" id="cuenta_num_doc" placeholder="Numero de Documento" required onblur="valida_simple_input(this)">
                        <span class="w3-text-red w3-large">*</span>

                        <label for="cuenta_prim_name" class="labels">Primer Nombre</label>
                        <input type="text" value="' . $primName . '" class="input_texto" name="cuenta_prim_name" id="cuenta_prim_name" placeholder="Primer Nombre" required onblur="valida_simple_input(this)">
                        <span class="w3-text-red w3-large">*</span>

                        <label class="labels">Segundo Nombre</label>
                        <input type="text" value="' . $secName . '" class="input_texto" name="cuenta_sec_name" id="cuenta_sec_name" placeholder="Segundo Nombre">
                        <br>
                        <label class="labels">Primer Apellido</label>
                        <input type="text" value="' . $primApe . '" class="input_texto" name="cuenta_prim_ape" id="cuenta_prim_ape" placeholder="Primer Apellido" required onblur="valida_simple_input(this)">
                        <span class="w3-text-red w3-large">*</span>

                        <label class="labels">Segundo Apellido</label>
                        <input type="text" value="' . $secApe . '" class="input_texto" name="cuenta_sec_ape" id="cuenta_sec_ape" placeholder="Segundo Apellido">
                        <br>
                        <label class="labels">Teléfono</label>
                        <input type="text" value="' . $telefono . '" class="input_texto" name="cuenta_tel" id="cuenta_tel" placeholder="Telefono de Contacto" required onblur="valida_simple_input(this)">
                        <span class="w3-text-red w3-large">*</span>
                    </div>
                </div>
                <div class="w3-center w3-padding-8">
                    <input type="submit" class="w3-btn w3-round-large w3-border-blue w3-theme-l1" value="Modificar">
                </div>
            </form>

        ');
        $modal->maquetar();
        $modal->close();
    }

    public function maquetaNoLoginTobuy() {
        return('<div class="w3-row w3-them-l1 w3-center">
                <div class="w3-quarter"></div>
                <div class="w3-half">
                    <div class="w3-panel w3-card-4 w3-blue">
                        <span class="w3-large w3-center">
                            Estimado usuario. Para comprar en Rapid Jackets, usted debe tener una cuenta y haber iniciado Sesión
                        </span><br><br>
                        <div class="w3-center w3-padding-12">
                            <a href="registro_usuarios.php"><button class="w3-btn w3-theme-d2 w3-small">No tengo cuenta. Registrarme</button></a>
                            <a href="iniciar_sesion.php"><button class="w3-btn w3-green w3-small">Ya tengo cuenta. Iniciar Sesión</button></a>
                        </div>
                    </div>
                </div>
                <div class="w3-quarter"></div>
            </div>');
    }

    public function maquetaLogedUserMenu() {
        //Metodo a ubicar en el header de la página
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        if ($sesion->existe(Session::US_LOGED)) {
            $userS = $sesion->getEntidad(Session::US_LOGED);
            $userS instanceof UsuarioDTO;
            $idUser = Validador::fixTexto($userS->getIdUsuario());
            echo('<li class="w3-right"><a class="w3-theme-dark w3-hover-red" href="controlador/negocio/unlog.php">Salir <img class="m-user-admin-icons" src="../media/img/icons_users/logout.png" ></a></li>
            <li class="w3-right"><a class="w3-theme-l1 w3-hover-green" href="configurar_cuenta.php">Tu Perfil: <b>' . $idUser . '</b> <img class="m-user-admin-icons" src="../media/img/icons_users/config_cuenta.png" ></a></li>');
            echo('<li class="w3-right"><a class="w3-theme-d3 w3-hover-pink" href="#">Tus compras  <img class="m-user-admin-icons" src="../media/img/icons_clothes/hand-bag-5.png"> </a></li>');
        } else {
            echo('<li class="w3-right"><a class="w3-hover-green" href="iniciar_sesion.php">Inicie Sesion</a></li>
            <li class="w3-right"><a class="w3-hover-orange" href="registro_usuarios.php">Registrarse</a></li>');
        }
    }

    public function maquetaFormAccoutRecoveryChangePassword($userIdCripted) {
        echo('
            <form name="form_acc_recovery_change_password" method="POST" id="form_acc_recovery_change_password" action="controlador/controllers/ControlVistas.php">
    <input type="hidden" name="m" value="password_recovery_part_final"> 
    <input type="hidden" name="user_id" value="'.$userIdCripted.'"> 
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
                    <button class="w3-btn m-boton-a w3-red" type="reset" onclick="window.location.replace(\'iniciar_sesion.php\')">Cancelar</button>
                </div>
            </div>
            <div class="w3-quarter w3-container"></div>
        </div>
    </div>
</form>
        ');
    }

}
