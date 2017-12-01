<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FacturaController
 *
 * @author JosueFrancisco
 */
//require_once 'cargar_clases3.php';
//AutoCarga3::init();

final class FacturaRequest extends Request {

    private $facturaDTO;

    const fac_id = "factura_id";
    const fac_cu_tip_doc = "factura_cuenta_tipo_documento";
    const fac_cu_num_doc = "factura_cuenta_numero_documento";
    const fac_fecha_ = "factura_fecha";
    const fac_est = "factura_estado";
    const fac_obsv = "factura_observaciones";
    const fac_subtotal = "factura_subtotal";
    const fac_impuestos = "factura_subtotal";
    const fac_total = "factura_total";

    public function __construct() {
        parent::__construct();
    }

    public function getFacturaDTO() {
        return $this->facturaDTO;
    }

    public function setFacturaDTO(FacturaDTO $facturaDTO) {
        $this->facturaDTO = $facturaDTO;
    }

    public function doDelete() {
        return null;
    }

    public function doGet() {
        $factDTO = new FacturaDTO();
        if (isset($_GET[self::fac_id])) {
            $factDTO->setIdFactura(filter_input(INPUT_GET, self::fac_id));
        }
        if (isset($_GET[self::fac_cu_tip_doc])) {
            $factDTO->setCuentaTipoDocumento(filter_input(INPUT_GET, self::fac_cu_tip_doc));
        }
        if (isset($_GET[self::fac_cu_num_doc])) {
            $factDTO->setCuentaNumDocumento(filter_input(INPUT_GET, self::fac_cu_num_doc));
        }
        if (isset($_GET[self::fac_fecha_])) {
            $factDTO->setFecha(filter_input(INPUT_GET, self::fac_fecha_));
        }
        if (isset($_GET[self::fac_est])) {
            $factDTO->setEstado(filter_input(INPUT_GET, self::fac_est));
        }
        if (isset($_GET[self::fac_obsv])) {
            $factDTO->setObservaciones(filter_input(INPUT_POST, self::fac_obsv));
        }
        if (isset($_GET[self::fac_subtotal])) {
            $factDTO->setSubtotal(filter_input(INPUT_GET, self::fac_subtotal));
        }
        if (isset($_GET[self::fac_impuestos])) {
            $factDTO->setImpuestos(filter_input(INPUT_GET, self::fac_impuestos));
        }
        if (isset($_GET[self::fac_total])) {
            $factDTO->setTotal(filter_input(INPUT_GET, self::fac_total));
        }
        $this->facturaDTO = $factDTO;
    }

    public function doHead() {
        return null;
    }

    public function doPost() {
        $factDTO = new FacturaDTO();
        if (isset($_POST[self::fac_id])) {
            $factDTO->setIdFactura(filter_input(INPUT_POST, self::fac_id));
        }
        if (isset($_POST[self::fac_cu_tip_doc])) {
            $factDTO->setCuentaTipoDocumento(filter_input(INPUT_POST, self::fac_cu_tip_doc));
        }
        if (isset($_POST[self::fac_cu_num_doc])) {
            $factDTO->setCuentaNumDocumento(filter_input(INPUT_POST, self::fac_cu_num_doc));
        }
        if (isset($_POST[self::fac_fecha_])) {
            $factDTO->setFecha(filter_input(INPUT_POST, self::fac_fecha_));
        }
        if (isset($_POST[self::fac_est])) {
            $factDTO->setEstado(filter_input(INPUT_POST, self::fac_est));
        }
        if (isset($_POST[self::fac_obsv])) {
            $factDTO->setObservaciones(filter_input(INPUT_POST, self::fac_obsv));
        }
        if (isset($_POST[self::fac_subtotal])) {
            $factDTO->setSubtotal(filter_input(INPUT_POST, self::fac_subtotal));
        }
        if (isset($_POST[self::fac_impuestos])) {
            $factDTO->setImpuestos(filter_input(INPUT_POST, self::fac_impuestos));
        }
        if (isset($_POST[self::fac_total])) {
            $factDTO->setTotal(filter_input(INPUT_POST, self::fac_total));
        }
        $this->facturaDTO = $factDTO;
    }

    public function doPut() {
        return null;
    }

    public function doRequest() {
        $factDTO = new FacturaDTO();
        if (isset($_REQUEST[self::fac_id])) {
            $factDTO->setIdFactura(filter_input(INPUT_REQUEST, self::fac_id));
        }
        if (isset($_REQUEST[self::fac_cu_tip_doc])) {
            $factDTO->setCuentaTipoDocumento(filter_input(INPUT_REQUEST, self::fac_cu_tip_doc));
        }
        if (isset($_REQUEST[self::fac_cu_num_doc])) {
            $factDTO->setCuentaNumDocumento(filter_input(INPUT_REQUEST, self::fac_cu_num_doc));
        }
        if (isset($_REQUEST[self::fac_fecha_])) {
            $factDTO->setFecha(filter_input(INPUT_REQUEST, self::fac_fecha_));
        }
        if (isset($_REQUEST[self::fac_est])) {
            $factDTO->setEstado(filter_input(INPUT_REQUEST, self::fac_est));
        }
        if (isset($_REQUEST[self::fac_obsv])) {
            $factDTO->setObservaciones(filter_input(INPUT_POST, self::fac_obsv));
        }
        if (isset($_REQUEST[self::fac_subtotal])) {
            $factDTO->setSubtotal(filter_input(INPUT_REQUEST, self::fac_subtotal));
        }
        if (isset($_REQUEST[self::fac_impuestos])) {
            $factDTO->setImpuestos(filter_input(INPUT_REQUEST, self::fac_impuestos));
        }
        if (isset($_REQUEST[self::fac_total])) {
            $factDTO->setTotal(filter_input(INPUT_REQUEST, self::fac_total));
        }
        $this->facturaDTO = $factDTO;
    }

}

class FacturaController implements GenericController, Validable {

    private $facturaDAO;
    private $pedidoMQT;
    private $pedidoDAO;
    private $faturaDTO;
    private $itemsFacturaDTO;
    private $itemDAO;
    private $facturaMQT;

    public function __construct() {
        $this->facturaDAO = new FacturaDAO();
        $this->pedidoDAO = new PedidoEntregaDAO();
        $this->pedidoMQT = new PedidoMaquetador();
        $this->facturaMQT = new FacturaMaquetador();
        $this->itemDAO = new ItemDAO();
    }

    public function actualizar(EntityDTO $entidad) {
        $entidad instanceof FacturaDTO;
    }

    public function eliminar(EntityDTO $entidad) {
        $entidad instanceof FacturaDTO;
        $rta = $this->facturaDAO->delete($entidad);
    }

    public function encontrar(EntityDTO $entidad) {
        $entidad instanceof FacturaDTO;
        return $this->facturaDAO->find($entidad);
    }

    public function encontrarTodos() {
        return $this->facturaDAO->findAll();
    }

    public function insertar(EntityDTO $entidad) {
        $entidad instanceof FacturaDTO;
        $rta = $this->facturaDAO->insert($entidad);
        return ($rta == 1);
    }

    public function insertarItems(array $items, $idFactura) { //Deben ser items de Carrito
        $itemsInsert = array();
        foreach ($items as $itt) {
            $itemsInsert[] = ItemDAO::itemCarritoToItemDTO($itt, $idFactura);
        }
        $numeroTotal = count($itemsInsert);
        $numInsOks = $this->itemDAO->inserts($itemsInsert);
        return ($numInsOks == $numeroTotal);
    }

    public function insertarFacturaDefault() {
        $ok = true;
        $modal = new ModalSimple();
        $dater = DateManager::getInstance();
        $dater instanceof DateManager;
        $faturaInsert = new FacturaDTO();
        $sesion = SimpleSession::getInstancia();
        $sesion instanceof SimpleSession;
        if ($sesion->existe(Session::US_LOGED) && $sesion->existe(Session::CU_LOGED)) {
            $cuentaUser = $sesion->getEntidad(Session::CU_LOGED);
            $cuentaUser instanceof CuentaDTO;
            $carritoDTO = $sesion->getEntidad(Session::CART_USER);
            $carritoDTO instanceof CarritoComprasDTO;
            $faturaInsert->setCuentaNumDocumento($cuentaUser->getNumDocumento());
            $faturaInsert->setCuentaTipoDocumento($cuentaUser->getTipoDocumento());
            $faturaInsert->setEstado(FacturaDAO::EST_SIN_PAGAR);
            $faturaInsert->setFecha($dater->getSQLDateTime());
            $faturaInsert->setIdFactura($this->facturaDAO->generateIdInDB());
            $faturaInsert->setImpuestos($carritoDTO->getImpuestos());
            $faturaInsert->setSubtotal($carritoDTO->getSubtotal());
            $faturaInsert->setTotal($carritoDTO->getTotal());
            $faturaInsert->setObservaciones("NINGUNA");

            if ($this->insertar($faturaInsert)) {

                //Insertar el pago por defecto
                $pagoDAO = new PagoDAO();
                $pagoDTO = new PagoDTO();
                $pagoDTO->setFacturaIdFactura($faturaInsert->getIdFactura());
                $pagoDTO->setTipoPago(PagoDAO::P_CONTRA_ENTR);
                $pagoDTO->setValor($faturaInsert->getTotal());
                $rtaP = $pagoDAO->insert($pagoDTO);
                //---------------------------------
                //-------Insertar el pedido por defecto.
                if (!$this->generarPedidoDefault($faturaInsert)) {
                    $ok = false;
                    $err = new Errado();
                    $err->setValor("El pedido no pudo ser generado");
                    $modal->addElemento($err);
                }

                if ($this->insertarItems($carritoDTO->getItems(), $faturaInsert->getIdFactura())) {
                    $ok = true;
                } else {
                    $ok = false;
                }
            } else {
                $ok = false;
            }
        } else {
            $ok = false;
        }
        if ($ok) {
            $exito = new Exito();
            $exito->setValor("Tu pedido ha sido generado. Pronto podrás saber cuándo se te entregará.");
            $modal->addElemento($exito);
            $llamarCarrito = new CarritoComprasController();
            $llamarCarrito->vaciarCarrito();
            //Llenar las propiedades de esta clase necesarias para maquetar las factuuras
            $this->faturaDTO = $faturaInsert;
            $itemsInsert = array();
            foreach ($carritoDTO->getItems() as $it) {
                $itemsInsert[] = ItemDAO::itemCarritoToItemDTO($it, $faturaInsert->getIdFactura());
            }
            $this->itemsFacturaDTO = $itemsInsert;
        } else {
            $err = new Errado();
            $err->setValor("Debes haber iniciado sesión para poder comprar");
            $modal->addElemento($err);
            $modal->setClosebtn("Aceptar");
            $sesion->add(Session::NEGOCIO_RTA, $modal);
            $acceso = new AccesoPagina();
            $acceso->irPagina(AccesoPagina::INICIO);
        }

        $modal->setClosebtn("Aceptar");
        return $modal;
    }

    public function generarPedidoDefault(FacturaDTO $fact) {
        $domicilioDTO = null;
        $domicioString = "";
        $dater = DateManager::getInstance();
        $dater instanceof DateManager;
        $pedidoDAO = new PedidoEntregaDAO();
        $domiDAO = new DomicilioCuentaDAO();
        $domiDTO = new DomicilioCuentaDTO();

        $pedidoDTO = new PedidoEntregaDTO();
        $pedidoDTO->setFacturaIdFactura($fact->getIdFactura());
        $pedidoDTO->setCuentaNumDocumento($fact->getCuentaNumDocumento());
        $pedidoDTO->setCuentaTipoDocumento($fact->getCuentaTipoDocumento());
        $pedidoDTO->setFechaSolicitud($dater->formatNowDate(DateManager::SQL_DATETIME));
        $pedidoDTO->setEstado(PedidoEntregaDAO::$SOLICITADO);

        $domiDTO->setCuentaNumDocumento($fact->getCuentaNumDocumento());
        $domiDTO->setCuentaTipoDocumento($fact->getCuentaTipoDocumento());
        $domicilioDTO = $domiDAO->find($domiDTO);
        if (is_null($domicilioDTO)) {
            $pedidoDTO->setDomicilio(PedidoEntregaDAO::DOM_NOT);
        } else {
            $domicioString = json_encode($domicilioDTO);
            $pedidoDTO->setDomicilio($domicioString);
        }
        $pedidoDTO->setSubtotal($fact->getSubtotal());
        $pedidoDTO->setImpuestos($fact->getImpuestos());
        $pedidoDTO->setTotal($fact->getTotal());
        if ($pedidoDAO->insert($pedidoDTO) == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function mostrarCrudPedidosPorFechaPredefinida($metodo) {
        $tablaPedidos = null;
        switch ($metodo) {
            case "FD_A":
                $tablaPedidos = $this->pedidoDAO->findByDatePreBuilt(PreparedSQL::pedido_find_by_fecha_solicitud_hoy);
                break;
            case "FD_B":
                $tablaPedidos = $this->pedidoDAO->findByDatePreBuilt(PreparedSQL::pedido_find_by_fecha_solicitud_ayer);
                break;
            case "FD_C":
                $tablaPedidos = $this->pedidoDAO->findByDatePreBuilt(PreparedSQL::pedido_find_by_fecha_solicitud_seman);
                break;
            case "FD_D":
                $tablaPedidos = $this->pedidoDAO->findByDatePreBuilt(PreparedSQL::pedido_find_by_fecha_solicitud_mes);
                break;
            case "FD_E":
                $tablaPedidos = $this->pedidoDAO->findByDatePreBuilt(PreparedSQL::pedido_find_by_fecha_solicitud_anio);
                break;
            default :
                break;
        }
        if (is_null($tablaPedidos)) {
            $neu = new Neutral();
            echo($neu->toString("No se encontraron pedidos pendientes para fecha indicada"));
        } else {
            $this->pedidoMQT->maquetaTablaCrudAdmin($tablaPedidos);
        }

        return $tablaPedidos;
    }

    public function mostrarFacturaWebTipoA() {
        $factura = $this->faturaDTO;
        $items = $this->itemsFacturaDTO;
        $this->facturaMQT->maquetarFacturaTipoA($factura, $items);
    }

    public function descontarProductos(array $items) { //Deben ser items de Carrito
        $ok = false;
        $proDAO = ProductoDAO::getInstancia();
        $proDAO instanceof ProductoDAO;
        $numItems = count($items);
        $numItemsOK = 0;
        foreach ($items as $it) {
            $it instanceof ItemCarritoDTO;
            $proDTO = $it->getProducto();
            $proDTO instanceof ProductoDTO;
            $proFinded = $proDAO->find($proDTO);
            $proFinded instanceof ProductoDTO;
            $nuevaCantidad = ($proFinded->getCantidad() - $it->getCantidad());
            $proDTO->setCantidad($nuevaCantidad);
            if ($proDAO->updateCantidad($proDTO) == 1) {
                $numItemsOK++;
            }
        }
        if ($numItems == $numItemsOK) {
            $ok = true;
        }
        return $ok;
    }

    public function consolidarFactura(FacturaDTO $factura) {
        
    }

    public function validaFK(EntityDTO $entidad) {
        $entidad instanceof FacturaDTO;
        if (!empty($entidad->getCuentaNumDocumento() && !empty($entidad->getCuentaTipoDocumento()))) {
            $facF = $this->facturaDAO->findByCuenta($entidad);
            return !is_null($facF);
        } else {
            return false;
        }
        return FALSE;
    }

    public function validaPK(EntityDTO $entidad) {
        $entidad instanceof FacturaDTO;
        if ($entidad->getIdFactura() != null && $entidad->getIdFactura() !== "") {
            $facF = $this->facturaDAO->find($entidad);
            return !is_null($facF);
        } else {
            return false;
        }
        return FALSE;
    }

}
