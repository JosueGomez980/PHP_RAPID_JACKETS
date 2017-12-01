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

    public function maquetarNothingXD() {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $cuentaSession = $sesion->getEntidad(Session::CU_LOGED);
        $cuentaSession instanceof CuentaDTO;

        if (!$sesion->existe(Session::US_LOGED)) {

            echo '<br><br>
                <div class="container-fluid w3-white is-Tamaño-ContainerXD" style="border-radius: 20px;">
                    <br><br>
                    <div class="w3-center">
                        <span class="is-Tamaño-Letra09"> 
                            <span class="glyphicon glyphicon-yen"></span>
                             Nothing  
                            <span class="glyphicon glyphicon-ice-lolly-tasted"></span>
                        </span>
                        <br>
                        <img class="m-login-logo w3-animate-zoom" src="../media/img/NothingXD.png">
                        <br>
                        <br><a href="inicio.php"><button class="is-Button-Nothing">Inicio</button></a>
                    </div>
                    <br><br>
                </div>
                <br><br>';
        } else {

            echo '<br><br>
                <div class="container-fluid w3-white is-Tamaño-ContainerXD" style="border-radius: 20px;">
                    <br><br>
                    <div class="w3-center">
                        <span class="is-Tamaño-Letra09"> 
                            <span class="glyphicon glyphicon-yen"></span>
                             Nothing ' . $cuentaSession->getPrimerNombre() . ' 
                            <span class="glyphicon glyphicon-ice-lolly-tasted"></span>
                        </span>
                        <br>
                        <img class="m-login-logo w3-animate-zoom" src="../media/img/NothingXD.png">
                        <br>
                        <br><a href="inicio.php"><button class="is-Button-Nothing">Inicio</button></a>
                    </div>
                    <br><br>
                </div>
                <br><br>';
        }
    }

    public function maquetaNavSession(CuentaDTO $cuenta) {
        $nombre = $cuenta->getPrimerNombre();
        $apelldido = $cuenta->getPrimerApellido();
        $nombreCompleto = $nombre . " " . $apelldido;
        $este = '<nav class="navbar m-nav is-navbar-XD">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav">
                            <li><a class="is-hover-Letra01 w3-center" href="inicio.php">Inicio</a></li>
                            <li><a class="is-hover-Letra01 w3-center" href="sobre_nosotros.php">Sobre Nosotros</a></li>
                            <li><a class="is-hover-Letra01 w3-center" href="productos.php">Nuestros productos</a></li>
                            <li><a class="is-hover-Letra01 w3-center" href="contacto.php">Contactenos</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a class="is-hover-Color11 w3-center" onclick="verCarritoComprasInModal()"><img src="../media/img/CarritoNav.png" alt="CarritoRapidJackets" title="Ver Carrito Rapid" style="width: 25px;">  Ver carrito</a></li>
                            <li><a class="is-hover-Color10 w3-center"><span class="glyphicon glyphicon-user"></span> ' . $nombreCompleto . '</a></li>
                            <li><a href="configurar_cuenta.php" class="is-hover-Color12 w3-center"><span class="glyphicon glyphicon-cog"></span> Configuracion</a></li>
                            <li><a href="controlador/negocio/unlog.php" class="w3-hover-black w3-center"><span class="glyphicon glyphicon-off"></span> Cerrar Sesion</a></li>
                        </ul>
                    </nav>
                </div>';
        echo ($este);
    }

    public function maquetaNavAdminPrin(CuentaDTO $cuenta) {

        $nombre = $cuenta->getPrimerNombre();
        $apelldido = $cuenta->getPrimerApellido();
        $nombreCompleto = $nombre . " " . $apelldido;
        $esteOtro = '<nav class="navbar"  style="background-color: #fff; border-bottom: 2px solid #000">
                        <div class="container-fluid">
                            <ul class="nav navbar-nav">
                                <li><a class="is-hover-Letra02 text-center" href="gestion_usuarios_crud.php" style="color: #000;">Gestión de Usuarios</a></li>
                                <li><a class="is-hover-Letra02 text-center" href="gestion_productos.php" style="color: #000;">Gestión de Productos</a></li>
                                <li><a class="is-hover-Letra02 text-center" href="gestion_categorias.php" style="color: #000;">Gestión de Categorías</a></li>
                                <li><a class="is-hover-Letra02 text-center" href="gestion_inventarios.php" style="color: #000;">Gestión de Inventarios</a></li>
                                <li><a class="is-hover-Letra02 text-center" href="gestion_reportes.php" style="color: #000;">Gestión de Reportes</a></li>
                                <li><a class="is-hover-Letra02 text-center" href="gestion_pedidos_facturas.php" style="color: #000;">Gestión de Facturas</a></li>
                            </ul>
                        <ul class="nav navbar-nav navbar-right">
                        <li><a class="is-hover-ColorAdmin text-center" style="color: #000;"><span class="glyphicon glyphicon-user"></span> ' . $nombreCompleto . '</a></li>
                        <li><a href="inicio.php" class="is-hover-Color12 text-center" style="color: #000;"><span class="glyphicon glyphicon-th-large"></span> Pagina de Inicio</a></li>
                        </ul>
                    </nav>
                </div>';
        echo ($esteOtro);
    }

    public function maquetaNavAdminSec(CuentaDTO $cuenta) {

        $nombre = $cuenta->getPrimerNombre();
        $apelldido = $cuenta->getPrimerApellido();
        $nombreCompleto = $nombre . " " . $apelldido;
        $esteOtro = '<nav class="navbar"  style="background-color: #fff; border-bottom: 2px solid #000">
                        <div class="container-fluid">
                            <ul class="nav navbar-nav">
                                <li><a class="is-hover-Letra02 text-center" href="gestion_productos.php" style="color: #000;">Gestión de Productos</a></li>
                                <li><a class="is-hover-Letra02 text-center" href="gestion_categorias.php" style="color: #000;">Gestión de Categorías</a></li>
                                <li><a class="is-hover-Letra02 text-center" href="gestion_inventarios.php" style="color: #000;">Gestión de Inventarios</a></li>
                                <li><a class="is-hover-Letra02 text-center" href="gestion_reportes.php" style="color: #000;">Gestión de Reportes</a></li>
                                <li><a class="is-hover-Letra02 text-center" href="gestion_pedidos_facturas.php" style="color: #000;">Gestión de Facturas</a></li>
                            </ul>
                        <ul class="nav navbar-nav navbar-right">
                        <li><a class="is-hover-ColorAdmin text-center" style="color: #000;"><span class="glyphicon glyphicon-user"></span> ' . $nombreCompleto . '</a></li>
                        <li><a href="inicio.php" class="is-hover-Color12 text-center" style="color: #000;"><span class="glyphicon glyphicon-th-large"></span> Pagina de Inicio</a></li>
                        </ul>
                    </nav>
                </div>';
        echo ($esteOtro);
    }

    public function maquetarManagerLink($userName) {
        echo('<div class="m-manager-tools w3-col l2 m5 s12 w3-container w3-animate-right w3-center">
                <img src="../media/img/icons_users/man-with-sunglasses-suit-and-star.png" style="width: 25px; height: auto; margin: auto;">
                <span class="w3-small" style="color: #000">Bienvenido ' . $userName . '</span><br>
                <a href="admin_panel.php" target="_blank"><button class="w3-btn w3-black w3-round-xlarge w3-tiny">IR A PANEL DE ADMINISTRADOR</button></a>
            </div>');
    }

    public function maquetaSubManagerLink($userName) {
        echo('<div class="is-Submanager-Tool-͡°͜ʖ͡° w3-col l2 m5 s12 w3-container w3-animate-right w3-center">
                <img src="../media/img/icons_users/man-with-sunglasses-and-suit.png" style="width: 25px; height: auto; margin: auto;">
                <span class="w3-small w3-text-blue">Bienvenido ' . $userName . '</span><br>
                <a href="admin_panel.php" target="_blank"><button class="w3-btn w3-blue w3-round-xlarge w3-tiny">IR A PANEL DE ADMINISTRADOR</button></a>
            </div>');
    }

//Metodo reservado para maquetar la tabla de crud de usuarios. (Solo accesible por el administrador)
    public function maquetarCrudUsuarios(array $tablaUsuarios) {

        echo('<div class="container-fluid" style="width: 85%">
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
                </div>
                <br>');
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
                <form method="POST" id="modificarUsuario" action="controlador/negocio/usuario_modificar.php" class="form-horizontal">
                    
                    <div class="w3-row" style="background-color: #BDBDBD;">
                    <ul class="w3-ul w3-card-8 w3-tiny w3-border w3-white">
            <li class="w3-center">Los campos con <span class="w3-text-red">*</span> son OBLIGATORIOS</li>
            <li class="w3-center">El campo de teléfono sólo debe contener números</li>
        </ul>
                        <br>
                        <div class="container-fluid" style="width: 95%; border-radius: 15px; background-color: #797D7F;">
                            <br>
                            <h3 class="w3-center" style="color: #fff; font-weight:bolder;">Datos de Usuario</h3><center><hr style="width: 80%"></<center>

                            <input type="hidden" name="user_id" id="user_id" value="' . $idUsuario . '">

                            <div class="form-group">
                                <label for="user_id" class="is-Labels-XD col-lg-3 control-label">Correo Electrónico : </label>
                                <div class="col-lg-8">
                                    <input type="email" style="border:1px solid #000000" class="input_texto" name="user_email" id="user_email" placeholder="Email" required onblur="valida_user_email()" value="' . $email . '">
                                    <span class="w3-text-red w3-large">*</span>
                                    <div><span class="w3-tiny w3-text-red" id="user_email_res"></span></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_id" class="is-Labels-XD col-lg-3 control-label">Contraseña : </label>
                                <div class="col-lg-8">
                                    <input type="password" style="border:1px solid #000000" class="input_texto" name="user_password" id="user_passwordA" placeholder="Password" required onkeydown="valida_user_passA()" onblur="valida_user_passA()">
                                    <span class="w3-text-red w3-large">*</span>
                                    <div><span class="w3-tiny w3-text-red" id="user_passA_res"></span></div>
                                    <div><span class="w3-tiny" id="user_passA_res2"></span></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_id" class="is-Labels-XD col-lg-3 control-label">Repite la contraseña : </label>
                                <div class="col-lg-8">
                                    <input type="password" style="border:1px solid #000000" class="input_texto" name="user_passwordB" id="user_passwordB" placeholder="Password" required onblur="valida_user_passB()" onpaste="avoid_paste()">
                                    <span class="w3-text-red w3-large">*</span>
                                    <div><span class="w3-tiny" id="user_passB_res"></span></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="rol_user" class="is-Labels-XD col-lg-3 control-label">Rol de Usuario : </label>
                                <div class="col-lg-8">
                                    <select name="rol_user" id="rol_user" class="is-Selects" style="border:1px solid #000">
                                        <option value="' . $rolInt . '" selected>' . $rolHtml . '</option>
                                        <option value="1">Cliente Corriente</option>
                                        <option value="2">Cliente Particular</option>
                                        <option value="3">Institucion Educativa</option>                          
                                        <option value="4">Administrador (Secundario)</option>                          
                                    </select>
                                </div>
                            </div>
                            
                            <br>
                        </div>
                        <br>
                        <div class="container-fluid" style="width: 95%; border-radius: 15px; background-color: #797D7F;">
                            <br><h3 class="w3-center"  style="color: #fff; font-weight:bolder;">Información Personal</h3><center><hr style="width: 80%"></center><br>

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
                                    <input type="text" value="' . $numDoc . '" style="border:1px solid #000000" class="input_texto" name="cuenta_num_doc" id="cuenta_num_doc" placeholder="Numero de Documento" required onblur="valida_simple_input(this)">
                                    <span class="w3-text-red w3-large">*</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cuenta_prim_name" class="is-Labels-XD col-lg-3 control-label">Primer Nombre : </label>
                                <div class="col-lg-8">
                                    <input type="text" value="' . $primName . '" style="border:1px solid #000000" class="input_texto" name="cuenta_prim_name" id="cuenta_prim_name" placeholder="Primer Nombre" required onblur="valida_simple_input(this)">
                                    <span class="w3-text-red w3-large">*</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="is-Labels-XD col-lg-3 control-label">Segundo Nombre : </label>
                                <div class="col-lg-8">
                                    <input type="text" value="' . $secName . '" style="border:1px solid #000000" class="input_texto" name="cuenta_sec_name" id="cuenta_sec_name" placeholder="Segundo Nombre">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="is-Labels-XD col-lg-3 control-label">Primer Apellido : </label>
                                <div class="col-lg-8">
                                    <input type="text" value="' . $primApe . '" style="border:1px solid #000000" class="input_texto" name="cuenta_prim_ape" id="cuenta_prim_ape" placeholder="Primer Apellido" required onblur="valida_simple_input(this)">
                                    <span class="w3-text-red w3-large">*</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="is-Labels-XD col-lg-3 control-label">Segundo Apellido : </label>
                                <div class="col-lg-8">
                                    <input type="text" value="' . $secApe . '" style="border:1px solid #000000" class="input_texto" name="cuenta_sec_ape" id="cuenta_sec_ape" placeholder="Segundo Apellido">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="is-Labels-XD col-lg-3 control-label">Teléfono : </label>
                                <div class="col-lg-8">
                                    <input type="text" value="' . $telefono . '" style="border:1px solid #000000" class="input_texto" name="cuenta_tel" id="cuenta_tel" placeholder="Telefono de Contacto" required onblur="valida_simple_input(this)">
                                    <span class="w3-text-red w3-large">*</span>
                                </div>
                            </div>

                            <div class="w3-center w3-padding-24">
                                <input type="submit" class="w3-btn is-Button-CarritoXD" value="Modificar">
                            </div>
                        </div>
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
    <input type="hidden" name="user_id" value="' . $userIdCripted . '"> 
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

    public function generarStringReporteA(array $usuarios, $hojaCss) {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $cuentaAdmin = $sesion->getEntidad(Session::CU_ADMIN_LOGED);
        $cuentaAdmin instanceof CuentaDTO;
        $userAdmin = $sesion->getEntidad(Session::US_ADMIN_LOGED);
        $userAdmin instanceof UsuarioDTO;
        $idUser = utf8_decode($userAdmin->getIdUsuario());
        $nombreAdmin = utf8_decode($cuentaAdmin->getPrimerNombre() . " " . $cuentaAdmin->getPrimerApellido());
        $dater = new DateManager();
        $fecha = $dater->dateSpa1();
        $salida = null;
        $salida = '<style>' . $hojaCss . '</style>';
        $cantidad = count($usuarios);
        $salida .= ('  
                <div class="is-Head-XD" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <p class="is-PXD" style="text-align: right;">
                    ' . $fecha . '
                    <p class="is-PXD">
                     <center><div class="is-Imgen-Logo-Report"><img src="../media/img/LogoCreaciones.png"></div></center> 
                     <p class="is-PXD">
                        Obtenidos ' . $cantidad . ' Usuarios<br><br>
                        Reporte solicitado por: ' . $nombreAdmin . ' (' . $idUser . ')
                     </p>     
                </div>
               <table class="is-Tabla-Heidy" style="width: 100%;">
                    <tr class="lol">
                        <th class="is-Tabla-Heidy-Tr" style="width:30%">ID de Usuario / Email</th>
                        <th class="is-Tabla-Heidy-Tr">Rol</th>
                        <th class="is-Tabla-Heidy-Tr">Estado</th>
                    </tr>');
        $UserDAO = UsuarioDAO::getInstancia();
        $UserDAO instanceof UsuarioDAO;
        foreach ($usuarios as $usu) {
            $usu instanceof UsuarioDTO;
            $idUsuario = $usu->getIdUsuario();
            $rol = $usu->getRol();
            $email = $usu->getEmail();
            $estado = $usu->getEstado();

            $salida .= '<tr class="lol">
                        <td class="is-Tabla-Heidy-Th" style="width:30%"><center>' . $idUsuario . '<br><b>' . $email . '</b></center></td>
                        <td class="is-Tabla-Heidy-Th"><center>' . $rol . '</center></td>';
            if ($estado) {
                $salida .= '<td class="is-Tabla-Heidy-Th"><center>Activo</center></td>';
            } else {
                $salida .= '<td class="is-Tabla-Heidy-Th"><center>Inactivo</center></td>';
            }
            $salida .= '</tr>';
        }
        $salida .= '</table>';
        return $salida;
    }

}
