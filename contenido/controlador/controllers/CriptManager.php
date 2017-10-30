<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CriptManager
 *
 * @author Josué Francisco
 */
final class CriptManager {

    private static $instacia = NULL;
    private $opciones = array();
    private $costo;

    function __construct() {
        $this->costo = self::obtenerCosto();
    }

    public static function getInstacia() {
        if (is_null(self::$instacia)) {
            self::$instacia = new CriptManager();
        }
        return self::$instacia;
    }

    public function getOpciones() {
        return $this->opciones;
    }

    public function getCosto() {
        return $this->costo;
    }

    public function setOpciones(array $opciones) {
        $this->opciones = $opciones;
    }

    public function setCosto($costo) {
        $this->costo = $costo;
        $this->opciones['cost'] = $this->costo;
    }

    public static function encodeA($data) {
        
    }

    public static function obtenerCosto() {
        $timeTarget = 0.5; // 0.5 segundos 

        $coste = 8;
        do {
            $coste++;
            $inicio = microtime(true);
            password_hash("test", PASSWORD_DEFAULT, ["cost" => $coste]);
            $fin = microtime(true);
        } while (($fin - $inicio) < $timeTarget);
        return $coste;
    }

    public function oldEncript($password) {
        $hash = crypt($password, CRYPT_MD5);
        return $hash;
    }

    public function simpleEncriptDF($password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $hash;
    }

    public function simpleEncriptBF($password) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        return $hash;
    }

    public function complexEncriptDF($password) {
        $hash = password_hash($password, PASSWORD_DEFAULT, $this->opciones);
        return $hash;
    }

    public function complexEncriptBF($password) {
        $hash = password_hash($password, PASSWORD_BCRYPT, $this->opciones);
        return $hash;
    }

    public function verificaPassword($pass_hashed, $password) {
        if (password_verify($password, $pass_hashed)) {
            return true;
        } else {
            return false;
        }
    }

    public function verificaOldPassword($password, $pass_hashed) {
        $hash = $this->oldEncript($password);
        if ($pass_hashed === $hash) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function urlVarEncript($urlVar) {
        $array = str_split($urlVar);
        $ascci_str = "";
        for ($index = 0; $index < count($array); $index++) {
            $ascci_str .= (ord($array[$index]) . "|");
        }
        return base64_encode($ascci_str);
    }

    public static function urlVarDecript($urlVar) {
        $urlVar = base64_decode($urlVar);
        $array = explode("|", $urlVar);
        $url = "";
        for ($index = 0; $index < count($array); $index++) {
            $url .= (chr((int) $array[$index]));
        }
        return trim($url);
    }

}
