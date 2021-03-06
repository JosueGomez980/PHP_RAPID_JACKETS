<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PedidoEntregaDAO
 *
 * @author Josué Francisco
 */
//include_once 'Conexion.php';
//include_once 'PreparedSQL.php';
//include_once 'PedidoEntregaDTO.php';

final class PedidoEntregaDAO implements DAOPaginable {

    private $db;
    private static $instancia = null;
    private static $idFactura = "FACTURA_ID_FACTURA";
    private static $cuentaTipDoc = "CUENTA_TIPO_DOCUMENTO";
    private static $cuentaNumDoc = "CUENTA_NUM_DOCUMENTO";
    private static $domicilio = "DOMICILIO";
    private static $fechaSolicitud = "FECHA_SOLICITUD";
    private static $fechaEntrega = "FECHA_ENTREGA";
    private static $estado = "ESTADO";
    private static $observaciones = "OBSERVACIONES";
    private static $subTotal = "SUBTOTAL";
    private static $impuestos = "IMPUESTOS";
    private static $total = "TOTAL";
    //-------------------------------------------------------------------------
    public static $ENTREGADO = "PEDIDO ENTREGADO";
    public static $FINALIZADO = "PEDIDO FINALIZADO";
    public static $SOLICITADO = "PEDIDO SOLICITADO";
    public static $ENVIADO = "PEDIDO ENVIADO";
    public static $DEVUELTO = "PEDIDO DEVUELTO";
    public static $SIN_PAGO = "PEDIDO SIN PAGAR";
    public static $NO_PUDO_ENTREGAR = "PEDIDO NO SE PUDO ENTREGAR";
    public static $RETRASADO = "PEDIDO RETRASADO";
    public static $POR_LLEGAR = "PEDIDO ESTÁ POR LLEGAR";
    public static $ELIMINADO = "PEDIDO ELIMINADO";
    public static $ACEPTADO = "PEDIDO ACEPTADO";
    public static $DENIED = "PEDIDO DENEGADO";
    
    const OBS_NOT = "NO HAY OBSERVACIONES POR PARTE DEL ADMINISTRADOR";

    const DOM_NOT = "DOMICILIO_SIN_ASIGNAR";
    const DOM_SENA_A = "SENA - CEET - Complejo Sur";
    const DOM_SENA_B = "SENA - CEET - Sede Restrepo";
    const DOM_SENA_C = "SENA - CEET - Barrio Colombia";
    const DOM_SENA_D = "SENA - CEET - Sede Bosanova";
    const DOM_SENA_E = "SENA - CEET - Sede Ricaurte";

    public function __construct() {
        $this->db = Conexion::getInstance();
    }
    
    public static function getInstancia(){
        if(is_null(self::$instancia)){
            self::$instancia = new PedidoEntregaDAO();
        }
        return self::$instancia;
    }

    private function resultToObject(mysqli_result $resultado) {
        $fila = $resultado->fetch_array();
        $pedido = new PedidoEntregaDTO();
        $pedido->setFacturaIdFactura($fila[self::$idFactura]);
        $pedido->setCuentaTipoDocumento($fila[self::$cuentaTipDoc]);
        $pedido->setCuentaNumDocumento($fila[self::$cuentaNumDoc]);
        $pedido->setDomicilio($fila[self::$domicilio]);
        $pedido->setFechaSolicitud($fila[self::$fechaSolicitud]);
        $pedido->setFechaEntrega($fila[self::$fechaEntrega]);
        $pedido->setEstado($fila[self::$estado]);
        $pedido->setObservaciones($fila[self::$observaciones]);
        $pedido->setSubtotal($fila[self::$subTotal]);
        $pedido->setImpuestos($fila[self::$impuestos]);
        $pedido->setTotal($fila[self::$total]);
        return $pedido;
    }

    private function resultToArray(mysqli_result $resultado) {
        $pedidos = [];
        while ($fila = $resultado->fetch_array()) {
            $pedido = new PedidoEntregaDTO();
            $pedido->setFacturaIdFactura($fila[self::$idFactura]);
            $pedido->setCuentaTipoDocumento($fila[self::$cuentaTipDoc]);
            $pedido->setCuentaNumDocumento($fila[self::$cuentaNumDoc]);
            $pedido->setDomicilio($fila[self::$domicilio]);
            $pedido->setFechaSolicitud($fila[self::$fechaSolicitud]);
            $pedido->setFechaEntrega($fila[self::$fechaEntrega]);
            $pedido->setEstado($fila[self::$estado]);
            $pedido->setObservaciones($fila[self::$observaciones]);
            $pedido->setSubtotal($fila[self::$subTotal]);
            $pedido->setImpuestos($fila[self::$impuestos]);
            $pedido->setTotal($fila[self::$total]);
            $pedidos[] = $pedido;
        }
        return $pedidos;
    }

    public function insert(PedidoEntregaDTO $pedido) {
        $idFactura = $pedido->getFacturaIdFactura();
        $tipDocumento = $pedido->getCuentaTipoDocumento();
        $numDocumento = $pedido->getCuentaNumDocumento();
        $domicilio = $pedido->getDomicilio();
        $fechaSolic = $pedido->getFechaSolicitud();
        $fechaEntrega = $pedido->getFechaEntrega();
        $estado = $pedido->getEstado();
        $observaciones = $pedido->getObservaciones();
        $subTotal = $pedido->getSubtotal();
        $impuestos = $pedido->getImpuestos();
        $total = $pedido->getTotal();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::pedido_insert);
            $stmt->bind_param("ssssssssddd", $idFactura, $tipDocumento, $numDocumento, $domicilio, $fechaSolic, $fechaEntrega, $estado, $observaciones, $subTotal, $impuestos, $total);
            $stmt->execute();
            $res = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $res;
    }

    public function update(PedidoEntregaDTO $pedido) {
        $idFactura = $pedido->getFacturaIdFactura();
        $tipDocumento = $pedido->getCuentaTipoDocumento();
        $numDocumento = $pedido->getCuentaNumDocumento();
        $domicilio = $pedido->getDomicilio();
        $fechaEntrega = $pedido->getFechaEntrega();
        $observaciones = $pedido->getObservaciones();
        $subTotal = $pedido->getSubtotal();
        $impuestos = $pedido->getImpuestos();
        $total = $pedido->getTotal();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::pedido_update);
            $stmt->bind_param("sssdddsss", $domicilio, $fechaEntrega, $observaciones, $subTotal, $impuestos, $total, $idFactura, $tipDocumento, $numDocumento);
            $stmt->execute();
            $res = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $res;
    }

    public function delete(PedidoEntregaDTO $pedido) {
        $idFactura = $pedido->getFacturaIdFactura();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::pedido_delete);
            $stmt->bind_param("s", $idFactura);
            $stmt->execute();
            $res = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $res;
    }

    public function putEstado(PedidoEntregaDTO $pedido) {
        $idFactura = $pedido->getFacturaIdFactura();
        $estado = $pedido->getEstado();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::pedido_put_estado);
            $stmt->bind_param("ss", $estado, $idFactura);
            $stmt->execute();
            $res = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $res;
    }

    public function find(PedidoEntregaDTO $pedido) {
        $pedidoFd = NULL;
        $idFactura = $pedido->getFacturaIdFactura();
        $tipDocumento = $pedido->getCuentaTipoDocumento();
        $numDocumento = $pedido->getCuentaNumDocumento();
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::pedido_find);
            $stmt->bind_param("sss", $idFactura, $tipDocumento, $numDocumento);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows != 0) {
                $pedidoFd = $this->resultToObject($resultado);
            }
            $resultado->close();
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $pedidoFd;
    }

    public function findByFactura(PedidoEntregaDTO $pedido) {
        $pedidoFd = NULL;
        $idFactura = $pedido->getFacturaIdFactura();
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::pedido_find_by_factura);
            $stmt->bind_param("s", $idFactura);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows != 0) {
                $pedidoFd = $this->resultToObject($resultado);
            }
            $resultado->close();
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $pedidoFd;
    }

    public function findAll() {
        $pedidos = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $resultado = $conexion->query(PreparedSQL::pedido_find_all);
            if ($resultado->num_rows != 0) {
                $pedidos = $this->resultToArray($resultado);
            }
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $pedidos;
    }

    public function findByCuenta(PedidoEntregaDTO $pedido) {
        $pedidosFd = NULL;
        $tipDocumento = $pedido->getCuentaTipoDocumento();
        $numDocumento = $pedido->getCuentaNumDocumento();
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::pedido_find_by_cuenta);
            $stmt->bind_param("ss", $tipDocumento, $numDocumento);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows != 0) {
                $pedidosFd = $this->resultToArray($resultado);
            }
            $resultado->close();
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $pedidosFd;
    }

    public function findByEstado($estado) {
        $pedidosFd = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::pedido_find_by_estado);
            $stmt->bind_param("s", $estado);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows != 0) {
                $pedidosFd = $this->resultToArray($resultado);
            }
            $resultado->close();
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $pedidosFd;
    }

    public function findByDateEntrega($fecha) {
        $pedidosFd = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::pedido_find_by_fecha_entrega);
            $stmt->bind_param("s", $fecha);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows != 0) {
                $pedidosFd = $this->resultToArray($resultado);
            }
            $resultado->close();
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $pedidosFd;
    }

    public function findByDateSolicitud($fecha) {
        $pedidosFd = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::pedido_find_by_fecha_solicitud);
            $stmt->bind_param("s", $fecha);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows != 0) {
                $pedidosFd = $this->resultToArray($resultado);
            }
            $resultado->close();
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $pedidosFd;
    }

    public function findByDatePreBuilt($queryPreBuilt) {
        $pedidos = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $resultado = $conexion->query($queryPreBuilt);
            if ($resultado->num_rows != 0) {
                $pedidos = $this->resultToArray($resultado);
            }
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $pedidos;
    }

    public function findByPaginationLimit($inicio, $cantidad) {
        
    }

}
