<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PagoDAO
 *
 * @author Josué Francisco
 */
//include_once 'Conexion.php';
//include_once 'PreparedSQL.php';
//include_once 'PagoDTO.php';

final class PagoDAO implements DAOPaginable{

    private $db;
    private static $idFactura = "FACTURA_ID_FACTURA";
    private static $tipoPago = "TIPO_PAGO";
    private static $valor = "VALOR";
    private static $numeroCuenta = "NUMERO_CUENTA";
    private static $numeroTarjeta = "NUMERO_TARJETA";

    const P_EFECTIVO = "EFECTIVO";
    const P_TAR_CREDITO = "TARJETA DE CRÉDITO";
    const P_TAR_DEBITO = "TARJETA DÉBITO";
    const P_PAYPAL = "PAGO_POR_PAYPAL";
    const P_TRANS_BANCA = "TRANSACCION BANCARIA";
    const P_CONTRA_ENTR = "CONTRAENTREGA";
    const P_CHEQUE = "PAGO CON CHEQUE";

    public function __construct() {
        $this->db = Conexion::getInstance();
    }

    private function resultToObject(mysqli_result $resultado) {
        $fila = $resultado->fetch_array();
        $pago = new PagoDTO();
        $pago->setFacturaIdFactura($fila[self::$idFactura]);
        $pago->setTipoPago($fila[self::$tipoPago]);
        $pago->setValor($fila[self::$valor]);
        $pago->setNumeroCuenta($fila[self::$numeroCuenta]);
        $pago->setNumeroTarjeta($fila[self::$numeroTarjeta]);
        return $pago;
    }

    private function resultToArray(mysqli_result $resultado) {
        $pagosFd = [];
        while ($fila = $resultado->fetch_array()) {
            $pago = new PagoDTO();
            $pago->setFacturaIdFactura($fila[self::$idFactura]);
            $pago->setTipoPago($fila[self::$tipoPago]);
            $pago->setValor($fila[self::$valor]);
            $pago->setNumeroCuenta($fila[self::$numeroCuenta]);
            $pago->setNumeroTarjeta($fila[self::$numeroTarjeta]);
            $pagosFd[] = $pago;
        }
        return $pagosFd;
    }

    public function insert(PagoDTO $pago) {
        $idFactura = $pago->getFacturaIdFactura();
        $tipoPago = $pago->getTipoPago();
        $valor = $pago->getValor();
        $numCuenta = $pago->getNumeroCuenta();
        $numTarjeta = $pago->getNumeroTarjeta();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::pago_insert);
            $stmt->bind_param("ssdss", $idFactura, $tipoPago, $valor, $numCuenta, $numTarjeta);
            $stmt->execute();
            $res = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $res;
    }

    public function update(PagoDTO $pago) {
        $idFactura = $pago->getFacturaIdFactura();
        $tipoPago = $pago->getTipoPago();
        $valor = $pago->getValor();
        $numCuenta = $pago->getNumeroCuenta();
        $numTarjeta = $pago->getNumeroTarjeta();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::pago_update);
            $stmt->bind_param("sdsss", $tipoPago, $valor, $numCuenta, $numTarjeta, $idFactura);
            $stmt->execute();
            $res = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $res;
    }

    public function delete(PagoDTO $pago) {
        $idFactura = $pago->getFacturaIdFactura();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::pago_delete);
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

    public function find(PagoDTO $pago) {
        $idFactura = $pago->getFacturaIdFactura();
        $pagoFd = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::pago_find);
            $stmt->bind_param("s", $idFactura);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows != 0) {
                $pagoFd = $this->resultToObject($resultado);
            }
            $resultado->close();
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $pagoFd;
    }

    public function findAll() {
        $pagosFD = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $resultado = $conexion->query(PreparedSQL::pago_find_all);
            if ($resultado->num_rows != 0) {
                $pagosFD = $this->resultToArray($resultado);
            }
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $pagosFD;
    }
    public function findByPaginationLimit($inicio, $cantidad){
        
    }

}
