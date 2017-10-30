<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




interface Session {

    const US_LOGED = "USUARIO_EN_SESION";
    const US_ADMIN_LOGED = "USUARIO_ADMINISTRADOR_EN_SESION";
    const US_SUB_ADMIN_LOGED = "USUARIO_SUB_ADMINISTRADOR_EN_SESION";
    const CU_ADMIN_LOGED = "CUENTA_ADMINISTRADOR_EN_SESION";
    const CU_SUB_ADMIN_LOGED = "CUENTA_SUB_ADMINISTRADOR_EN_SESION";
    const CU_LOGED = "CUENTA_DE_USUARIO_EN_SESION";
    const AD_US_LOGED = "ADMINISTRADOR_EN_SESION";
    const AD_CU_LOGED = "CUENTA_DE_ADMINISTRADOR_EN_SESION";
    const CART_NO_USER = "CARRITO_DE_COMPRAS_SIN_USUARIO";
    const CART_USER = "CARRITO_DE_COMPRAS_CON_USUARIO";
    const NEGOCIO_RTA = "RESPUESTA_DE_CAPA_NEGOCIO";
    const PAGINADOR = "PAGINADOR_EN_MEMORIA";
    const PRO_DTO = "PRODUCTO_DTO_NEGOCIO";

    public static function open();

    public static function getInstancia();

    public function reset();

    public function close();

    public function destroy();

    public function existe($name);

    public function add($name, $value);

    public function remove($name);

    public function get($name);

    public function getEntidad($name);

    public function addEntidad(EntityDTO $entidad, $name);

    public function removeEntidad($name);

    public function getAll();
}

class SimpleSession implements Session {

    protected $idSesion;
    protected static $sesion = NULL;
    protected $nameSesion;
    protected $estado;

    public function __construct() {
        self::open();
    }

    public function getIdSesion() {
        return $this->idSesion;
    }

    public function getNameSesion() {
        return $this->nameSesion;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setIdSesion($idSesion) {
        $this->idSesion = $idSesion;
    }

    public function setNameSesion($nameSesion) {
        $this->nameSesion = $nameSesion;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    //Para serializar una entidad DTO a formato JSON y guardarla en sesion. Solo usar con entidades DTO
    public function addEntidad(EntityDTO $entidad, $name) {
        $serilzed_entidad = serialize($entidad);
        $_SESSION[$name] = $serilzed_entidad;
    }

    public function close() {
        session_unset();
    }

    public function destroy() {
        if (session_status() != PHP_SESSION_NONE) {
            session_destroy();
        }
    }

    public function existe($name) {
        if (isset($_SESSION[$name])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function open() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function removeEntidad($name) {
        if ($this->existe($name)) {
            unset($_SESSION[$name]);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function reset() {
        session_reset();
    }

    public function add($name, $value) {
        if (is_object($value)) {
            $object = serialize($value);
            $_SESSION[$name] = $object;
        } else {
            $_SESSION[$name] = $value;
        }
    }

    public function get($name) {
        if ($this->existe($name)) {
            if (is_object(unserialize($_SESSION[$name]))) {
                return unserialize($_SESSION[$name]);
            } else {
                return $_SESSION[$name];
            }
        } else {
            return NULL;
        }
    }

    public function getEntidad($name) {
        if ($this->existe($name)) {
            $object = unserialize($_SESSION[$name]);
            return $object;
        } else {
            return NULL;
        }
    }

    public function remove($name) {
        if ($this->existe($name)) {
            unset($_SESSION[$name]);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAll() {
        $todo = array();
        foreach ($_SESSION as $value) {
            if (is_object(unserialize($value))) {
                $todo[] = unserialize($value);
            } else {
                $todo[] = $value;
            }
        }
        return $todo;
    }

    public static function getInstancia() {
        if (is_null(self::$sesion)) {
            self::$sesion = new SimpleSession();
        }
        self::open();
        return self::$sesion;
    }

}
