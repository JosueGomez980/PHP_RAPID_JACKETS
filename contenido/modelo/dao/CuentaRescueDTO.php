<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CuentaRescueDTO
 *
 * @author JosueFrancisco
 */
class CuentaRescueDTO implements EntityDTO {

    private $usuarioIdUsuario;
    private $estado;
    private $codigo;
    private $token;
    private $lastRecover;

    public function __construct() {
        
    }

    public function getUsuarioIdUsuario() {
        return $this->usuarioIdUsuario;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getToken() {
        return $this->token;
    }

    public function getLastRecover() {
        return $this->lastRecover;
    }

    public function setUsuarioIdUsuario($usuarioIdUsuario) {
        $this->usuarioIdUsuario = $usuarioIdUsuario;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setToken($token) {
        $this->token = $token;
    }

    public function setLastRecover($lastRecover) {
        $this->lastRecover = $lastRecover;
    }

    public function jsonSerialize() {
        $array = array(
            "user_id" => $this->usuarioIdUsuario,
            "estado" => $this->estado,
            "codigo" => $this->codigo,
            "token" => $this->token,
            "last_recover" => $this->lastRecover
        );
        return $array;
    }

    public static function stdClassToDTO(stdClass $obj) {
        try {
            $cuentaRescue = new CuentaRescueDTO();
            $cuentaRescue->setUsuarioIdUsuario($obj->user_id);
            $cuentaRescue->setEstado($obj->estado);
            $cuentaRescue->setCodigo($obj->codigo);
            $cuentaRescue->setToken($obj->token);
            $cuentaRescue->setLastRecover($obj->last_recover);
            return $cuentaRescue;
        } catch (Exception $exc) {
            return null;
        }
    }

}
