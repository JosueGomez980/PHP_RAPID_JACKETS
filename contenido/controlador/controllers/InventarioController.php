<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InventarioController
 *
 * @author JosueFrancisco
 */
require_once 'cargar_clases3.php';
AutoCarga3::init();

class InventarioRequest extends Request {

    private $inventarioDTO = null;

    const inv_id = "inventario_id";
    const inv_pro_id = "inventario_id_producto";
    const inv_fecha = "inventario_fecha";
    const inv_cantidad = "inventario_cantidad";
    const inv_precio_mayor = "inventario_precio_mayor";
    const inv_obser = "inventario_observaciones";

    public function __construct() {
        parent::__construct();
    }

    public function getInventarioDTO() {
        return $this->inventarioDTO;
    }

    public function setInventarioDTO(InventarioDTO $inventarioDTO) {
        $this->inventarioDTO = $inventarioDTO;
    }

    public function doDelete() {
        
    }

    public function doGet() {
        $invDTO = new InventarioDTO();
        if (isset($_GET[self::inv_id])) {
            $invDTO->setIdInventario(filter_input(INPUT_GET, self::inv_id));
        }
        if (isset($_GET[self::inv_pro_id])) {
            $invDTO->setProductoIdProducto(filter_input(INPUT_GET, self::inv_pro_id));
        }
        if (isset($_GET[self::inv_fecha])) {
            $invDTO->setFecha(filter_input(INPUT_GET, self::inv_fecha));
        }
        if (isset($_GET[self::inv_cantidad])) {
            $invDTO->setCantidad(filter_input(INPUT_GET, self::inv_cantidad));
        }
        if (isset($_GET[self::inv_precio_mayor])) {
            $invDTO->setPrecioMayor(filter_input(INPUT_GET, self::inv_precio_mayor));
        }
        if (isset($_GET[self::inv_obser])) {
            $invDTO->setObservaciones(filter_input(INPUT_GET, self::inv_obser));
        }
        $this->inventarioDTO = $invDTO;
    }

    public function doHead() {
        
    }

    public function doPost() {
        $invDTO = new InventarioDTO();
        if (isset($_POST[self::inv_id])) {
            $invDTO->setIdInventario(filter_input(INPUT_POST, self::inv_id));
        }
        if (isset($_POST[self::inv_pro_id])) {
            $invDTO->setProductoIdProducto(filter_input(INPUT_POST, self::inv_pro_id));
        }
        if (isset($_POST[self::inv_fecha])) {
            $invDTO->setFecha(filter_input(INPUT_POST, self::inv_fecha));
        }
        if (isset($_POST[self::inv_cantidad])) {
            $invDTO->setCantidad(filter_input(INPUT_POST, self::inv_cantidad));
        }
        if (isset($_POST[self::inv_precio_mayor])) {
            $invDTO->setPrecioMayor(filter_input(INPUT_POST, self::inv_precio_mayor));
        }
        if (isset($_POST[self::inv_obser])) {
            $invDTO->setObservaciones(filter_input(INPUT_POST, self::inv_obser));
        }
        $this->inventarioDTO = $invDTO;
    }

    public function doPut() {
        
    }

    public function doRequest() {
        $invDTO = new InventarioDTO();
        if (isset($_REQUEST[self::inv_id])) {
            $invDTO->setIdInventario(filter_input(INPUT_REQUEST, self::inv_id));
        }
        if (isset($_REQUEST[self::inv_pro_id])) {
            $invDTO->setProductoIdProducto(filter_input(INPUT_REQUEST, self::inv_pro_id));
        }
        if (isset($_REQUEST[self::inv_fecha])) {
            $invDTO->setFecha(filter_input(INPUT_REQUEST, self::inv_fecha));
        }
        if (isset($_REQUEST[self::inv_cantidad])) {
            $invDTO->setCantidad(filter_input(INPUT_REQUEST, self::inv_cantidad));
        }
        if (isset($_REQUEST[self::inv_precio_mayor])) {
            $invDTO->setPrecioMayor(filter_input(INPUT_REQUEST, self::inv_precio_mayor));
        }
        if (isset($_REQUEST[self::inv_obser])) {
            $invDTO->setObservaciones(filter_input(INPUT_REQUEST, self::inv_obser));
        }
        $this->inventarioDTO = $invDTO;
    }

}

class InventarioController implements GenericController, Validable {

    private $inventarioDAO;
    private $productoDAO;
    private $inventarioMQT;
    private $conMGR;
    public static $instancia = null;

    public function __construct() {
        $this->inventarioDAO = new InventarioDAO();
        $this->inventarioMQT = new InventarioMaquetador();
        $this->productoDAO = new ProductoDAO();
        $this->conMGR = new ContentManager();
        $this->sesion = SimpleSession::getInstancia();
        //Seguridad para cuando se accede solo a un metod en concreto de esta clase
        $page = new AccesoPagina();
        $page->comprobarSesionAdmin(AccesoPagina::INICIO);
    }

    public static function getInstancia() {
        if (is_null(self::$instancia)) {
            self::$instancia = new InventarioController();
        }
        return self::$instancia;
    }

    public function actualizar(EntityDTO $entidad) {
        $entidad instanceof InventarioDTO;
        $rta = $this->inventarioDAO->update($entidad);
        return $rta;
    }

    public function eliminar(EntityDTO $entidad) {
        $entidad instanceof InventarioDTO;
        $rta = $this->inventarioDAO->delete($entidad);
        return $rta;
    }

    public function encontrar(EntityDTO $entidad) {
        $entidad instanceof InventarioDTO;
        return $this->inventarioDAO->find($entidad);
    }

    public function encontrarTodos() {
        return $this->inventarioDAO->findAll();
    }

    public function encontrarPorProducto(ProductoDTO $pro) {
        $tablaArray = null;
        $invSr = new InventarioDTO();
        $invSr->setProductoIdProducto($pro->getIdProducto());
        $tablaArray = $this->inventarioDAO->findByProducto($invSr);
        if (is_null($tablaArray) || empty($tablaArray) || count($tablaArray) <= 0) {
            return null;
        } else {
            return $tablaArray;
        }
    }

    public function insertar(EntityDTO $entidad) {
        $ok = true;
        $entidad instanceof InventarioDTO;
        $entidad->setIdInventario($this->inventarioDAO->generateIdInDB());
        $rta = $this->inventarioDAO->insert($entidad);
        switch ($rta) {
            case 1:
                $this->conMGR->setFormato(new Exito());
                $this->conMGR->setContenido("Inventario guardado correctamente");
                break;
            case 0:
                $this->conMGR->setFormato(new Errado());
                $this->conMGR->setContenido("Inventario no fue guardado correctamente");
                $ok = false;
                break;
            case -1:
                $this->conMGR->setFormato(new Errado);
                $this->conMGR->setContenido("Hubo un error grave. Intente de nuevo");
                $ok = false;
                break;
        }
        return $ok;
    }

    public function validaFK(EntityDTO $entidad) {
        $entidad instanceof InventarioDTO;
    }

    public function validaPK(EntityDTO $entidad) {
        $entidad instanceof InventarioDTO;
    }

    public function mostrarFormularioNuevoInv(ProductoDTO $pro) {
        $modal = new ModalSimple();
        $productoDAO = new ProductoDAO();
        $modal->open();
        $pro->setIdProducto(CriptManager::urlVarDecript($pro->getIdProducto()));
        $proFinded = $productoDAO->find($pro);
        if (!is_null($proFinded)) {
            $sesion = new SimpleSession();
            $sesion->addEntidad($proFinded, Session::PRO_DTO);
            $this->inventarioMQT->maquetarFormNuevoInventario($proFinded);
        } else {
            $err = new Errado();
            $err->setValor("Error al buscar el producto. Intente de nuevo");
            $modal->addElemento($err);
        }
        $btnCls = new CloseBtn();
        $btnCls->setValor("Cerrar");
        $modal->addElemento($btnCls);

        $modal->maquetar();
        $modal->close();
    }
    public function mostrarTablaInventarios(array $inventarios){
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        $paginador = $sesion->get(Session::PAGINADOR);
        $paginador instanceof PaginadorMemoria;
        $paginador->maquetarBarraPaginacion();
        $this->inventarioMQT->maquetaArrayObject($inventarios);
        $paginador->maquetarBarraPaginacion();
    }

}
