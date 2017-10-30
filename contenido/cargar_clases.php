<?php

//Autocarga #1
class AutoCarga {

    public static $loader;

    public static function init() {
        if (is_null(self::$loader)) {
            self::$loader = new AutoCarga();
        }
        return self::$loader;
    }

    public function __construct() {
        $this->cargarResto();
        $this->modelo();
        $this->controlador();
        $this->maquetacion();
        $this->sesiones();
        $this->cookies();
        $this->carga();
    }

    public function cargarResto() {
        if (file_exists('controlador/controllers/Request.php')) {
            include_once 'controlador/controllers/Request.php';
        }
        if (file_exists('controlador/controllers/Validable.php')) {
            include_once 'controlador/controllers/Validable.php';
        }
        if (file_exists('controlador/controllers/ContentManager.php')) {
            include_once 'controlador/controllers/ContentManager.php';
        }
        if (file_exists('controlador/controllers/sesiones/SessionManager.php')) {
            include_once 'controlador/controllers/sesiones/SessionManager.php';
        }
        if (file_exists('controlador/controllers/GenericController.php')) {
            include_once 'controlador/controllers/GenericController.php';
        }
        if (file_exists('controlador/controllers/DateManager.php')) {
            include_once 'controlador/controllers/DateManager.php';
        }
        if (file_exists('controlador/maquetacion/GenericMaquetador.php')) {
            include_once 'controlador/maquetacion/GenericMaquetador.php';
        }
        if (file_exists('modelo/dao/EntityDTO.php')) {
            include_once 'modelo/dao/EntityDTO.php';
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

    public function carga() {
        spl_autoload_register(array($this, 'cargar'));
    }

    public function cargarControllers($clase) {
        if (file_exists('controlador/controllers/' . $clase . '.php')) {
            include_once 'controlador/controllers/' . $clase . '.php';
        }
    }

    public function cargarModelo($clase) {
        if (file_exists('modelo/dao/' . $clase . '.php')) {
            include_once 'modelo/dao/' . $clase . '.php';
        }
    }

    public function cargarMaquetacion($clase) {
        if (file_exists('controlador/maquetacion/' . $clase . '.php')) {
            include_once 'controlador/maquetacion/' . $clase . '.php';
        }
    }

    public function cargarSesiones($clase) {
        if (file_exists('controlador/controllers/sesiones/' . $clase . '.php')) {
            include_once 'controlador/controllers/sesiones/' . $clase . '.php';
        }
    }

    public function cargarCookies($clase) {
        if (file_exists('controlador/controllers/cookies/' . $clase . '.php')) {
            include_once 'controlador/controllers/cookies/' . $clase . '.php';
        }
    }

    public function cargar($clase) {
        if (file_exists($clase . ".php")) {
            include_once $clase . ".php";
        }
    }

}
