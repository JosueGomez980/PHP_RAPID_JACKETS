<?php

//Autocarga3
class AutoCarga3 {

    public static $loader;

    public static function init() {
        self::$loader = new AutoCarga3();
        return self::$loader;
    }

    public function __construct() {
        $this->cargarResto();
        $this->modelo();
        $this->controlador();
        $this->maquetacion();
        $this->sesiones();
        $this->cookies();
    }

    public function cargarResto() {
        if (file_exists('Request.php')) {
            include_once 'Request.php';
        }
        if (file_exists('Validable.php')) {
            include_once 'Validable.php';
        }
        if (file_exists('ContentManager.php')) {
            include_once 'ContentManager.php';
        }
        if (file_exists('sesiones/SessionManager.php')) {
            include_once 'sesiones/SessionManager.php';
        }
        if (file_exists('GenericController.php')) {
            include_once 'GenericController.php';
        }
        if (file_exists('DateManager.php')) {
            include_once 'DateManager.php';
        }
        if (file_exists('GenericMaquetador.php')) {
            include_once 'GenericMaquetador.php';
        }
        if (file_exists('../../modelo/dao/EntityDTO.php')) {
            include_once '../../modelo/dao/EntityDTO.php';
        }
    }

    public function modelo() {
        spl_autoload_register(array($this, 'cargarModelo'));
    }

    public function controlador() {
        spl_autoload_register(array($this, 'cargarControllers'));
    }

    public function maquetacion() {
        spl_autoload_register(array($this, 'cargarMaquetacion'));
    }

    public function sesiones() {
        spl_autoload_register(array($this, 'cargarSesiones'));
    }

    public function cookies() {
        spl_autoload_register(array($this, 'cargarCookies'));
    }

    public function cargarControllers($clase) {
        if (file_exists($clase . '.php')) {
            include_once $clase . '.php';
        }
    }

    public function cargarModelo($clase) {
        if (file_exists('../../modelo/dao/' . $clase . '.php')) {
            include_once '../../modelo/dao/' . $clase . '.php';
        }
    }

    public function cargarMaquetacion($clase) {
        if (file_exists('../maquetacion/' . $clase . '.php')) {
            include_once '../maquetacion/' . $clase . '.php';
        }
    }

    public function cargarSesiones($clase) {
        if (file_exists('sesiones/' . $clase . '.php')) {
            include_once 'sesiones/' . $clase . '.php';
        }
    }

    public function cargarCookies($clase) {
        if (file_exists('cookies/' . $clase . '.php')) {
            include_once 'cookies/' . $clase . '.php';
        }
    }

}
