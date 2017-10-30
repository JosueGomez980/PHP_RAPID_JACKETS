<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CuentaDTO
 *
 * @author Josué Francisco
 */
//include_once 'EntityDTO.php';

final class CuentaDTO implements EntityDTO {

    private $tipoDocumento;
    private $numDocumento;
    private $usuarioIdUsuario;
    private $primerNombre;
    private $segundoNombre;
    private $primerApellido;
    private $segundoApellido;
    private $telefono;

    public function __construct() {
        
    }

    public function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    public function getNumDocumento() {
        return $this->numDocumento;
    }

    public function getUsuarioIdUsuario() {
        return $this->usuarioIdUsuario;
    }

    public function getPrimerNombre() {
        return $this->primerNombre;
    }

    public function setTipoDocumento($tipoDocumento) {
        $this->tipoDocumento = (string) $tipoDocumento;
    }

    public function setNumDocumento($numDocumento) {
        $this->numDocumento = (string) $numDocumento;
    }

    public function setUsuarioIdUsuario($usuarioIdUsuario) {
        $this->usuarioIdUsuario = (string) $usuarioIdUsuario;
    }

    public function setPrimerNombre($primerNombre) {
        $this->primerNombre = (string) $primerNombre;
    }

    public function getSegundoNombre() {
        return $this->segundoNombre;
    }

    public function getPrimerApellido() {
        return $this->primerApellido;
    }

    public function getSegundoApellido() {
        return $this->segundoApellido;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setSegundoNombre($segundoNombre) {
        $this->segundoNombre = (string) $segundoNombre;
    }

    public function setPrimerApellido($primerApellido) {
        $this->primerApellido = (string) $primerApellido;
    }

    public function setSegundoApellido($segundoApellido) {
        $this->segundoApellido = (string) $segundoApellido;
    }

    public function setTelefono($telefono) {
        $this->telefono = (string) $telefono;
    }

    public function jsonSerialize() {
        $array = array(
            "TIPO_DOCUMENTO" => $this->tipoDocumento,
            "NUM_DOCUMENTO" => $this->numDocumento,
            "USUARIO_ID_USUARIO" => $this->usuarioIdUsuario,
            "PRIMER_NOMBRE" => $this->primerNombre,
            "SEGUNDO_NOMBRE" => $this->segundoNombre,
            "PRIMER_APELLIDO" => $this->primerApellido,
            "SEGUNDO_APELLIDO" => $this->segundoApellido,
            "TELEFONO" => $this->telefono
        );
        return $array;
    }

    public static function stdClassToDTO(stdClass $obj) {
        try {
            $cuenta = new CuentaDTO();
            $cuenta->setTipoDocumento($obj->TIPO_DOCUMENTO);
            $cuenta->setNumDocumento($obj->NUM_DOCUMENTO);
            $cuenta->setUsuarioIdUsuario($obj->USUARIO_ID_USUARIO);
            $cuenta->setPrimerNombre($obj->PRIMER_NOMBRE);
            $cuenta->setSegundoNombre($obj->SEGUNDO_NOMBRE);
            $cuenta->setPrimerApellido($obj->PRIMER_APELLIDO);
            $cuenta->setSegundoApellido($obj->SEGUNDO_APELLIDO);
            $cuenta->setTelefono($obj->TELEFONO);
            return $cuenta;
        } catch (ErrorException $exc) {
            echo $exc->getTraceAsString();
        }
        return null;
    }

}
