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

    public static function generateRandomText($size) {
        $allChars = "ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvwxyz1234567890*/!@-+=()&%#|_-{}?<>";
//        $letras = "ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvwxyz";
//        $numeros = "1234567890";
//        $especial = "*/\!@-+=()&%$#|_-{}?<>";
        $lenAll = strlen($allChars);
        $txtRta = "";
        $arrayAll = str_split($allChars);
//        $arrayletras = str_split($letras);
//        $arraynums = str_split($numeros);
        for ($i = 1; $i <= $size; $i++) {
            $idxR = rand(0, ($lenAll - 1));
            $txtRta .= $arrayAll[$idxR];
        }
        return $txtRta;
    }

    public function AES_Encript($string, $key) {
        try {
            $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM);
            mcrypt_generic_init($td, $key, $iv);
            $encrypted_data_bin = mcrypt_generic($td, $string);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
            $encrypted_data_hex = bin2hex($iv) . bin2hex($encrypted_data_bin);
            return $encrypted_data_hex;
        } catch (Exception $ex) {
            return null;
        }
    }

    public function AES_Decript($encrypted_data_hex, $key) {
        try {
            $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv_size_hex = mcrypt_enc_get_iv_size($td) * 2;
            $iv = pack("H*", substr($encrypted_data_hex, 0, $iv_size_hex));
            $encrypted_data_bin = pack("H*", substr($encrypted_data_hex, $iv_size_hex));
            mcrypt_generic_init($td, $key, $iv);
            $decrypted = mdecrypt_generic($td, $encrypted_data_bin);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
            return $decrypted;
        } catch (Exception $exc) {
            return null;
        }
    }

}
