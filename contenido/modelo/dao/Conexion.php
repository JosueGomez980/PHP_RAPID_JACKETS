<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conexion
 *
 * @author Josué Francisco
 */
final class Conexion {

    private $usuario = "root";
    private $host = "localhost";
    private $password = "";
    private $baseDatos = "RAPID_JACKETS";
    private $puerto;
    private static $instancia = null;
    private static $conexion;

    public function __construct() {
        
    }

    public static function getInstance() {
        if (is_null(self::$instancia)) {
            self::$instancia = new Conexion();
        }
        return self::$instancia;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getHost() {
        return $this->host;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getBaseDatos() {
        return $this->baseDatos;
    }

    public function getPuerto() {
        return $this->puerto;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setBaseDatos($baseDatos) {
        $this->baseDatos = $baseDatos;
    }

    public function setPuerto($puerto) {
        $this->puerto = $puerto;
    }

    //Crear la conexion. Retorna una nueva instancia de mysqli cada vez que se ejecuta
    public function creaConexion() {
        try {
            $conexion = new mysqli($this->host, $this->usuario, $this->password, $this->baseDatos);
            if ($conexion != null) {
                return($conexion);
            } else {
                return(NULL);
            }
        } catch (mysqli_sql_exception $e) {
            echo ("La conexion a la base de datos no se pudo crear por el siguiente error <br> " . $e->getMessage());
        }
    }
    //Metodo que hace referencia al patron singleton que retorna una sola instancia de la conexion. Util para mantener una conexion persistente.
    //Durante toda la ejecucion no se puede invocar al metodo void close() de mysqli 
    public static function getConexion() {
        if (is_null(self::$conexion)) {
            self::$conexion = self::getInstance()->creaConexion();
        }
        return self::$conexion;
    }

    //Metodo para obtener la fecha actual MySQL DATE

    public static function getSQLDate() {
        date_default_timezone_set("America/Bogota");
        $fecha = date("Y-m-d");
        return($fecha);
    }

    //Metodo para obtener una fecha MySQL DATETIME
    public static function getSQlDateTime() {
        date_default_timezone_set("America/Bogota");
        $fecha = date("Y-m-d H:i:s");
        return($fecha);
    }

}
