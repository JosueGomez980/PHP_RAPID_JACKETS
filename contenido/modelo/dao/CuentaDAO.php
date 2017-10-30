<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CuentaDAO
 *
 * @author Josué Francisco
 */
//include_once 'Conexion.php';
//include_once 'CuentaDTO.php';
//include_once 'PreparedSQL.php';

final class CuentaDAO implements DAOPaginable {
    const TD_TI = "TARJETA DE IDENTIDAD";
    const TD_CC = "CEDULA DE CIUDADANIA";
    const TD_CEX = "CEDULA DE EXTRANJERIA";
    const TD_RC = "REGISTRO CIVIL";
    const TD_PST = "PASAPORTE";

    private $db;
    private static $instancia = NULL;
    private static $tipDoc = "TIPO_DOCUMENTO";
    private static $numDoc = "NUM_DOCUMENTO";
    private static $idUsuario = "USUARIO_ID_USUARIO";
    private static $primNombre = "PRIMER_NOMBRE";
    private static $secNombre = "SEGUNDO_NOMBRE";
    private static $primApell = "PRIMER_APELLIDO";
    private static $secApell = "SEGUNDO_APELLIDO";
    private static $telefono = "TELEFONO";

    public function __construct() {
        $this->db = Conexion::getInstance();
    }

    public static function getInstancia() {
        if (is_null(self::$instancia)) {
            self::$instancia = new CuentaDAO();
        }
        return self::$instancia;
    }

    private function resultToArray(mysqli_result $resultado) {
        $tablaCuenta = [];
        while ($fila = $resultado->fetch_array()) {
            $cuenta = new CuentaDTO();
            $cuenta->setTipoDocumento($fila[self::$tipDoc]);
            $cuenta->setNumDocumento($fila[self::$numDoc]);
            $cuenta->setUsuarioIdUsuario($fila[self::$idUsuario]);
            $cuenta->setPrimerNombre($fila[self::$primNombre]);
            $cuenta->setSegundoNombre($fila[self::$secNombre]);
            $cuenta->setPrimerApellido($fila[self::$primApell]);
            $cuenta->setSegundoApellido($fila[self::$secApell]);
            $cuenta->setTelefono($fila[self::$telefono]);
            $tablaCuenta[] = $cuenta;
        }
        return $tablaCuenta;
    }

    private function resultToObject(mysqli_result $resultado) {
        $resultado->data_seek(0);
        $fila = $resultado->fetch_array();
        $cuenta = new CuentaDTO();
        $cuenta->setTipoDocumento($fila[self::$tipDoc]);
        $cuenta->setNumDocumento($fila[self::$numDoc]);
        $cuenta->setUsuarioIdUsuario($fila[self::$idUsuario]);
        $cuenta->setPrimerNombre($fila[self::$primNombre]);
        $cuenta->setSegundoNombre($fila[self::$secNombre]);
        $cuenta->setPrimerApellido($fila[self::$primApell]);
        $cuenta->setSegundoApellido($fila[self::$secApell]);
        $cuenta->setTelefono($fila[self::$telefono]);
        return $cuenta;
    }

    public function insert(CuentaDTO $cuenta) {
        $tipDocumento = $cuenta->getTipoDocumento();
        $numDocumento = $cuenta->getNumDocumento();
        $idUser = $cuenta->getUsuarioIdUsuario();
        $priName = $cuenta->getPrimerNombre();
        $secName = $cuenta->getSegundoNombre();
        $priApe = $cuenta->getPrimerApellido();
        $secApe = $cuenta->getSegundoApellido();
        $tel = $cuenta->getTelefono();
        $rta = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::cuenta_insert);
            $stmt->bind_param("ssssssss", $tipDocumento, $numDocumento, $idUser, $priName, $secName, $priApe, $secApe, $tel);
            $stmt->execute();
            $rta = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function find(CuentaDTO $cuenta) {
        $tipDoc = $cuenta->getTipoDocumento();
        $numDoc = $cuenta->getNumDocumento();
        $cuentaFind = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::cuenta_find);
            $stmt->bind_param("ss", $tipDoc, $numDoc);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows != 0) {
                $cuentaFind = $this->resultToObject($resultado);
            }
            $stmt->close();
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $cuentaFind;
    }

    public function findByNumDoc($numeroDocumento) {
        $cuentaFind = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::cuenta_find_by_num_doc);
            $stmt->bind_param("s", $numeroDocumento);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows != 0) {
                $cuentaFind = $this->resultToObject($resultado);
            }
            $stmt->close();
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $cuentaFind;
    }

    public function findByUsuario(CuentaDTO $cuenta) {
        $usuarioCuenta = $cuenta->getUsuarioIdUsuario();
        $cuentaFind = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::cuenta_find_by_usuario);
            $stmt->bind_param("s", $usuarioCuenta);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows != 0) {
                $cuentaFind = $this->resultToObject($resultado);
            }
            $stmt->close();
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $cuentaFind;
    }

    public function findAll() {
        $tablaCuenta = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $resultado = $conexion->query(PreparedSQL::cuenta_find_all);
            if ($resultado->num_rows != 0) {
                $tablaCuenta = $this->resultToArray($resultado);
            }
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $tablaCuenta;
    }

    public function update(CuentaDTO $cuenta) {
        $tipDocumento = $cuenta->getTipoDocumento();
        $numDocumento = $cuenta->getNumDocumento();
        $priName = $cuenta->getPrimerNombre();
        $secName = $cuenta->getSegundoNombre();
        $priApe = $cuenta->getPrimerApellido();
        $secApe = $cuenta->getSegundoApellido();
        $tel = $cuenta->getTelefono();
        $rta = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::cuenta_update);
            $stmt->bind_param("sssssss", $priName, $secName, $priApe, $secApe, $tel, $tipDocumento, $numDocumento);
            $stmt->execute();
            $rta = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function delete(CuentaDTO $cuenta) {
        $tipDocumento = $cuenta->getTipoDocumento();
        $numDocumento = $cuenta->getNumDocumento();
        $rta = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::cuenta_delete);
            $stmt->bind_param("ss", $tipDocumento, $numDocumento);
            $stmt->execute();
            $rta = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function findByPaginationLimit($inicio, $cantidad) {
        
    }

}
