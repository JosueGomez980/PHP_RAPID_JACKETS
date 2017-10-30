<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CookieManager
 *
 * @author JosueFrancisco
 */
class CookieManager {

    public static $MIN;
    public static $HORA;
    public static $DIA;
    public static $SEMANA;
    public static $MES;
    public static $ANIO;
    public static $instance = null;

    const LIMIT_FAC = "LIMITE_DE_FACTURAS_POR_USER";

    public function __construct() {
        self::$HORA = time() + 3600;
        self::$MIN = time() + 60;
        self::$DIA = time() + 3600 * 24;
        self::$SEMANA = time() + 3600 * 24 * 7;
        self::$MES = time() + self::$SEMANA * 4;
        self::$ANIO = self::$DIA * 365;
    }

    public static function getInstancia() {
        if (is_null(self::$instance)) {
            self::$instance = new CookieManager();
        }
        return self::$instance;
    }

    public function add($nombre, $valor, $tiempo) {
        if (is_object($valor)) {
            $serializedObjet = serialize($valor);
            setcookie($nombre, $serializedObjet, $tiempo);
        } else {
            setcookie($nombre, $valor, $tiempo);
        }
    }

    public function addEntidad(EntityDTO $entidad, $nombre, $tiempo) {
        $serializedEntidad = json_encode($entidad);
        setcookie($nombre, $serializedEntidad, $tiempo);
    }

    public function destroy() {
        unset($_COOKIE);
    }

    public function existe($name) {
        if (isset($_COOKIE[$name])) {
            return true;
        } else {
            return false;
        }
    }

    public function get($name) {
        if ($this->existe($name)) {
            if (is_object(@unserialize($_COOKIE[$name]))) {
                return unserialize($_COOKIE[$name]);
            } else {
                return $_COOKIE[$name];
            }
        } else {
            return null;
        }
    }

    public function getAll() {
        $todo = array();
        foreach ($_COOKIE as $value) {
            if (is_object(unserialize($value))) {
                $todo[] = unserialize($value);
            } else {
                $todo[] = $value;
            }
        }
        return $todo;
    }

    public function getEntidad($name) {
        if ($this->existe($name)) {
            $entidad = json_decode($_COOKIE[$name]);
            return $entidad;
        } else {
            return null;
        }
    }

    public function remove($name) {
        
        if ($this->existe($name)) {
            unset($_COOKIE[$name]);
            setcookie($name, null, time() - 100);
        }
    }

    public function removeEntidad($name) {
        if ($this->existe($name)) {
            unset($_COOKIE[$name]);
            setcookie($name, null, time() - 100);
        }
    }

}
