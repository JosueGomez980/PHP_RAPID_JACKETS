<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileUpload
 *
 * @author Josué Francisco
 */
include_once 'cargar_clases3.php';
AutoCarga3::init();

abstract class FileUpload {

    //Listado d e tamaños permitidos
    const UN_KB = 1000;
    const DIEZ_KB = 10000;
    const CIEN_KB = 100000;
    const MEDIO_MB = 500000;
    const UN_MB = 1000000;
    const DOS_MB = 2000000;
    //Listado de directorios de subida
    const PRO_IMG_DIR_A = "../uploads/productos_img/";
    const PRO_IMG_DIR_B = "../../../uploads/productos_img/";
    const PRO_FULL_IMG_DIR_A = "../uploads/productos_img_full/";
    const PRO_FULL_IMG_DIR_B = "../../../uploads/productos_img_full/";
    //Listado de posibles tipos de subida
    const IMAGE_PNG = "png";
    const IMAGE_JPG = "jpg";
    const IMAGE_JPEG = "jpeg";
    const IMAGE_GIF = "gif";
    const IMAGE_BMP = "bmp";
    const FILE_CVS = "cvs";
    const FILE_TXT = "txt";
    const FILE_JSON = "json";

    public static $ALL_IMG = array("png", "jpg", "jpeg", "gif", "bmp");
    public static $ALL_PLAIN = array("txt", "ini", "config", "file", "inc");
    protected $nameOfInputFile = "";
    protected $temporalNombre = "";
    protected $clienteNombre = "";
    protected $finalNombre = "";
    protected $tipo = "";
    protected $rutaTemporal = "";
    protected $rutaFinal = "";
    protected $tamanio = "";
    protected $rutaFinalFull = "";
    protected $rutaCompletaParaMostrar = "";
    protected $rutaParaMostrar = "";
    protected $errorNumber = 0;
    protected $errorMessage = "";

    public function __construct($nameOFInputFile) {
        if (isset($_FILES[$nameOFInputFile])) {
            $this->nameOfInputFile = $nameOFInputFile;
            $this->clienteNombre = basename($_FILES[$nameOFInputFile]["name"]);
            $this->temporalNombre = basename($_FILES[$nameOFInputFile]["tmp_name"]);
            $this->rutaTemporal = $_FILES[$nameOFInputFile]["tmp_name"];
            $this->tipo = strtolower(pathinfo($_FILES[$nameOFInputFile]["name"], PATHINFO_EXTENSION));
            $this->tamanio = ($_FILES[$nameOFInputFile]["size"]);
            $this->errorNumber = (int) $_FILES[$nameOFInputFile]["error"];
            $this->errorMessage = $this->obtenerError($this->errorNumber);
        }
    }

    public function getClienteNombre() {
        return $this->clienteNombre;
    }

    public function setClienteNombre($clienteNombre) {
        $this->clienteNombre = $clienteNombre;
    }

    public function getTemporalNombre() {
        return $this->temporalNombre;
    }

    public function getFinalNombre() {
        return $this->finalNombre;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getTamanio() {
        return $this->tamanio;
    }

    public function setTemporalNombre($temporalNombre) {
        $this->temporalNombre = $temporalNombre;
    }

    public function setFinalNombre($finalNombre) {
        $this->finalNombre = $finalNombre . "." . $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setTamanio($tamanio) {
        $this->tamanio = (int) $tamanio;
    }

    public function getRutaTemporal() {
        return $this->rutaTemporal;
    }

    public function getRutaFinal() {
        return $this->rutaFinal;
    }

    public function setRutaTemporal($rutaTemporal) {
        $this->rutaTemporal = $rutaTemporal;
    }

    public function setRutaFinal($rutaFinal) {
        $this->rutaFinal = $rutaFinal;
    }

    public function getNameOfInputFile() {
        return $this->nameOfInputFile;
    }

    public function getRutaFinalFull() {
        return $this->rutaFinalFull;
    }

    public function setNameOfInputFile($nameOfInputFile) {
        $this->nameOfInputFile = $nameOfInputFile;
    }

    public function setRutaFinalFull($rutaFinalFull) {
        $this->rutaFinalFull = $rutaFinalFull;
    }

    public function getRutaCompletaParaMostrar() {
        return $this->rutaCompletaParaMostrar;
    }

    public function getRutaParaMostrar() {
        return $this->rutaParaMostrar;
    }

    public function setRutaCompletaParaMostrar($rutaCompletaParaMostrar) {
        $this->rutaCompletaParaMostrar = $rutaCompletaParaMostrar;
    }

    public function setRutaParaMostrar($rutaParaMostrar) {
        $this->rutaParaMostrar = $rutaParaMostrar;
        $this->rutaCompletaParaMostrar = $rutaParaMostrar . $this->finalNombre;
    }
    public function getErrorNumber() {
        return $this->errorNumber;
    }

    public function getErrorMessage() {
        return $this->errorMessage;
    }

    public function setErrorNumber($errorNumber) {
        $this->errorNumber = $errorNumber;
    }

    public function setErrorMessage($errorMessage) {
        $this->errorMessage = $errorMessage;
    }

    
    public function validaTamanio($max_tamanio) {
        $ok = FALSE;
        if ($this->tamanio <= $max_tamanio) {
            $ok = TRUE;
        }
        return $ok;
    }

    public function validaTipo($tipoArchivo) {
        $ok = FALSE;
        if (is_array($tipoArchivo)) {
            foreach ($tipoArchivo as $tip) {
                if (strtolower($this->tipo) == strtolower($tip)) {
                    $ok = TRUE;
                    break;
                }
            }
        } else {
            if ($this->tipo == $tipoArchivo) {
                $ok = TRUE;
            }
        }
        return $ok;
    }

    public function validaUnico() {
        $ok = FALSE;
        $ruta = $this->rutaFinal . $this->finalNombre;
        if ($this->finalNombre != "" && $this->rutaFinal != "") {
            $ok = (!file_exists($ruta));
        }
        return $ok;
    }

    public function existeFileToUpload() {
        $ok = FALSE;
        if (isset($_FILES[$this->nameOfInputFile])) {
            $ok = TRUE;
            if (empty($_FILES[$this->nameOfInputFile]["name"])) {
                $ok = FALSE;
            }
        }
        return $ok;
    }

    public function subir() {
        $ok = FALSE;

        if ($this->finalNombre != "" && $this->rutaFinal != "") {
            $this->rutaFinalFull = $this->rutaFinal . $this->finalNombre;
            $ok = move_uploaded_file($this->rutaTemporal, $this->rutaFinalFull);
        }
        return $ok;
    }

    public function obtenerError($errorNumero) {
        $mensajeError = "";
        if (is_int($errorNumero)) {
            switch ($errorNumero) {
                //Valor: 0; No hay error, fichero subido con éxito.
                case UPLOAD_ERR_OK:
                    $mensajeError = "EL ARCHIVO FUE SUBIDO CON EXITO";
                    break;
                // Valor: 1; El fichero subido excede la directiva upload_max_filesize de php.ini. 
                case UPLOAD_ERR_INI_SIZE:
                    $mensajeError = "EL FICHERO EXCEDE EL TAMAÑO MAXIMO PERMITIDO POR EL SERVIDOR";
                    break;
                //Valor: 2; El fichero subido excede la directiva MAX_FILE_SIZE especificada en el formulario HTML. 
                case UPLOAD_ERR_FORM_SIZE:
                    $mensajeError = "EL FICHERO EXCEDE EL TAMAÑO MAXIMO PERMITIDO POR EL APLICATIVO";
                    break;
                //Valor: 3; El fichero fue sólo parcialmente subido. 
                case UPLOAD_ERR_PARTIAL:
                    $mensajeError = "EL FICHERO FUE SUBIDO DE FORMA INCOMPLETA";
                    break;
                //Valor: 4; No se subió ningún fichero. 
                case UPLOAD_ERR_NO_FILE:
                    $mensajeError = "NO SE PUDO SUBIR EL FICHERO - ERROR FATAL";
                    break;
                //Valor: 6; Falta la carpeta temporal. Introducido en PHP 5.0.3. 
                case UPLOAD_ERR_NO_TMP_DIR:
                    $mensajeError = "NO SE ENCONTRÓ LA CARPETA TEMPORAL";
                    break;
                //Valor: 7; No se pudo escribir el fichero en el disco. Introducido en PHP 5.1.0. 
                case UPLOAD_ERR_CANT_WRITE:
                    $mensajeError = "NO SE PUEDE GUARDAR EL ARCHIVO EN EL SERVIDOR";
                    break;
                //Valor: 8; Una extensión de PHP detuvo la subida de ficheros. PHP no proporciona una forma de determinar la extensión que causó la parada de la subida de ficheros; el examen de la lista de extensiones cargadas con phpinfo() puede ayudar. Introducido en PHP 5.2.0. 
                case UPLOAD_ERR_EXTENSION:
                    $mensajeError = "SE DESCONOCE LA FUENTE DEL ERROR";
                    break;
            }
        } else {
            return "ERROR NO ESPECIFICADO";
        }
        return $mensajeError;
    }
}
