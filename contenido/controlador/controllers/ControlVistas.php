<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControlVistas
 *
 * @author JosueFrancisco
 */
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
    public function producto_busqueda_avanzada_user(){
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