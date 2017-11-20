<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CuentaRescueDAO
 *
 * @author JosueFrancisco
 */
class CuentaRescueDAO implements GenericDAO {

    private $db;
    private static $instancia = null;
    private static $us_id_us = "USUARIO_ID_USUARIO";
    private static $est = "ESTADO";
    private static $code = "CODIGO";
    private static $token = "TOKEN";
    private static $last_rec = "LAST_RECOVER";

    const EST_LP = "LOST_PASSWORD";
    const EST_RP = "RESCUED_PASSWORD";
    const EST_AT = "ACCOUNT_TIME_OUT";

    public function __construct() {
        $this->db = new Conexion();
    }

    public function delete(EntityDTO $entidad) {
        $entidad instanceof CuentaRescueDTO;
        $userId = $entidad->getUsuarioIdUsuario();
        $rta = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::cueta_res_delete);
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $rta = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function find(EntityDTO $entidad) {
        $entidad instanceof CuentaRescueDTO;
        $cueResFinded = NULL;
        $userId = $entidad->getUsuarioIdUsuario();
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::cueta_res_find);
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                $cueResFinded = $this->resultToObject($resultado);
            }
            $stmt->close();
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $cueResFinded;
    }

    public function findAll() {
        $tablaCuentaRescue = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $resultado = $conexion->query(PreparedSQL::cueta_res_find_all);
            if ($resultado->num_rows > 0) {
                $tablaCuentaRescue = $this->resultToArray($resultado);
            }
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $tablaCuentaRescue;
    }

    public function insert(EntityDTO $entidad) {
        $entidad instanceof CuentaRescueDTO;
        $userId = $entidad->getUsuarioIdUsuario();
        $codigo = $entidad->getCodigo();
        $token = $entidad->getToken();
        $rta = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::cueta_res_insertA);
            $stmt->bind_param("sss", $userId, $codigo, $token);
            $stmt->execute();
            $rta = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function insert2(EntityDTO $entidad) {
        $entidad instanceof CuentaRescueDTO;
        $userId = $entidad->getUsuarioIdUsuario();
        $estado = $entidad->getEstado();
        $codigo = $entidad->getCodigo();
        $token = $entidad->getToken();
        $lastRecover = $entidad->getLastRecover();
        $rta = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::cueta_res_insertB);
            $stmt->bind_param("sssss", $userId, $estado, $codigo, $token, $lastRecover);
            $stmt->execute();
            $rta = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function resultToArray(mysqli_result $resultado) {
        $tablaCuentaRes = array();
        while ($fila = $resultado->fetch_array()) {
            $cuentaRes = new CuentaRescueDTO();
            $cuentaRes->setUsuarioIdUsuario($fila[self::$us_id_us]);
            $cuentaRes->setEstado($fila[self::$est]);
            $cuentaRes->setCodigo($fila[self::$code]);
            $cuentaRes->setToken($fila[self::$token]);
            $cuentaRes->setLastRecover($fila[self::$last_rec]);
            $tablaCuentaRes[] = $cuentaRes;
        }
        return $tablaCuentaRes;
    }

    public function resultToObject(mysqli_result $resultado) {
        $fila = $resultado->fetch_array();
        $cuentaRes = new CuentaRescueDTO();
        $cuentaRes->setUsuarioIdUsuario($fila[self::$us_id_us]);
        $cuentaRes->setEstado($fila[self::$est]);
        $cuentaRes->setCodigo($fila[self::$code]);
        $cuentaRes->setToken($fila[self::$token]);
        $cuentaRes->setLastRecover($fila[self::$last_rec]);
        return $cuentaRes;
    }

    public function update(EntityDTO $entidad) {
        $entidad instanceof CuentaRescueDTO;
        $rta = 0;
        $userId = $entidad->getUsuarioIdUsuario();
        $estado = $entidad->getEstado();
        $codigo = $entidad->getCodigo();
        $token = $entidad->getToken();
        $ltReco = $entidad->getLastRecover();
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::cueta_res_update);
            $stmt->bind_param("sssss", $estado, $codigo, $token, $ltReco, $userId);
            $stmt->execute();
            $rta = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public static function getInstancia() {
        if (is_null(self::$instancia)) {
            self::$instancia = new CuentaRescueDAO();
        }
        return self::$instancia;
    }

}
