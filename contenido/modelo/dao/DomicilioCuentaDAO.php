<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DomicilioCuentaDAO
 *
 * @author Josué Francisco
 */
//include_once 'Conexion.php';
//include_once 'DomicilioCuentaDTO.php';
//include_once 'PreparedSQL.php';

final class DomicilioCuentaDAO implements DAOPaginable{

    private $db;
    private static $tipoDocumento = "CUENTA_TIPO_DOCUMENTO";
    private static $numDocumento = "CUENTA_NUM_DOCUMENTO";
    private static $direccion = "DIRECCION";
    private static $telefono = "TELEFONO";
    private static $barrio = "BARRIO";
    private static $localidad = "LOCALIDAD";
    private static $correoPostal = "CORREO_POSTAL";

    public function __construct() {
        $this->db = Conexion::getInstance();
    }

    private function resultToArray(mysqli_result $resultado) {
        $tablaDomicilio = [];
        while ($fila = $resultado->fetch_array()) {
            $domicilio = new DomicilioCuentaDTO();
            $domicilio->setCuentaTipoDocumento($fila[self::$tipoDocumento]);
            $domicilio->setCuentaNumDocumento($fila[self::$numDocumento]);
            $domicilio->setDireccion($fila[self::$direccion]);
            $domicilio->setTelefono($fila[self::$telefono]);
            $domicilio->setBarrio($fila[self::$barrio]);
            $domicilio->setLocalidad($fila[self::$localidad]);
            $domicilio->setCorreoPostal($fila[self::$correoPostal]);
            $tablaDomicilio[] = $domicilio;
        }
        return $tablaDomicilio;
    }

    private function resultToObject(mysqli_result $resultado) {
        $resultado->data_seek(0);
        $fila = $resultado->fetch_array();
        $domicilio = new DomicilioCuentaDTO();
        $domicilio->setCuentaTipoDocumento($fila[self::$tipoDocumento]);
        $domicilio->setCuentaNumDocumento($fila[self::$numDocumento]);
        $domicilio->setDireccion($fila[self::$direccion]);
        $domicilio->setTelefono($fila[self::$telefono]);
        $domicilio->setBarrio($fila[self::$barrio]);
        $domicilio->setLocalidad($fila[self::$localidad]);
        $domicilio->setCorreoPostal($fila[self::$correoPostal]);
        return $domicilio;
    }

    public function insert(DomicilioCuentaDTO $domicilio) {
        $rta = 0;
        $tipDoc = $domicilio->getCuentaTipoDocumento();
        $numDoc = $domicilio->getCuentaNumDocumento();
        $direccion = $domicilio->getDireccion();
        $tel = $domicilio->getTelefono();
        $barrio = $domicilio->getBarrio();
        $localidad = $domicilio->getLocalidad();
        $corPost = $domicilio->getCorreoPostal();
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::domicilio_insert);
            $stmt->bind_param("sssssss", $tipDoc, $numDoc, $direccion, $tel, $barrio, $localidad, $corPost);
            $stmt->execute();
            $rta = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function update(DomicilioCuentaDTO $domicilio) {
        $rta = 0;
        $tipDoc = $domicilio->getCuentaTipoDocumento();
        $numDoc = $domicilio->getCuentaNumDocumento();
        $direccion = $domicilio->getDireccion();
        $tel = $domicilio->getTelefono();
        $barrio = $domicilio->getBarrio();
        $localidad = $domicilio->getLocalidad();
        $corPost = $domicilio->getCorreoPostal();
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::domicilio_update);
            $stmt->bind_param("sssssss", $direccion, $tel, $barrio, $localidad, $corPost, $tipDoc, $numDoc);
            $stmt->execute();
            $rta = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function delete(DomicilioCuentaDTO $domicilio) {
        $rta = 0;
        $tipDoc = $domicilio->getCuentaTipoDocumento();
        $numDoc = $domicilio->getCuentaNumDocumento();
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::domicilio_delete);
            $stmt->bind_param("ss", $tipDoc, $numDoc);
            $stmt->execute();
            $rta = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function find(DomicilioCuentaDTO $domicilioFind) {
        $domicilio = NULL;
        $tipDoc = $domicilioFind->getCuentaTipoDocumento();
        $numDoc = $domicilioFind->getCuentaNumDocumento();
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::domicilio_find);
            $stmt->bind_param("ss", $tipDoc, $numDoc);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $domicilio = $this->resultToObject($resultado);
            }
            $stmt->close();
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $domicilio;
    }

    public function findAll() {
        $tablaDomicilio = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $resultado = $conexion->query(PreparedSQL::domicilio_find_all);
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $tablaDomicilio = $this->resultToArray($resultado);
            }
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $tablaDomicilio;
    }
    public function findByPaginationLimit($inicio, $cantidad){
        
    }

}
