<?php

include_once 'cargar_clases3.php';
AutoCarga3::init();

class ControlVistas {

    private $sesion;
    private $modal;
    private $rutaInc;
    private $btnClose;
    private $controlAcceso;

    const rutaBase = "../negocio/vistas/";

    public function __construct($rutaInc) {
        $this->rutaInc = $rutaInc;
        $this->controlAcceso = new AccesoPagina();
        $this->sesion = SimpleSession::getInstancia();
        $this->sesion instanceof SimpleSession;
        $this->modal = new ModalSimple();
        $this->btnClose = new CloseBtn();
    }

    public function defecto() {
        $this->modal->open();
        echo('
            <div class="alert alert-warning">
                <strong>Advertencia </strong<br> No se pudo cargar el contenido solicitado.
            </div>
        ');

        $this->btnClose->setValor("Cerrar");
        $this->modal->addElemento($this->btnClose);
        $this->modal->maquetar();
        $this->modal->close();
    }

    public function mostrarSimple() {
        require_once $this->rutaInc;
    }

    public function mostrarAjax() {
        $this->modal->open();
        $this->btnClose->setValor("Cerrar");
        $this->modal->addElemento($this->btnClose);
        require_once $this->rutaInc;
        $this->modal->maquetar();
        $this->modal->close();
    }

    public function vista_usuario_registrar() {
        $this->modal->open();
        $this->btnClose->setValor("Cerrar");
        $this->modal->addElemento($this->btnClose);
        require_once $this->rutaInc;
        $this->modal->maquetar();
        $this->modal->close();
    }

    public function get_tabla_paginada_memoria() {

        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;

        $acceso = AccesoPagina::getInstacia();
        $acceso instanceof AccesoPagina;
        $acceso->comprobarSesionAdmin(AccesoPagina::INICIO);

        $tablaPaginada = NULL;
//Validar que se ha enviado el formulario
        if (!isset($_GET["page"])) {
            $acceso->irPagina(AccesoPagina::NEG_TO_ADM_PN_GST_PRO);
        }
//Validar que la instancia del paginador esté cargada en memoria
        if (!$sesion->existe(Session::PAGINADOR)) {
            $acceso->irPagina(AccesoPagina::NEG_TO_ADM_PN_GST_PRO);
        }

        $paginaRequest = filter_input(INPUT_GET, "page");

        $paginador = $sesion->getEntidad(Session::PAGINADOR);
        $paginador instanceof PaginadorMemoria;

        if (Validador::validaInteger($paginaRequest)) {
            $paginaRequest = (int) $paginaRequest;
            if ($paginaRequest <= $paginador->getNumeroPaginas()) {
                $tablaPaginada = $paginador->getPage($paginaRequest);
            } else {
                $tablaPaginada = $paginador->getTablaActual();
            }
        } else {
            switch ($paginaRequest) {
                case "NEXT":
                    $tablaPaginada = $paginador->nextPage();
                    break;
                case "PREV":
                    $tablaPaginada = $paginador->prevPage();
                    break;
                case "LAST":
                    $tablaPaginada = $paginador->lastPage();
                    break;
                case "FIRST":
                    $tablaPaginada = $paginador->firstPage();
                    break;
                default :
                    $tablaPaginada = $paginador->getTablaActual();
                    break;
            }
        }
        $sesion->add(Session::PAGINADOR, $paginador);
        return $tablaPaginada;
    }

    public function vista_usuario_modificar() {
        $usuarioControl = new UsuarioController();
        $usuarioControl->mostrarFormUpdate();
    }

    public function vista_usuario_disable_enable() {
        $usuarioControl = new UsuarioController();
        $userRequest = new UsuarioRequest();
        $userPost = $userRequest->getUsuarioDTO();
        $userPost instanceof UsuarioDTO;
        $userPost->setIdUsuario(CriptManager::urlVarDecript($userPost->getIdUsuario()));
        $usuarioControl->disableEnableUsuario($userPost);
    }

    public function vista_usuario_find_by_rol_and_est() {
        $usuarioControl = new UsuarioController();
        $userRequest = new UsuarioRequest();
        $userPost = $userRequest->getUsuarioDTO();
        $userPost instanceof UsuarioDTO;
        $usuarioControl->mostrarCrudPorRolYEstado($userPost);
    }

    public function vista_usuario_find_by_num_doc() {
        $userControl = new UsuarioController();
        $cuentaControl = new CuentaController();
        $cuetaRequest = new CuentaRequest();
        $cuentaDTO = $cuetaRequest->getCuentaDTO();
        $userControl->mostrarCrudPorNumeroDocumento($cuentaDTO);
    }

    public function vista_usuario_find_by_id_like() {
        $userControl = new UsuarioController();
        $userRequest = new UsuarioRequest;
        $userDTO = $userRequest->getUsuarioDTO();
        $userControl->mostrarCrudPorIdUsuario($userDTO);
    }

    public function vista_productos_ver_por_nombre_like() {
        $productoControl = new ProductoController();
        $proReques = new ProductoRequest();
        $proDTO = $proReques->getProductoDTO();
        $productoControl->listarPorNombreLike($proDTO);
    }

    public function vista_productos_ver_por_nombre_like_admin() {
        $productoControl = new ProductoController();
        $proReques = new ProductoRequest();
        $proDTO = $proReques->getProductoDTO();
        $productoControl->listarPorNombreLikeAdmin($proDTO);
    }

    public function vista_productos_ver_por_nombre_like_admin_inv() {
        $productoControl = new ProductoController();
        $proReques = new ProductoRequest();
        $proDTO = $proReques->getProductoDTO();
        $productoControl->listarPorNombreLikeAdminInv($proDTO);
    }

    public function vista_inventario_ver_nuevo() {
        $inventarioControl = InventarioController::getInstancia();
        $inventarioControl instanceof InventarioController;
        $productoControl = new ProductoController();
        $proReques = new ProductoRequest();
        $proDTO = $proReques->getProductoDTO();
        $inventarioControl->mostrarFormularioNuevoInv($proDTO);
    }

    public function gestion_domicilo_usuario() {
        //Control de acceso a la funcion
        $this->controlAcceso->comprobarSesion(AccesoPagina::NEG_TO_INICIO);
        $this->controlAcceso->validaEnviode("envio", AccesoPagina::NEG_TO_PER_DATA);
        //Crear controlador y obtener la cuenta de sesion
        $cuentaControl = CuentaController::getInstancia();
        $cuentaControl instanceof CuentaController;
        $cuentaSesion = $this->sesion->getEntidad(Session::CU_LOGED);
        $cuentaSesion instanceof CuentaDTO;

        $domiNuevo = new DomicilioCuentaDTO();
        $domiNuevo->setCuentaNumDocumento($cuentaSesion->getNumDocumento());
        $domiNuevo->setCuentaTipoDocumento($cuentaSesion->getTipoDocumento());
        $domiNuevo->setDireccion(filter_input(INPUT_POST, "domi_direccion"));
        $domiNuevo->setBarrio(filter_input(INPUT_POST, "domi_barrio"));
        $domiNuevo->setLocalidad(filter_input(INPUT_POST, "domi_localidad"));
        $domiNuevo->setTelefono(filter_input(INPUT_POST, "domi_telefono"), FILTER_SANITIZE_NUMBER_INT);
        $domiNuevo->setCorreoPostal(filter_input(INPUT_POST, "domi_correo_postal"));
        //Determinar si la operacion es un insert o un update
        if (is_null($cuentaControl->encontrarDomicilioporCuenta($cuentaSesion))) {
            $cuentaControl->insertarDomicilioCuenta($domiNuevo);
        } else {
            $modal = $cuentaControl->modificarDomicilioCuenta($domiNuevo);
            $sesion = SimpleSession::getInstancia();
            $sesion instanceof SimpleSession;
            $sesion->add(Session::NEGOCIO_RTA, $modal);
            $acceso = AccesoPagina::getInstacia();
            $acceso instanceof AccesoPagina;
            $acceso->irPagina(AccesoPagina::NEG_TO_PER_DATA);
        }
    }

    public function producto_busqueda_avanzada_user() {
        $productoControl = ProductoController::getInstancia();
        $productoControl instanceof ProductoController;
        $proRequest = new ProductoRequest();
        $productoPost = $proRequest->getProductoDTO();
        $productoPost instanceof ProductoDTO;
        $productoPost->setCategoriaIdCategoria(CriptManager::urlVarDecript(filter_input(INPUT_POST, ProductoRequest::pro_id_cat)));
        $rangoPrecio = array();
        $rangoPrecio["MAX"] = filter_input(INPUT_POST, "producto_max_price", FILTER_SANITIZE_NUMBER_INT);
        $rangoPrecio["MIN"] = filter_input(INPUT_POST, "producto_min_price", FILTER_SANITIZE_NUMBER_INT);
        $productoControl->encontrarPorBusquedaAvanzadaByUser($productoPost, $rangoPrecio);
    }

    public function producto_busqueda_avanzada_admin() {
        $productoControl = ProductoController::getInstancia();
        $productoControl instanceof ProductoController;
        $proRequest = new ProductoRequest();
        $productoPost = $proRequest->getProductoDTO();
        $productoPost instanceof ProductoDTO;
        $productoPost->setCategoriaIdCategoria(CriptManager::urlVarDecript(filter_input(INPUT_POST, ProductoRequest::pro_id_cat)));
        $rangoPrecio = array();
        $rangoPrecio["MAX"] = filter_input(INPUT_POST, "producto_max_price", FILTER_SANITIZE_NUMBER_INT);
        $rangoPrecio["MIN"] = filter_input(INPUT_POST, "producto_min_price", FILTER_SANITIZE_NUMBER_INT);
        $productoControl->encontrarPorBusquedaAvanzadaByAdmin($productoPost, $rangoPrecio);
    }

    public function producto_busqueda_avanzada_admin_inv() {
        $productoControl = ProductoController::getInstancia();
        $productoControl instanceof ProductoController;
        $proRequest = new ProductoRequest();
        $productoPost = $proRequest->getProductoDTO();
        $productoPost instanceof ProductoDTO;
        $productoPost->setCategoriaIdCategoria(CriptManager::urlVarDecript(filter_input(INPUT_POST, ProductoRequest::pro_id_cat)));
        $rangoPrecio = array();
        $rangoPrecio["MAX"] = filter_input(INPUT_POST, "producto_max_price", FILTER_SANITIZE_NUMBER_INT);
        $rangoPrecio["MIN"] = filter_input(INPUT_POST, "producto_min_price", FILTER_SANITIZE_NUMBER_INT);
        $productoControl->encontrarPorBusquedaAvanzadaByAdminInventario($productoPost, $rangoPrecio);
    }

    public function password_recovery_part_a() {
        $modal = null;
        $userControl = UsuarioController::getInstancia();
        $userControl instanceof UsuarioController;
        $userRequest = new UsuarioRequest();
        $userDTO = $userRequest->getUsuarioDTO();
        $userControl->accountRecoveryEnvioEmail($userDTO);
    }

    public function password_recovery_part_b() {
        $userControl = new UsuarioController();
        $userMQT = new UsuarioMaquetador();
        $userDAO = UsuarioDAO::getInstancia();
        $userDAO instanceof UsuarioDAO;
        $cuentaRescueCode = new CuentaRescueDTO();
        $cuentaRescueCode->setCodigo(filter_input(INPUT_POST, "codigo"));
        $userIdCripted = filter_input(INPUT_POST, UsuarioRequest::us_id);
        $userIdValue = base64_decode((filter_input(INPUT_POST, UsuarioRequest::us_id)));
        $userIdValue = CriptManager::urlVarDecript($userIdValue);
        $cuentaRescueCode->setUsuarioIdUsuario($userIdValue);

        if ($userControl->validarCodigoAccountRescue($cuentaRescueCode)) {
            $userMQT->maquetaFormAccoutRecoveryChangePassword($userIdCripted);
        }
    }

    public function password_recovery_part_final() {
        $acceso = new AccesoPagina();
        $userControl = new UsuarioController();

        $acceso->validaEnviode(UsuarioRequest::us_id, AccesoPagina::NEG_TO_IN_SESION);
        $acceso->validaEnviode(UsuarioRequest::us_pass, AccesoPagina::NEG_TO_IN_SESION);

        $userRequest = new UsuarioRequest();
        $userDTOPost = $userRequest->getUsuarioDTO();
        $userDTOPost instanceof UsuarioDTO;
        $passwordB = filter_input(INPUT_POST, "user_passwordB");

        $userControl->accountRescueConsolidar($userDTOPost, $passwordB);
    }

    public function find_pedidos_por_fecha_predefinida() {
        if (isset($_POST["method_date"])) {
            $metodoFecha = filter_input(INPUT_POST, "method_date");
            $facturaController = new FacturaController();
            $facturaController->mostrarCrudPedidosPorFechaPredefinida($metodoFecha);
        } else {
            $err = new Neutral();
            echo($err->toString("No se recibió el parámetro necesario para ejecutar la acción"));
        }
    }
    
    public function acciones_rapidas_pedido(){
        
    }
    public function eliminar_pedido_admin(){
        $facturaManager = new FacturaController();
        $this->controlAcceso->comprobarSesionAdmin(AccesoPagina::NEG_TO_INICIO);
        $this->controlAcceso->validaEnviode(FacturaRequest::fac_id, AccesoPagina::NEG_PED_GES);
        $this->controlAcceso->validaEnviode("operacion", AccesoPagina::NEG_PED_GES);
        
    }

}

if (isset($_REQUEST['m'])) {
    $method = $_REQUEST['m'];
    $rutaFinal = ControlVistas::rutaBase . $method . ".php";
    $obj = new ControlVistas($rutaFinal);
    if (method_exists($obj, $method)) {
        call_user_func(array($obj, $method));
    } else {
        echo("¡El metodo solicitado no existe!");
    }
} else {
    $method = "defecto";
    $rutaFinal = ControlVistas::rutaBase . $method . ".php";
    $obj = new ControlVistas($rutaFinal);
    call_user_func(array($obj, $method));
}