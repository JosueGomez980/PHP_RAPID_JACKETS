<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioController
 *
 * @author Josué Francisco
 */
include_once 'cargar_clases3.php';

AutoCarga3::init();

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
    public static $instance;

    public function __construct() {
        $this->usuarioDAO = UsuarioDAO::getInstancia();
        $this->usuarioDAO instanceof UsuarioDAO;
        $this->contentMgr = ContentManager::getInstancia();
        $this->usuarioMQT = new UsuarioMaquetador();
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
        if ((strlen($user->getEstado()) == 60) && (password_get_info($user->getEstado())["algoName"] == "bcrypt")) {
            return true;
        }
        return false;
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
        $this->usuarioMQT->maquetarFormUpdateUsuario($userFinded, $cuentaFinded);
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
        $mailer = EmailManager::getInstancia();
        $mailer instanceof EmailManager;
        $msg = "Bienvenido a Rapid Jackets - Verificar cuenta";
        $mailer->setSubjet(EmailManager::SJ_ACC_ACT);
        $mailer->oneAddress($user->getEmail());
        $mailer->setContenido(Validador::fixTexto($msg));
        if (!$mailer->enviar()) {
            $ok = false;
        }
        return $ok;
    }

    public function generateEstadoEncriptado(UsuarioDTO $user) {
        $cripter = CriptManager::getInstacia();
        $cripter instanceof CriptManager;
        $estadoA = $user->getIdUsuario() . UsuarioDAO::EST_NO_VALID;
        $estadoB = CriptManager::urlVarEncript($estadoA);
        $estadoC = $cripter->simpleEncriptDF($estadoB);
        return $estadoC;
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
