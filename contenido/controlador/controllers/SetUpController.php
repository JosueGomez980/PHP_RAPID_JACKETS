<?php

/*
 * To change this license header, choose Licens;e Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SetUpController
 *
 * @author JosueFrancisco
 */
//include_once 'cargar_clases3.php';
//
//AutoCarga3::init();

class SetUpController {

    private $resetDB = "DROP DATABASE IF EXISTS RAPID_JACKETS ; CREATE DATABASE IF NOT EXISTS RAPID_JACKETS ;";
    private $rutaTablas = "modelo/setup_db.sql";
    private $db = null;


    public function __construct() {
        $this->db = Conexion::getInstance();
        $this->db instanceof Conexion;
    }

    public  function existeTabla($nameTable) {
        $sql = "SHOW TABLES LIKE '" . $nameTable . "' ;";
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $resultado = $conexion->query($sql);
            $resultado instanceof mysqli_result;
            return ($resultado->num_rows == 1);
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return false;
    }

    private function resetDB() {
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            if ($conexion->query($this->resetDB)) {
                $conexion->close();
                return true;
            }
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return false;
    }

    public function runScriptSetUp() {
        $ok = true;
        try {
            $stringSQL = file_get_contents($this->rutaTablas);
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            if (!$conexion->multi_query($stringSQL)) {
                $ok = false;
                echo($conexion->error);
            } else {
                echo($conexion->info);
            }
            $conexion instanceof mysqli;
            $conexion->close();
            return $ok;
        } catch (Exception $ex) {
            echo($ex->getMessage());
            return false;
        }
        return false;
    }

}
