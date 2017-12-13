<?php

class UsuarioRequest extends Request {

    private $usuarioDTO;

    const us_id = "user_id";
    const us_pass = "user_password";
    const us_rol = "user_rol";
    const us_estado = "user_estado";
    const us_mail = "user_email";

    public function __construct() {
        parent::__construct();
    }

    public function getUsuarioDTO() {
        return $this->usuarioDTO;
    }

    public function setUsuarioDTO(UsuarioDTO $usuarioDTO) {
        $this->usuarioDTO = $usuarioDTO;
    }

    //Cuando al instanciarse esta clase se detecta que la forma de envio es Get, se ejecuta este metodo
    public function doGet() {
        $userTemp = new UsuarioDTO();
        if (isset($_GET[self::us_id])) {
            $userTemp->setIdUsuario($_GET[self::us_id]);
        }
        if (isset($_GET[self::us_pass])) {
            $userTemp->setPassword($_GET[self::us_pass]);
        }
        if (isset($_GET[self::us_rol])) {
            $userTemp->setRol($_GET[self::us_rol]);
        }
        if (isset($_GET[self::us_estado])) {
            $userTemp->setEstado($_GET[self::us_estado]);
        }
        if (isset($_GET[self::us_mail])) {
            $userTemp->setEmail($_GET[self::us_mail]);
        }
        $this->usuarioDTO = $userTemp; // Al final la propiedad private $usuarioDTO; se le asigna la instancia temporal. Sin ningua variable fue detectada 
    }

    public function doPost() {
        $userTemp = new UsuarioDTO();
        if (isset($_POST[self::us_id])) {
            $userTemp->setIdUsuario($_POST[self::us_id]);
        }
        if (isset($_POST[self::us_pass])) {
            $userTemp->setPassword($_POST[self::us_pass]);
        }
        if (isset($_POST[self::us_rol])) {
            $userTemp->setRol($_POST[self::us_rol]);
        }
        if (isset($_POST[self::us_estado])) {
            $userTemp->setEstado($_POST[self::us_estado]);
        }
        if (isset($_POST[self::us_mail])) {
            $userTemp->setEmail($_POST[self::us_mail]);
        }
        $this->usuarioDTO = $userTemp;
    }

    public function doDelete() {
        return NULL;
    }

    public function doHead() {
        return NULL;
    }

    public function doPut() {
        return NULL;
    }

    public function doRequest() {
        $userTemp = new UsuarioDTO();
        if (isset($_REQUEST[self::us_id])) {
            $userTemp->setIdUsuario($_REQUEST[self::us_id]);
        }
        if (isset($_REQUEST[self::us_pass])) {
            $userTemp->setPassword($_REQUEST[self::us_pass]);
        }
        if (isset($_REQUEST[self::us_rol])) {
            $userTemp->setRol($_REQUEST[self::us_rol]);
        }
        if (isset($_REQUEST[self::us_estado])) {
            $userTemp->setEstado($_REQUEST[self::us_estado]);
        }
        if (isset($_REQUEST[self::us_mail])) {
            $userTemp->setEmail($_REQUEST[self::us_mail]);
        }
        $this->usuarioDTO = $userTemp;
    }

}

class UsuarioController implements Validable, GenericController {

    private $usuarioDAO;
    protected $contentMgr;
    private $usuarioMQT;
    private $cuentaRescueDAO;
    public static $instance;

    public function __construct() {
        $this->usuarioDAO = UsuarioDAO::getInstancia();
        $this->usuarioDAO instanceof UsuarioDAO;
        $this->usuarioDAO = new UsuarioDAO();
        $this->contentMgr = ContentManager::getInstancia();
        $this->usuarioMQT = new UsuarioMaquetador();
        $this->cuentaRescueDAO = new CuentaRescueDAO();
    }

    public static function getInstancia() {
        if (is_null(self::$instance)) {
            self::$instance = new UsuarioController();
        }
        return self::$instance;
    }

    public function validaFK(EntityDTO $entidad) {
        return NULL;
    }

    //Retorna TRUE si no se encuentra un usuario que tenga ese id y FALSE si lo encuentra
    public function validaPK(EntityDTO $entidad) {
        $res = TRUE;
        if ($this->usuarioDAO->find($entidad) != NULL) {
            $res = FALSE;
        }
        return $res;
    }

    public function formatRolUser($numRol) {
        $strRol = "";
        if ($numRol <= 6 && $numRol >= 1) {
            switch ($numRol) {
                case 1:
                    $strRol = UsuarioDAO::ROL_USER;
                    break;
                case 2:
                    $strRol = UsuarioDAO::ROL_PARTICULAR;
                    break;
                case 3:
                    $strRol = UsuarioDAO::ROL_COLEGIO;
                    break;
                case 4:
                    $strRol = UsuarioDAO::ROL_SUB_ADMIN;
                    break;
                case 5:
                    $strRol = UsuarioDAO::ROL_MAIN_ADMIN;
                    break;
                case 6:
                    $strRol = "TODOS";
                    break;
                default :
                    $strRol = "NONE";
                    break;
            }
        } else {
            $strRol = "NONE";
        }
        return $strRol;
    }

    public function usuarioIsNotVerified(UsuarioDTO $user) {
        $crip = CriptManager::getInstacia();
        $crip instanceof CriptManager;
        $rta = false;
        switch ($user->getEstado()) {
            case UsuarioDAO::EST_ACTIVO:
                break;
            case UsuarioDAO::EST_ELIMINADO:
                break;
            case UsuarioDAO::EST_INACTIVO:
                break;
            case UsuarioDAO::EST_NO_VALID:
                $rta = true;
                break;
            default : {
                    $estadoCrip = $user->getEstado();
                    $estaNoCrip = $crip->AES_Decript($estadoCrip, UsuarioDAO::EST_NO_VALID);
                    $estArr = explode("|", $estaNoCrip);
                    if ($estArr[1] == UsuarioDAO::EST_NO_VALID) {
                        $rta = true;
                    }
                    break;
                }
        }
        return $rta;
    }

    public function insertar(EntityDTO $entidad) {
        $rta = FALSE;
        $entidad instanceof UsuarioDTO;
        if (!$this->validaPK($entidad)) {
            $this->contentMgr->setFormato(new Errado());
            $this->contentMgr->setContenido("No puedes escoger este usuario (" . Validador::fixTexto($entidad->getIdUsuario()) . "). Pues ya está en uso. Debes elegir otro");
        } else {
            $res = $this->usuarioDAO->insert($entidad);
            switch ($res) {
                case 1: {
                        $this->contentMgr->setFormato(new Exito());
                        $this->contentMgr->setContenido("¡ Los datos de usuario han sido registrados exitosamente <br>Ahora puedes Iniciar sesión con los datos que has enviado <a href='iniciar_sesion.php'><h4>Log In</h4></a>");
                        $rta = TRUE;
                        break;
                    }
                case 0: {
                        $this->contentMgr->setFormato(new Errado());
                        $this->contentMgr->setContenido("No se pudo registrar el usuario " . Validador::fixTexto($entidad->getIdUsuario()) . ". Por favor intente de nuevo");
                        break;
                    }
                case -1: {
                        $this->contentMgr->setFormato(new Errado());
                        $this->contentMgr->setContenido("Hubo un error grave al momento de realizar la operacion :(");
                        break;
                    }
            }
        }
        return $rta;
    }

    public function actualizar(EntityDTO $entidad) {
        $ok = FALSE;
        $entidad instanceof UsuarioDTO;
        $rta = $this->usuarioDAO->update($entidad);
        switch ($rta) {
            case 1: {
                    $this->contentMgr->setFormato(new Exito());
                    $this->contentMgr->setContenido("Los datos de logeo se han guardado. Se aplicaron los cambios");
                    $ok = TRUE;
                    break;
                }
            case 0: {
                    $this->contentMgr->setFormato(new Neutral());
                    $this->contentMgr->setContenido("No se detectaron cambios en los datos de logeo");
                    $ok = TRUE;
                    break;
                }
            case -1: {
                    $this->contentMgr->setFormato(new Errado());
                    $this->contentMgr->setContenido("Hubo un error grave al intentar modificar este usuario. Por favor verifique la informacion e intente otra vez.");
                    break;
                }
        }
        return $ok;
    }

    public function cambiarContrasena(UsuarioDTO $usuario) {
        $ok = FALSE;
        $rta = $this->usuarioDAO->updatePassword($usuario);
        switch ($rta) {
            case 1: {
                    $this->contentMgr->setFormato(new Exito());
                    $this->contentMgr->setContenido("Tu contraseña fue cambiada correctamente");
                    $ok = TRUE;
                    break;
                }
            case 0: {
                    $this->contentMgr->setFormato(new Neutral());
                    $this->contentMgr->setContenido("No se detectaron cambios en tu contraseña");
                    $ok = TRUE;
                    break;
                }
            case -1: {
                    $this->contentMgr->setFormato(new Errado());
                    $this->contentMgr->setContenido("Hubo un error grave al intentar modificar tu contraseña. Por favor verifique la contraseña e intente otra vez.");
                    break;
                }
        }
        return $ok;
    }

    public function eliminar(EntityDTO $entidad) {
        $entidad instanceof UsuarioDTO;
        $ok = false;
        $rta = $this->usuarioDAO->update($entidad);
        switch ($rta) {
            case 1: {
                    $this->contentMgr->setFormato(new Exito());
                    $this->contentMgr->setContenido("El usuario " . $entidad->getIdUsuario() . " fue eliminado correctamente y de forma permanente del sistema");
                    $ok = true;
                    break;
                }
            case 0: {
                    $this->contentMgr->setFormato(new Neutral());
                    $this->contentMgr->setContenido("No se encontró un usuario con el id " . $entidad->getIdUsuario() . " . No se llevó a cabo una eliminacion.");
                    $ok = false;
                    break;
                }
            case -1: {
                    $this->contentMgr->setFormato(new Errado());
                    $this->contentMgr->setContenido("Hubo un error grave al intentar eliminar este usuario. Por favor verifique la informacion e intente otra vez.");
                    break;
                }
        }
        return $ok;
    }

    public function encontrar(EntityDTO $entidad) {
        $entidad instanceof UsuarioDTO;
        $userFinded = $this->usuarioDAO->find($entidad);
        if (!is_null($userFinded)) {
            $this->usuarioMQT->maquetaObject($userFinded);
        } else {
            $this->contentMgr->setFormato(new Neutral());
            $this->contentMgr->setContenido("No se han encontrado resultados.");
        }
        return $userFinded;
    }

    public function encontrarTodos() {
        $usuarios = $this->usuarioDAO->findAll();
        $this->usuarioMQT->maquetaArrayObject($usuarios);
        return $usuarios;
    }

    public function encontrarByEmail(UsuarioDTO $user) {
        $usuario = NULL;
        if (!is_null($this->usuarioDAO->findByEmail($user))) {
            $usuario = $this->usuarioDAO->findByEmail($user);
        }
        return $usuario;
    }

    public function mostrarCardUsuario() {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        if ($sesion->existe(Session::US_LOGED)) {
            $usuario = $sesion->getEntidad(Session::US_LOGED);
            $cuenta = $sesion->getEntidad(Session::CU_LOGED);
            $this->usuarioMQT->maquetaCardSesion($usuario, $cuenta);
        }
    }

    public function mostrarManagerLink() {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        if ($sesion->existe(Session::US_ADMIN_LOGED)) {
            $userMgr = $sesion->getEntidad(Session::CU_ADMIN_LOGED);
            $usName = Validador::fixTexto($userMgr->getPrimerNombre()) . " " . Validador::fixTexto($userMgr->getPrimerApellido());
            $this->usuarioMQT->maquetarManagerLink($usName);
        }
        if ($sesion->existe((Session::US_SUB_ADMIN_LOGED))) {
            $userMgr = $sesion->getEntidad(Session::CU_SUB_ADMIN_LOGED);
            $usName = Validador::fixTexto($userMgr->getPrimerNombre()) . " " . Validador::fixTexto($userMgr->getPrimerApellido());
            $this->usuarioMQT->maquetaSubManagerLink($usName);
        }
    }

    public function mostrarTablaCrudUsuarios($tablaUsuarios, $numFullUsers) {
        $numUsers = count($tablaUsuarios);
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $paginador = $sesion->getEntidad(Session::PAGINADOR);
        $paginador instanceof PaginadorMemoria;
        $pageActual = $paginador->getPaginaActual();
        $totalPages = $paginador->getNumeroPaginas();
        echo('
                 <div class="w3-row w3-col l4 m6 s12 w3-container w3-theme-light">
                        <h4><span class="w3-text-dark-gray">Registrados ' . $numFullUsers . ' Usuarios</span></h4>
                        <h5><span class="w3-text-dark-gray">Se muestran ' . $numUsers . ' Usuarios .  Página ' . $pageActual . ' de ' . $totalPages . '</span></h5>
                 </div>
        ');
        $this->usuarioMQT->maquetarCrudUsuarios($tablaUsuarios);
    }

    public function mostrarFormUpdate() {
        $modal = new ModalSimple();
        $cuentaDAO = new CuentaDAO();
        $userRequest = new UsuarioRequest();
        $userPost = $userRequest->getUsuarioDTO();
        $userPost instanceof UsuarioDTO;
        $userPost->setIdUsuario(CriptManager::urlVarDecript($userPost->getIdUsuario()));
        $userFinded = $this->usuarioDAO->find($userPost);
        $userFinded instanceof UsuarioDTO;
        $cuDTO = new CuentaDTO();
        $cuDTO->setUsuarioIdUsuario($userFinded->getIdUsuario());
        $cuentaFinded = $cuentaDAO->findByUsuario($cuDTO);
        if (!is_null($cuentaFinded) && !is_null($userFinded)) {
            $this->usuarioMQT->maquetarFormUpdateUsuario($userFinded, $cuentaFinded);
        } else {
            $modal->addError("El usuario a actualizar no posee una cuenta registrada.");
            $modal->setClosebtn("Aceptar");
            $modal->show();
        }
    }

    public function disableEnableUsuario(UsuarioDTO $user) {
        $modal = new ModalSimple();
        $userFinded = $this->usuarioDAO->find($user);
        $action = "";
        if (!is_null($userFinded)) {
            $userFinded instanceof UsuarioDTO;
            if ($userFinded->getEstado() == UsuarioDAO::EST_ACTIVO) {
                $userFinded->setEstado(UsuarioDAO::EST_INACTIVO);
                $action = "DESACTIVADO";
            } else if ($userFinded->getEstado() == UsuarioDAO::EST_INACTIVO) {
                $userFinded->setEstado(UsuarioDAO::EST_ACTIVO);
                $action = "ACTIVADO";
            }
            $rta = $this->usuarioDAO->putEstado($userFinded);
            switch ($rta) {
                case 1:
                    $error = new Exito();
                    $error->setValor("El usuario " . $userFinded->getIdUsuario() . " fue " . $action . " correctamente");
                    $modal->addElemento($error);
                    break;
                case 0:
                    $error = new Neutral();
                    $error->setValor("El usuario ya tenía el rol a cambiar");
                    $modal->addElemento($error);
                    break;
                case -1:
                    $error = new Errado();
                    $error->setValor("Error grave al cambiar el estado del usuario con id " . $user->getIdUsuario() . " .");
                    $modal->addElemento($error);
                    break;
            }
        } else {
            $error = new Errado();
            $error->setValor("No se encontró ningun usuario con id " . $user->getIdUsuario() . " .");
            $modal->addElemento($error);
        }
        $closeBtn = new CloseBtn();
        $closeBtn->setValor("Aceptar");
        $modal->addElemento($closeBtn);
        $modal->open();
        $modal->maquetar();
        $modal->close();
    }

    public function mostrarCrudPorRolYEstado(UsuarioDTO $userToFind) {
        if ((int) $userToFind->getRol() != 6) {
            $userToFind->setRol($this->formatRolUser((int) $userToFind->getRol()));
            if ($userToFind->getRol() == "NONE") {
                $err = new Errado();
                $err->setValor("Ese rol no es admitido !");
                echo($err->toString($err->getValor()));
            } else {
                try {
                    if (!is_null($this->usuarioDAO->findByRolAndEstado($userToFind))) {
                        $tablaUsuarios = $this->usuarioDAO->findByRolAndEstado($userToFind);
                        $numUsers = count($tablaUsuarios);
                        echo('
                 <div class="w3-row w3-col l4 m6 s12 w3-container w3-green">
                        <h5><span class="w3-text-dark-gray">Encontrados  ' . $numUsers . ' Usuarios </span></h5>
                 </div>
                 ');
                        $sesion = SimpleSession::getInstancia();
                        $sesion instanceof SimpleSession;
                        $pager = new PaginadorMemoria(10, 0, $tablaUsuarios);
                        $pager->init("usuario_paginacion.php", "USUARIOS_CRUD_ALL");
                        $pager->maquetarBarraPaginacion();
                        $this->usuarioMQT->maquetarCrudUsuarios($pager->firstPage());
                        $pager->maquetarBarraPaginacion();
                        $sesion->add(Session::PAGINADOR, $pager);
                    } else {
                        $err = new Neutral();
                        $err->setValor("No se encontraron usuarios con los parametros indicados");
                        echo($err->toString($err->getValor()));
                    }
                } catch (Exception $ex) {
                    echo("Un error ha ocurrido (" . $ex->getMessage() . ")");
                }
            }
        } else {
            $tablaUsuarios = $this->usuarioDAO->findAll();
            $tablaAll = array();
            switch ($userToFind->getEstado()) {
                case UsuarioDAO::EST_ACTIVO:
                    foreach ($tablaUsuarios as $us) {
                        $us instanceof UsuarioDTO;
                        if ($us->getEstado() == UsuarioDAO::EST_ACTIVO) {
                            $tablaAll[] = $us;
                        }
                    }
                    break;
                case UsuarioDAO::EST_INACTIVO:
                    foreach ($tablaUsuarios as $us) {
                        $us instanceof UsuarioDTO;
                        if ($us->getEstado() == UsuarioDAO::EST_INACTIVO) {
                            $tablaAll[] = $us;
                        }
                    }
                    break;
            }
            if (is_null($tablaAll) || count($tablaAll) == 0) {
                $err = new Neutral();
                $err->setValor("No se encontraron usuarios con los parametros indicados");
                echo($err->toString($err->getValor()));
            } else {
                $sesion = SimpleSession::getInstancia();
                $sesion instanceof SimpleSession;
                $pager = new PaginadorMemoria(10, 0, $tablaAll);
                $pager->init("usuario_paginacion.php", "USUARIOS_CRUD_ALL");
                $pager->maquetarBarraPaginacion();
                $this->usuarioMQT->maquetarCrudUsuarios($pager->firstPage());
                $pager->maquetarBarraPaginacion();
                $sesion->add(Session::PAGINADOR, $pager);
            }
        }
    }

    public function mostrarCrudPorNumeroDocumento(CuentaDTO $cuentaDTO) {
        $modal = new ModalSimple();
        $cuentaControl = CuentaController::getInstancia();
        $cuentaControl instanceof CuentaController;
        if (Validador::validaNumDoc($cuentaDTO->getNumDocumento())) {
            if (!is_null($cuentaControl->encontrarPorNumeroDocumento($cuentaDTO))) {
                $cuentaFinded = $cuentaControl->encontrarPorNumeroDocumento($cuentaDTO);
                $cuentaFinded instanceof CuentaDTO;
                $userDTOToFind = new UsuarioDTO();
                $userDTOToFind->setIdUsuario($cuentaFinded->getUsuarioIdUsuario());
                $userDTOFinded = $this->usuarioDAO->find($userDTOToFind);
                $tabla = array($userDTOFinded);
                $this->usuarioMQT->maquetarCrudUsuarios($tabla);
            } else {
                $neu = new Neutral();
                $neu->setValor("No se encontró ningun usuario bajo el numero de documento " . $cuentaDTO->getNumDocumento());
                $modal->addElemento($neu);

                $closeBtn = new CloseBtn();
                $closeBtn->setValor("Aceptar");
                $modal->addElemento($closeBtn);
                $modal->open();
                $modal->maquetar();
                $modal->close();
            }
        } else {
            $err = new Errado();
            $err->setValor("¡ El numero de documento no tiene el formato correcto !");
            $modal->addElemento($err);

            $closeBtn = new CloseBtn();
            $closeBtn->setValor("Aceptar");
            $modal->addElemento($closeBtn);
            $modal->open();
            $modal->maquetar();
            $modal->close();
        }
    }

    public function mostrarNavBarUser() {
        $this->usuarioMQT->maquetaLogedUserMenu();
    }

    public function mostrarCrudPorIdUsuario(UsuarioDTO $user) {
        $user->setIdUsuario(Validador::textoParaBuscar($user->getIdUsuario()));
        $tablaUsers = $this->usuarioDAO->findByIdLike($user);
        if (!is_null($tablaUsers) && count($tablaUsers) >= 1) {
            $this->usuarioMQT->maquetarCrudUsuarios($tablaUsers);
        } else {
            $neu = new Neutral();
            $neu->setValor("No se encontró ningun usuario con un id semejante a: " . $user->getIdUsuario());
            echo($neu->toString($neu->getValor()));
        }
    }

    public function mostrarNoLoginUser() {
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        if (!$sesion->existe(Session::US_LOGED)) {
            $this->usuarioMQT->maquetaNoLoginTobuy();
        }
    }

    public function enviarEmailAccountVerificacion(UsuarioDTO $user) {
        $ok = true;
        $cuentaDAO = CuentaDAO::getInstancia();
        $cuentaDAO instanceof CuentaDAO;
        $cueS = new CuentaDTO();
        $cueS->setUsuarioIdUsuario($user->getIdUsuario());
        $cuentaFinded = $cuentaDAO->findByUsuario($cueS);
        $idUserCrip = base64_encode($user->getIdUsuario());
        $estadoUserCrip = base64_encode($user->getEstado());
        $mailer = EmailManager::getInstancia();
        $mailer instanceof EmailManager;
        $mailer->setSubjet(EmailManager::SJ_ACC_ACT);
        $mailer->oneAddress($user->getEmail());
        $msgHtml = "";
        $link = "";
        if ($_SERVER["SERVER_NAME"] == "localhost") {
            $prt = "";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $prt = ":" . $_SERVER["SERVER_PORT"];
            }
            $link = $_SERVER["SERVER_NAME"] . $prt . "/PHP_RAPID_JACKETS/contenido/controlador/negocio/account_verify.php";
        } else {
            $link = $_SERVER["SERVER_NAME"] . "/contenido/controlador/negocio/account_verify.php";
        }
        $link .= ("?" . UsuarioRequest::us_id . "=" . $idUserCrip . "&" . UsuarioRequest::us_estado . "=" . $estadoUserCrip);
        if (is_readable("../../includes/mails/acc_verif_html_msg.html")) {
            $msgHtml = file_get_contents("../../includes/mails/acc_verif_html_msg.html");
            $msgHtml = str_replace("#LK#", $link, $msgHtml);
            $msgHtml = str_replace("#US#", ($cuentaFinded->getPrimerNombre() . " " . $cuentaFinded->getPrimerApellido()), $msgHtml);
        }

        $mailer->html($msgHtml);
        if (!$mailer->enviar()) {
            $ok = false;
        }
        return $ok;
    }

    public function createUpdateCuentaRescue(UsuarioDTO $userToRescue) {
        $rta = 0;
        $dater = new DateManager();
        $cuenRes = null;
        $cuenRes = new CuentaRescueDTO();
        $cuenRes->setUsuarioIdUsuario($userToRescue->getIdUsuario());
        $cuenRes->setEstado(CuentaRescueDAO::EST_LP);
        $cuenRes->setCodigo(CriptManager::generateRandomText(10));
        $cuenRes->setLastRecover($dater->formatNowDate(DateManager::SQL_DATETIME));
        $cuenRes->setToken($this->generateAccRecoveryToken($cuenRes));
        //Validar que si ya existe un registro, este se acuralize
        $cuentaFinded = $this->cuentaRescueDAO->find($cuenRes);
        if (is_null($cuentaFinded)) {
            $rta = $this->cuentaRescueDAO->insert2($cuenRes);
        } else {
            $rta = $this->cuentaRescueDAO->update($cuenRes);
        }
        if ($rta == 1) {
            return $cuenRes;
        } else {
            return null;
        }
    }

    public function usuarioInPassRecovery(UsuarioDTO $userChk) {
        $curesDTO = new CuentaRescueDTO();
        $curesDTO->setUsuarioIdUsuario($userChk->getIdUsuario());
        $curesRTA = $this->cuentaRescueDAO->find($curesDTO);
        if (is_null($curesRTA)) {
            return FALSE;
        } else {
            $curesRTA instanceof CuentaRescueDTO;
            if ($curesRTA->getEstado() == CuentaRescueDAO::EST_LP) {
                return TRUE;
            }
            return FALSE;
        }
    }

    public function validarLinkAccountRecovery(CuentaRescueDTO $cuentaRescue) {
        $ok = true;
        $okParams = true;
        $modal = new ModalSimple();
        $cripter = CriptManager::getInstacia();
        $cripter instanceof CriptManager;
        $cuentaRescue->setUsuarioIdUsuario(CriptManager::urlVarDecript($cuentaRescue->getUsuarioIdUsuario()));
        $cuentaRescueDB = $this->cuentaRescueDAO->find($cuentaRescue);
        $cuentaRescueDB instanceof CuentaRescueDTO;
        if (is_null($cuentaRescueDB)) {
            $ok = FALSE;
            $err = new Errado();
            $err->setValor("La url requerida para acceder ha sido alterada. Imposible accder al módulo");
            $modal->addElemento($err);
        } else {
            $userDTO = new UsuarioDTO();
            $userDTO->setIdUsuario($cuentaRescueDB->getUsuarioIdUsuario());
            $userFinded = $this->usuarioDAO->find($userDTO);
            if (!$this->usuarioInPassRecovery($userFinded)) {
                //Validar que no se pueda llevar a cabo el proceso mas de una vez mediante este enlace
                $ok = FALSE;
                $err = new Errado();
                $err->setValor("La cuenta que se intenta recuperar ya no está disponible para esta operación");
                $modal->addElemento($err);
            } else {
                //Descifrar el token y separarlo en sus cuatro componentes
                $tokenObtenido = $cuentaRescue->getToken();
                if (is_null($tokenObtenido) || $tokenObtenido !== $cuentaRescueDB->getToken()) {
                    $okParams = FALSE;
                    $ok = FALSE;
                } else {
                    $tokenObtenido = $cripter->AES_Decript($cuentaRescue->getToken(), $cuentaRescueDB->getCodigo());
                    $arrayToken = explode("|", $tokenObtenido);
                    $userIdToken = $arrayToken[0];
                    $estadoToken = $arrayToken[1];
                    $codigoToken = $arrayToken[2];
                    $utcToken = $arrayToken[3];
                    //Validar el id de usuario.
                    if ($cuentaRescueDB->getUsuarioIdUsuario() !== $userIdToken) {
                        $ok = FALSE;
                        $okParams = FALSE;
                    }
                    //Validar el token recibido por url
                    if ($cuentaRescueDB->getToken() !== $cuentaRescue->getToken()) {
                        $ok = FALSE;
                        $okParams = FALSE;
                    }
                    //Validar estado contenido en el token
                    if ($cuentaRescueDB->getEstado() !== $estadoToken || ($estadoToken !== CuentaRescueDAO::EST_LP)) {
                        $ok = FALSE;
                        $okParams = FALSE;
                    }
                    //Validar el coodigo del token
                    if ($codigoToken !== $cuentaRescueDB->getCodigo()) {
                        $ok = FALSE;
                        $okParams = FALSE;
                    }
                    //Validar la fecha del token y comprobar que no haya superado el tiempo permitido para acceder.
                    $dater = new DateManager();
                    $fechaActual = $dater->getDate();
                    $fechaInToken = $dater->unixToDate($utcToken);
                    if (is_null($fechaInToken)) {
                        $okParams = FALSE;
                        $ok = FALSE;
                    } else {
                        $fechaTokenPlusDay = $dater->agregar($fechaInToken, "1 day");
                        if ($fechaActual >= $fechaTokenPlusDay) {
                            $ok = FALSE;
                            $err = new Errado();
                            $err->setValor("El tiempo máximo permitido para acceder a cambiar tu contraseña ha expirado");
                            $modal->addElemento($err);
                            //Actualizar cuentaRescu para permitir otro intento de envio de correo de restauracion
                            $cuentaRescueDB->setEstado(CuentaRescueDAO::EST_AT);
                            $this->cuentaRescueDAO->update($cuentaRescueDB);
                        }
                    }
                }
            }
        }
        if ($okParams == FALSE) {
            $ok = FALSE;
            $err = new Errado();
            $err->setValor("Los parametros de la url para acceder han sido alterados. Imposible acceder al módulo");
            $modal->addElemento($err);
        }
        if ($ok == FALSE) {
            $sesion = new SimpleSession();
            $acceso = new AccesoPagina();
            $modal->setClosebtn("Cerrar");
            $sesion->add(Session::NEGOCIO_RTA, $modal);
            $acceso->irPagina(AccesoPagina::INICIO);
        }
    }

    public function accountRecoveryEnvioEmail(UsuarioDTO $user) {
        $ok = true;
        $modal = new ModalSimple();
        if (!Validador::validaUserName($user->getIdUsuario())) {
            $ok = false;
            $err = new Errado();
            $err->setValor("El id del usuario no cumple con los parámetros. Verifique e intente de nuevo.");
            $modal->addElemento($err);
        }
        if (!Validador::validaEmail($user->getEmail())) {
            $ok = false;
            $err = new Errado();
            $err->setValor("El correo electrónico digitado no se reconoce como un email válido. Verifique e intente de nuevo.");
            $modal->addElemento($err);
        }
        if ($ok) {
            $userFinded = $this->usuarioDAO->find($user);
            if (!is_null($userFinded)) {
                $userFinded instanceof UsuarioDTO;
                if ($this->usuarioInPassRecovery($userFinded)) {
                    $ok = false;
                    $err = new Errado();
                    $err->setValor("Este usuario actualmente ya está en proceso de recuperación de contraseña");
                    $modal->addElemento($err);
                } else {
                    if ($userFinded->getEmail() != $user->getEmail()) {
                        $err = new Errado();
                        $err->setValor("El correo digitado no es el mismo que está registrado para el usuario (" . Validador::fixTexto($userFinded->getIdUsuario()) . ")");
                        $modal->addElemento($err);
                    } else {
                        //Añadir el nuevo registro en la tabla cuentaRescue
                        $cueRetorned = $this->createUpdateCuentaRescue($userFinded);
                        if ($cueRetorned instanceof CuentaRescueDTO) {
                            //All legar a este punto se ha de enviar el correo electronico de recuperacion
                            if ($this->enviarEmailAccountRecovery($cueRetorned, $userFinded)) {
                                $exit = new Exito();
                                $exit->setValor("Se ha enviado un email para que puedas acceder a cambiar tu contraseña. Ve y revisa tu buzón de entrada o tu buzón de spam.");
                                $modal->addElemento($exit);
                                //Añadir a sesion el usuario que está en proceso de recuperacion de cuenta
                                $sesion = SimpleSession::getInstancia();
                                $sesion instanceof SimpleSession;
                                $user->setIdUsuario(CriptManager::urlVarEncript($userFinded->getIdUsuario()));
                                $user->setEmail(CriptManager::urlVarEncript($userFinded->getEmail()));
                                $sesion->addEntidad($user, Session::USER_RESCUE);
                            } else {
                                $err = new Errado();
                                $err->setValor("Hubo un error grave al enviarte un correo . Verifica que tu email sea válido.");
                                $modal->addElemento($err);
                            }
                        } else {
                            $err = new Errado();
                            $err->setValor("Hubo un error grave. Intente de nuevo o  contacte al administrador");
                            $modal->addElemento($err);
                        }
                    }
                }
            } else {
                $err = new Errado();
                $err->setValor("El usuario (" . Validador::fixTexto($user->getIdUsuario()) . ") no está registrado en el este sistema.");
                $modal->addElemento($err);
            }
        } else {
            $err = new Errado();
            $err->setValor("No hemos podido hacer nada para recuperar tu cuenta. Los sentimos :(");
            $modal->addElemento($err);
        }
        $modal->setClosebtn("Aceptar");
        $modal->open();
        $modal->maquetar();
        $modal->close();
        return $ok;
    }

    public function enviarEmailAccountRecovery(CuentaRescueDTO $cuentaRescue, UsuarioDTO $userToRescue) {
        $ok = true;
        $codigoMsg = $cuentaRescue->getCodigo();
        $token = $cuentaRescue->getToken();
        $userIDUrl = CriptManager::urlVarEncript($userToRescue->getIdUsuario());
        $userIDUrl = base64_encode($userIDUrl);
        $msgHtml = "";
        $link = "";
        $cuDAO = new CuentaDAO();
        $cuDto = new CuentaDTO();
        $cuDto->setUsuarioIdUsuario($userToRescue->getIdUsuario());
        $cuentaFinded = $cuDAO->findByUsuario($cuDto);
        $cuentaFinded instanceof CuentaDTO;
        if ($_SERVER["SERVER_NAME"] == "localhost") {
            $prt = "";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $prt = ":" . $_SERVER["SERVER_PORT"];
            }
            $link = $_SERVER["SERVER_NAME"] . $prt . "/PHP_RAPID_JACKETS/contenido/";
        } else {
            $link = $_SERVER["SERVER_NAME"] . "/contenido/";
        }
        //Crear las variables a enviar por url
        $link .= ("cambiar_password.php?token=" . $token . "&" . UsuarioRequest::us_id . "=" . $userIDUrl);

        if (is_readable("../../includes/mails/acc_rescue_html_msg.html")) {
            $msgHtml = file_get_contents("../../includes/mails/acc_rescue_html_msg.html");
            $msgHtml = str_replace("#LK#", $link, $msgHtml);
            $msgHtml = str_replace("#US#", ($cuentaFinded->getPrimerNombre() . " " . $cuentaFinded->getPrimerApellido()), $msgHtml);
            $msgHtml = str_replace("#CD#", $codigoMsg, $msgHtml);
        }
        $emailMg = EmailManager::getInstancia();
        $emailMg instanceof EmailManager;
        $emailMg->setSubjet(EmailManager::SJ_PASS_RE);
        $emailMg->oneAddress($userToRescue->getEmail());
        $emailMg->html($msgHtml);

        if ($emailMg->enviar()) {
            $ok = true;
        } else {
            $ok = false;
        }
        return $ok;
    }

    public function validarCodigoAccountRescue(CuentaRescueDTO $accRescue) {
        $ok = TRUE;
        $modalRTA = new ModalSimple();
        $accRescueDB = $this->cuentaRescueDAO->find($accRescue);
        if (!Validador::validaText($accRescue->getCodigo(), 10, 10)) {
            $ok = FALSE;
            $err = new Errado();
            $err->setValor("El código ingresado debe tener 10 caracteres exactamente");
            $modalRTA->addElemento($err);
        }
        if (!is_null($accRescueDB)) {
            if ($accRescue->getCodigo() == $accRescueDB->getCodigo()) {
                $ok = TRUE;
            } else {
                $ok = FALSE;
                $err = new Errado();
                $err->setValor("El código ingresado no corresponde con el código que se ha enviado a tu correo electrónico");
                $modalRTA->addElemento($err);
            }
        } else {
            $ok = FALSE;
        }
        if ($ok == FALSE) {
            $modalRTA->open();
            $modalRTA->maquetar();
            echo(' <div class="w3-panel w3-blue-gray">
                    <h4>El proceso no se pudo completar.</h4>
                    <p><button class="w3-btn w3-theme-dark" onclick="window.location.reload()">Intentar de nuevo</button></p>
                </div>');
            $modalRTA->close();
        }
        return $ok;
    }

    public function accountRescueConsolidar(UsuarioDTO $usuarioPost, $passwordB) {
        $ok = TRUE;
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $cripter = new CriptManager();
        $modal = new ModalSimple();
        $idUser = $usuarioPost->getIdUsuario();
        $idUser = base64_decode($idUser);
        $idUser = CriptManager::urlVarDecript($idUser);
        $usuarioPost->setIdUsuario($idUser);
        if (!Validador::validaPassword($usuarioPost->getPassword())) {
            $ok = FALSE;
            $err = new Errado();
            $err->setValor("La contraseña 1 ingresada no tiene el formato correcto.");
            $modal->addElemento($err);
        }
        if (!Validador::validaPassword($passwordB)) {
            $ok = FALSE;
            $err = new Errado();
            $err->setValor("La contraseña 2 ingresada no tiene el formato correcto.");
            $modal->addElemento($err);
        }
        if ($passwordB !== $usuarioPost->getPassword()) {
            $ok = FALSE;
            $err = new Errado();
            $err->setValor("Las contraseñas no coinciden.");
            $modal->addElemento($err);
        }
        if (!$this->usuarioInPassRecovery($usuarioPost)) {
            $ok = FALSE;
            $err = new Errado();
            $err->setValor("Este usuario no tiene permisos para cambiar su contraseña.");
            $modal->addElemento($err);
        }

        if ($ok) {
            $newPassword = $cripter->complexEncriptDF($usuarioPost->getPassword());
            $userInDB = $this->usuarioDAO->find($usuarioPost);
            $userInDB->setPassword($newPassword);
            $rta = $this->usuarioDAO->updatePassword($userInDB);
            if ($rta == 1 || $rta == 0) {
                $dater = new DateManager();
                $fechaStrNow = $dater->formatNowDate(DateManager::SQL_DATETIME);
                $cueResDTO = new CuentaRescueDTO();
                $cueResDTO->setUsuarioIdUsuario($userInDB->getIdUsuario());
                $cuentaRescueDB = $this->cuentaRescueDAO->find($cueResDTO);
                $cuentaRescueDB instanceof CuentaRescueDTO;
                $cuentaRescueDB->setEstado(CuentaRescueDAO::EST_RP);
                $cuentaRescueDB->setLastRecover($fechaStrNow);
                $this->cuentaRescueDAO->update($cuentaRescueDB);
                $sesion->removeEntidad(Session::USER_RESCUE);
                //_--
                $ex = new Exito();
                $ex->setValor("Tu contraseña ha sido cambiada correctamente. Ya puedes iniciar sesión");
                $modal->addElemento($ex);
            }
        }
        $modal->setClosebtn("Cerrar");

        $sesion->add(Session::NEGOCIO_RTA, $modal);
        $acceso = AccesoPagina::getInstacia();
        $acceso instanceof AccesoPagina;
        $acceso->irPagina(AccesoPagina::NEG_TO_IN_SESION);
    }

    public function activarCuentaUsuario(UsuarioDTO $userAct) {
        $modalRTA = new ModalSimple();
        $ok = true;
        $crip = new CriptManager();
        $dater = new DateManager();
        $nowDate = $dater->getDate();
        $nowDate instanceof DateTime;
        $userFinded = $this->usuarioDAO->find($userAct);
        if (is_null($userFinded)) {
            $ok = false;
            $err = new Errado();
            $err->setValor("Información requerida no fue encontrada");
            $modalRTA->addElemento($err);
        } else {
            $userFinded instanceof UsuarioDTO;
            //Valida exactitud de la cadena encriptada
            $cadenaNoAes = $crip->AES_Decript($userAct->getEstado(), UsuarioDAO::EST_NO_VALID);
            $arrayCadena = explode("|", $cadenaNoAes);
            $fechaInCadena = $dater->unixToDate($arrayCadena[2]);
            $fechaMasUnDia = $dater->agregar($fechaInCadena, "1 day");
            $fechaMasUnDia instanceof DateTime;
            //Validar que el usuario ya ha sido activado.
            if ($this->usuarioIsNotVerified($userFinded)) {
                if ($userAct->getEstado() !== $userFinded->getEstado()) {
                    $ok = false;
                    $err = new Errado();
                    $err->setValor("Los parametros del enlace están alterados o dañados");
                    $modalRTA->addElemento($err);
                }
                if ($arrayCadena[0] == $userFinded->getIdUsuario() && $arrayCadena[1] == UsuarioDAO::EST_NO_VALID) {
                    $ok = true;
                } else {
                    $ok = false;
                    $err = new Errado();
                    $err->setValor("Los parametros del enlace están alterados o dañados");
                    $modalRTA->addElemento($err);
                }
                if ($nowDate >= $fechaMasUnDia) {
                    $ok = false;
                    $err = new Errado();
                    $err->setValor("El plazo para hacer la activación se ha vencido. Ahora tu cuenta ha sido borrada. ¡Lo sentimos! :(");
                    $modalRTA->addElemento($err);
                    $this->borrarCuentaCompleta($userFinded);
                }
            } else {
                $ok = false;
                $err = new Errado();
                $err->setValor("Esta cuenta no necesita ser activada. Pues ya lo está.");
                $modalRTA->addElemento($err);
            }
        }
        if ($ok) {
            $userFinded->setEstado(UsuarioDAO::EST_ACTIVO);
            $upRta = $this->usuarioDAO->putEstado($userFinded);
            if ($upRta == 1) {
                $err = new Exito();
                $err->setValor("Tu cuenta ha sido activada correctamente. Ya puedes iniciar sesión.");
                $modalRTA->addElemento($err);
            } else {
                $err = new Errado();
                $err->setValor("Hubo un error grave al activar tu cuenta. Lo sentimos :(");
                $modalRTA->addElemento($err);
            }
        } else {
            $err = new Errado();
            $err->setValor("La operacion no fue exitosa. Lo sentimos");
            $modalRTA->addElemento($err);
        }
        $modalRTA->setClosebtn("Aceptar");
        return $modalRTA;
    }

    private function borrarCuentaCompleta(UsuarioDTO $usDelete) {
        $cuDAO = new CuentaDAO();
        $cudto = new CuentaDTO();
        $cudto->setUsuarioIdUsuario($usDelete->getIdUsuario());
        $cutodel = $cuDAO->findByUsuario($cudto);
        $rta1 = $cuDAO->delete($cutodel);
        $rta2 = $this->usuarioDAO->delete($usDelete);
        if ($rta1 == 1 && $rta2 == 1) {
            return true;
        }
        return false;
    }

    public function generateEstadoEncriptado(UsuarioDTO $user) {
        $cripter = CriptManager::getInstacia();
        $dater = new DateManager();
        $fechaS = $dater->formatNowDate(DateManager::UTC);
        $cripter instanceof CriptManager;
        $estadoA = $user->getIdUsuario() . "|" . UsuarioDAO::EST_NO_VALID . "|" . $fechaS;
        $estadoC = $cripter->AES_Encript($estadoA, UsuarioDAO::EST_NO_VALID);
        return $estadoC;
    }

    public function generateAccRecoveryToken(CuentaRescueDTO $cuentaRescue) {
        $cripter = CriptManager::getInstacia();
        $dater = new DateManager();
        $fechaS = $dater->formatNowDate(DateManager::UTC);
        $cripter instanceof CriptManager;
        $tokenA = $cuentaRescue->getUsuarioIdUsuario() . "|" . CuentaRescueDAO::EST_LP . "|" . $cuentaRescue->getCodigo() . "|" . $fechaS;
        $token = $cripter->AES_Encript($tokenA, $cuentaRescue->getCodigo());
        return $token;
    }

    public function validaManagerLogin(UsuarioDTO $user) {
        $ok = FALSE;
        if ($user->getRol() == UsuarioDAO::ROL_MAIN_ADMIN) {
            $ok = TRUE;
        }
        return $ok;
    }

    public function validaSubManagerLogin(UsuarioDTO $user) {
        $ok = FALSE;
        if ($user->getRol() == UsuarioDAO::ROL_SUB_ADMIN) {
            $ok = TRUE;
        }
        return $ok;
    }

}
