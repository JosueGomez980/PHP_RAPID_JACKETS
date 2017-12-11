<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FacturaDAO
 *
 * @author Josué Francisco
 */
//include_once 'Conexion.php';
//include_once 'PreparedSQL.php';
//include_once 'FacturaDTO.php';

final class FacturaDAO implements DAOPaginable {

    private $db;
    private static $idFactura = "ID_FACTURA";
    private static $tipDoc = "CUENTA_TIPO_DOCUMENTO";
    private static $numDoc = "CUENTA_NUM_DOCUMENTO";
    private static $fecha = "FECHA";
    private static $estado = "ESTADO";
    private static $observaciones = "OBSERVACIONES";
    private static $subTotal = "SUBTOTAL";
    private static $impuestos = "IMPUESTOS";
    private static $total = "TOTAL";

    const EST_SIN_PAGAR = "SIN_PAGAR";
    const EST_CANCELADA = "CANCELADA";
    const EST_ANULADA = "ANULADA";
    const EST_ABONADA = "ABONADA";
    const EST_ELIMINDA = "ELIMINADA";

    const OBS_NOT = "NO HAY OBSERVACIONES POR PARTE DEL ADMINISTRADOR";

    public function __construct() {
        $this->db = Conexion::getInstance();
    }

    private function resultToArray(mysqli_result $resultado) {
        $tablaFactura = [];
        while ($fila = $resultado->fetch_array()) {
            $factura = new FacturaDTO();
            $factura->setIdFactura($fila[self::$idFactura]);
            $factura->setCuentaTipoDocumento($fila[self::$tipDoc]);
            $factura->setCuentaNumDocumento($fila[self::$numDoc]);
            $factura->setFecha($fila[self::$fecha]);
            $factura->setEstado($fila[self::$estado]);
            $factura->setObservaciones($fila[self::$observaciones]);
            $factura->setSubtotal($fila[self::$subTotal]);
            $factura->setImpuestos($fila[self::$impuestos]);
            $factura->setTotal($fila[self::$total]);
            $tablaFactura[] = $factura;
        }
        return $tablaFactura;
    }

    private function resultToObject(mysqli_result $resultado) {
        $fila = $resultado->fetch_array();
        $factura = new FacturaDTO();
        $factura->setIdFactura($fila[self::$idFactura]);
        $factura->setCuentaTipoDocumento($fila[self::$tipDoc]);
        $factura->setCuentaNumDocumento($fila[self::$numDoc]);
        $factura->setFecha($fila[self::$fecha]);
        $factura->setEstado($fila[self::$estado]);
        $factura->setObservaciones($fila[self::$observaciones]);
        $factura->setSubtotal($fila[self::$subTotal]);
        $factura->setImpuestos($fila[self::$impuestos]);
        $factura->setTotal($fila[self::$total]);
        return $factura;
    }

    public function insert(FacturaDTO $factura) {
        $idFactura = $factura->getIdFactura();
        $tipDoc = $factura->getCuentaTipoDocumento();
        $numDoc = $factura->getCuentaNumDocumento();
        $fecha = $factura->getFecha();
        $observ = $factura->getObservaciones();
        $subtotal = $factura->getSubtotal();
        $impuestos = $factura->getImpuestos();
        $total = $factura->getTotal();
        $rta = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::factura_insert);
            $stmt->bind_param("sssssddd", $idFactura, $tipDoc, $numDoc, $fecha, $observ, $subtotal, $impuestos, $total);
            $stmt->execute();
            $rta = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function update(FacturaDTO $factura) {
        $idFactura = $factura->getIdFactura();
        $observaciones = $factura->getObservaciones();
        $subtotal = $factura->getSubtotal();
        $impuestos = $factura->getImpuestos();
        $total = $factura->getTotal();
        $fecha = $factura->getFecha();
        $rta = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::factura_update);
            $stmt->bind_param("sdddss", $observaciones, $subtotal, $impuestos, $total, $fecha, $idFactura);
            $stmt->execute();
            $rta = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function delete(FacturaDTO $factura) {
        $idFactura = $factura->getIdFactura();
        $rta = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::factura_delete);
            $stmt->bind_param("s", $idFactura);
            $stmt->execute();
            $rta = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function putEstado(FacturaDTO $factura) {
        $idFactura = $factura->getIdFactura();
        $estado = $factura->getEstado();
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::factura_put_estado);
            $stmt->bind_param("ss", $estado, $idFactura);
            $stmt->execute();
            $rta = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function find(FacturaDTO $facturaFind) {
        $idFactura = $facturaFind->getIdFactura();
        $factura = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::factura_find);
            $stmt->bind_param("s", $idFactura);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $factura = $this->resultToObject($resultado);
            }
            $stmt->close();
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $factura;
    }

    public function findAll() {
        $facturas = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $resultado = $conexion->query(PreparedSQL::factura_find_all);
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $facturas = $this->resultToArray($resultado);
            }
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $facturas;
    }

    public function findByCuenta(FacturaDTO $facturaFind) {
        $tipDoc = $facturaFind->getCuentaTipoDocumento();
        $numDoc = $facturaFind->getCuentaNumDocumento();
        $facturas = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::factura_find_by_cuenta);
            $stmt->bind_param("ss", $tipDoc, $numDoc);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows != 0) {
                $facturas = $this->resultToArray($resultado);
            }
            $stmt->close();
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $facturas;
    }

    public function findByDate($fecha) {
        $facturas = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::factura_find_by_date);
            $stmt->bind_param("s", $fecha);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $facturas = $this->resultToArray($resultado);
            }
            $stmt->close();
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $facturas;
    }

    public function findByPaginationLimit($inicio, $cantidad) {
        
    }

    public function generateIdInCoreA() {
        $idExistente = null;
        $nuevoId = null;
        $array_letras = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $resultado = $conexion->query("SELECT MAX(ID_FACTURA) AS 'MAX_ID' FROM FACTURA;");
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $resultado->data_seek(0);
                $idExistente = $resultado->fetch_array()["MAX_ID"];
            }
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        if (strlen($idExistente) >= 14 && !is_null($idExistente)) {
            $nuevoNumero = 0;
            $strLetras = substr($idExistente, 2, 3);
            $numero = substr($idExistente, 5, 10);
            $lenNumero = strlen($numero);
            $numero = (int) $numero;
            $arrayLetras = str_split($strLetras);
            $l1 = $arrayLetras[0];
            $l2 = $arrayLetras[1];
            $l3 = $arrayLetras[2];
            $ixl1 = array_search($l1, $array_letras);
            $ixl2 = array_search($l2, $array_letras);
            $ixl3 = array_search($l3, $array_letras);
            if ($numero >= 999999999) {
                $nuevoNumero = "000000000";
                if ($l3 == 'Z') {
                    $l3 = $array_letras[0];
                    if ($l2 == 'Z') {
                        $l2 = $array_letras[0];
                        if ($l1 == 'Z') {
                            return "F#AAA000000000"; // Reinicia toda la serie;
                        } else {
                            $l1 = $array_letras[$ixl1 + 1];
                        }
                    } else {
                        $l2 = $array_letras[$ixl2 + 1];
                    }
                } else {
                    $l3 = $array_letras[$ixl3 + 1];
                }
                $nuevoId = "F#" . $l1 . $l2 . $l3 . $nuevoNumero;
            } else {
                $nuevoId = "F#" . $l1 . $l2 . $l3;
                $zeros = (9 - strlen($numero + 1));
                $nuevoId .= str_repeat("0", $zeros);
                $nuevoId .= ($numero + 1);
            }
            return $nuevoId;
        } else {
            return "F#AAA000000000";
        }
    }

    public function generateIdInDB() {
        $newId = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $resultado = $conexion->query(PreparedSQL::get_new_factura_id);
            $newId = $resultado->fetch_array()["NEW_ID"];
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $newId;
    }

}
