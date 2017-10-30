<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Josué Francisco
 */
interface Validable {

    public function validaPK(EntityDTO $entidad);

    public function validaFK(EntityDTO $entidad);
}

final class Validador {

//Si el texto no tiene nada o sea vale = "" entonces lo cambia a NULL
    public static function nullable($str) {
        if ($str === "" || is_null($str)) {
            $str = NULL;
        }
        return $str;
    }

    public static function validaText($texto, $minlg, $maxlg) {
        $ok = TRUE;
        if (empty($texto)) {
            $ok = FALSE;
        }
        if (strlen($texto) > $maxlg || strlen($texto) < $minlg) {
            $ok = FALSE;
        }
        return $ok;
    }

    public static function validaInteger($entero) {
        $r = false;
        if (filter_var($entero, FILTER_VALIDATE_INT) === 0 || !filter_var($entero, FILTER_VALIDATE_INT) === false) {
            $r = true;
        }
        return $r;
    }

    public static function validaFloat($double) {
        $r = false;
        if (filter_var($double, FILTER_VALIDATE_FLOAT)) {
            $r = true;
        }
        return $r;
    }

    public static function validaEmail($email) {
        $r = false;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $r = true;
        }
        return $r;
    }

    public static function validaUserName($userName) {
        $r = TRUE;
        $arr = str_split($userName);
        if (strlen($userName) < 8) {
            $r = FALSE;
        }
        $cont = 0;
        for ($i = 0; $i < count($arr); $i++) {
            if (self::validaInteger($arr[$i])) {
                $cont++;
            }
        }
        if ($cont < 3) {
            $r = FALSE;
        }
        return $r;
    }

    public static function validaNumDoc($numDoc) {
        $ok = TRUE;
        $numArray = str_split($numDoc);
        if (strlen($numDoc) < 7 || strlen($numDoc) >= 13) {
            $ok = FALSE;
        }
        for ($i = 0; $i < count($numArray); $i++) {
            if (!self::validaInteger($numArray[$i])) {
                $ok = FALSE;
                break;
            }
        }
        return $ok;
    }

    public static function validaTel($telefono, $min, $max) {
        $ok = TRUE;
        if (strlen($telefono) < $min || strlen($telefono) > $max) {
            $ok = FALSE;
        }
        
        $telArray = str_split($telefono);
        for ($i = 0; $i < count($telArray); $i++) {
            if (!self::validaInteger($telArray[$i])) {
                $ok = FALSE;
                break;
            }
        }
        return $ok;
    }
    public static function validaTel2($telefono, $min, $max){
        $ok = true;
        if(!self::validaTel($telefono, 10, 10) || (!self::validaTel($telefono, 7, 7))){
            $ok = false;
        }
        if(!preg_match("/^[0-9]{7,10}$/", $telefono)){
            $ok = false;
        }
        return $ok;
    }

    public static function fixTexto($texto) {
        $salida = htmlspecialchars($texto);
        $salida = trim($salida);
        $salida = filter_var($salida, FILTER_SANITIZE_STRING);
        return $salida;
    }

    public static function validaPassword($password) {
        $r = TRUE;
        $arr = str_split($password);
        if (strlen($password) < 8) {
            $r = FALSE;
        }
        $cont = 0;
        for ($i = 0; $i < count($arr); $i++) {
            if (self::validaInteger($arr[$i])) {
                $cont++;
            }
        }
        if ($cont < 3) {
            $r = FALSE;
        }
        return $r;
    }

    public static function formatPesos($dinero) {
        $pesos = number_format($dinero, 2, ',', '.');
        return "$ " . $pesos;
    }

    public static function textoParaBuscar($text) {
        $salida = trim($text);
        $salida = strtolower($salida);
        return $salida;
    }

}
