<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DateManager
 *
 * @author Josué Francisco
 */
final class DateManager {

    private static $instancia = NULL;
    private $date;
    private $zonaHoraria;

    const SQL_DATE = "Y-m-d";
    const SQL_DATETIME = "Y-m-d H:i:s";
    const SQL_TIME = "H:i:s";
    const HORA_AM_PM = "g:i a";
    const DIA_X_MES_ANO_1 = "l d - F, Y";
    const DIA_X_MES_ANO_2 = "D d - F, Y";
    const DIA_MES_ANO_1 = "d/m/Y";
    const DIA_MES_ANO_2 = "D d/M/Y";
    const FOR_PDF_NAME = "Y-m-d___H_i_s_B";
    const UTC = "U";

    function __construct() {
        $this->zonaHoraria = new DateTimeZone("America/Bogota");
        $this->date = new DateTime("now", $this->zonaHoraria);
    }

    public static function getInstance() {
        if (self::$instancia == NULL) {
            self::$instancia = new DateManager();
        }
        return self::$instancia;
    }

    private function update() {
        $this->date = new DateTime();
        $this->date->setTimeZone($this->zonaHoraria);
    }

    public function getSQLDate() {
        return $this->date->format(self::SQL_DATE);
    }

    public function getSQLTime() {
        return $this->date->format(self::SQL_TIME);
    }

    public function getSQLDateTime() {
        return $this->date->format(self::SQL_DATETIME);
    }

    public function stringToDate($s_fecha) {
        try {
            $fecha = new DateTime($s_fecha);
        } catch (Exception $exc) {
            echo $exc->getMessage();
            return NULL;
        }
        return $fecha;
    }

    public function formatNowDate($formato) {
        return $this->date->format($formato);
    }

    public function formatDate(DateTime $fecha, $formato) {
        return $fecha->format($formato);
    }

    public function getDate() {
        return $this->date;
    }

    public function getTime() {
        return $this->date->format(self::HORA_AM_PM);
    }

    public function dateSpa1() {
        $dia = "";
        $mes = "";
        $n_dia = $this->date->format("d");
        $anio = $this->date->format("Y");

        switch ($this->date->format("l")) {
            case "Monday":
                $dia = "Lunes";
                break;
            case "Tuesday":
                $dia = "Martes";
                break;
            case "Wednesday":
                $dia = "Miércoles";
                break;
            case "Thursday":
                $dia = "Jueves";
                break;
            case "Friday":
                $dia = "Viernes";
                break;
            case "Saturday":
                $dia = "Sábado";
                break;
            case "Sunday":
                $dia = "Domingo";
                break;
            default:
                $dia = "N/A";
                break;
        }
        switch ($this->date->format("F")) {
            case "January":
                $mes = "Enero";
                break;
            case "February":
                $mes = "Febrero";
                break;
            case "March":
                $mes = "Marzo";
                break;
            case "April":
                $mes = "Abril";
                break;
            case "May":
                $mes = "Mayo";
                break;
            case "June":
                $mes = "Junio";
                break;
            case "July":
                $mes = "Julio";
                break;
            case "August":
                $mes = "Agosto";
                break;
            case "September":
                $mes = "Septiembre";
                break;
            case "October":
                $mes = "Octubre";
                break;
            case "November":
                $mes = "Noviembre";
                break;
            case "December":
                $mes = "Diciembre";
                break;
            default :
                $mes = "N/A";
                break;
        }
        $fecha = $dia . " " . $n_dia . " de " . $mes . " del " . $anio . " - " . $this->getTime();
        return $fecha;
    }

    public function dateSpa2(DateTime $fechaL) {
        $dia = "";
        $mes = "";
        $n_dia = $fechaL->format("d");
        $anio = $fechaL->format("Y");

        switch ($fechaL->format("l")) {
            case "Monday":
                $dia = "Lunes";
                break;
            case "Tuesday":
                $dia = "Martes";
                break;
            case "Wednesday":
                $dia = "Miércoles";
                break;
            case "Thursday":
                $dia = "Jueves";
                break;
            case "Friday":
                $dia = "Viernes";
                break;
            case "Saturday":
                $dia = "Sábado";
                break;
            case "Sunday":
                $dia = "Domingo";
                break;
            default:
                $dia = "N/A";
                break;
        }
        switch ($fechaL->format("F")) {
            case "January":
                $mes = "Enero";
                break;
            case "February":
                $mes = "Febrero";
                break;
            case "March":
                $mes = "Marzo";
                break;
            case "April":
                $mes = "Abril";
                break;
            case "May":
                $mes = "Mayo";
                break;
            case "June":
                $mes = "Junio";
                break;
            case "July":
                $mes = "Julio";
                break;
            case "August":
                $mes = "Agosto";
                break;
            case "September":
                $mes = "Septiembre";
                break;
            case "October":
                $mes = "Octubre";
                break;
            case "November":
                $mes = "Noviembre";
                break;
            case "December":
                $mes = "Diciembre";
                break;
            default :
                $mes = "N/A";
                break;
        }
        $fecha = $dia . " " . $n_dia . " de " . $mes . " del " . $anio;
        return $fecha;
    }

}



