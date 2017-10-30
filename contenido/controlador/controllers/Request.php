<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Request
 *
 * @author Josué Francisco
 */
abstract class Request {

    protected $proceso = "";
    public static $method = null;

    public function __construct() {
        if (isset($_REQUEST['proceso'])) {
            $this->setProceso(filter_input(INPUT_REQUEST, "proceso"));
        }
        switch (self::getMethod()) {
            case "GET" : {
                    $this->doGet();
                    break;
                }
            case "POST" : {
                    $this->doPost();
                    break;
                }
            case "HEAD" : {
                    $this->doHead();
                    break;
                }
            case "PUT" : {
                    $this->doPut();
                    break;
                }
            case "DELETE" : {
                    $this->doDelete();
                    break;
                }
            default : {
                    $this->doRequest();
                    break;
                }
        }
    }
//Este metodo es el que detecta cual es el metodo de envio y lo retorna para que el contructor decida que metodo va a llamar pero en sus clases hijas
    public static function getMethod() {
        self::$method = $_SERVER["REQUEST_METHOD"]; //Esta linea obtiene el tipo de metodo de envio (GET, POST, PUT, REQUEST)
        return self::$method;
    }

    public static function isGet() {

        if (self::getMethod() == "GET") {
            return true;
        } else {
            return false;
        }
    }

    public static function isPost() {
        if (self::getMethod() == "POST") {
            return true;
        } else {
            return false;
        }
    }

    public static function isPut() {
        if (self::getMethod() == "PUT") {
            return true;
        } else {
            return false;
        }
    }

    public static function isDelete() {
        if (self::getMethod() == "DELETE") {
            return true;
        } else {
            return false;
        }
    }

    public function getProceso() {
        return $this->proceso;
    }

    public function setProceso($proceso) {
        $this->proceso = $proceso;
    }
//Estas son abstractas porque cada clase que herede de Request implementa su forma de recabar los datos.

    public abstract function doGet(); //Metodo GET

    public abstract function doPost(); // Metodo POST

    public abstract function doPut(); //... PUT (Para archivos)

    public abstract function doDelete(); // Ya o se usa pero esta ahi por si acaso

    public abstract function doHead(); // Header del documento ocultos..

    public abstract function doRequest(); // Metodo REQUEST (Incluye POST y GET)
}

