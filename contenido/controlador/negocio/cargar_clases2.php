<?php

//Autocarga2
class AutoCarga2 {

    public static $loader;

    public static function init() {
        if (is_null(self::$loader)) {
            self::$loader = new AutoCarga2();
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
    }

    public function cargarResto() {
        if (file_exists('../controllers/Request.php')) {
            include_once '../controllers/Request.php';
        }
        if (file_exists('../controllers/Validable.php')) {
            include_once '../controllers/Validable.php';
        }
        if (file_exists('../controllers/ContentManager.php')) {
            include_once '../controllers/ContentManager.php';
        }
        if (file_exists('../controllers/sesiones/SessionManager.php')) {
            include_once '../controllers/sesiones/SessionManager.php';
        }
        if (file_exists('../controllers/GenericController.php')) {
            include_once '../controllers/GenericController.php';
        }
        if (file_exists('../controllers/DateManager.php')) {
            include_once '../controllers/DateManager.php';
        }
        if (file_exists('../maquetacion/GenericMaquetador.php')) {
            include_once '../maquetacion/GenericMaquetador.php';
        }
        if (file_exists('../../modelo/dao/EntityDTO.php')) {
            include_once '../../modelo/dao/EntityDTO.php';
        }
    }

    public function carga() {
        spl_autoload_register(array($this, 'cargar'));
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
        if (file_exists('../controllers/' . $clase . '.php')) {
            include_once '../controllers/' . $clase . '.php';
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
        if (file_exists('../controllers/sesiones/' . $clase . '.php')) {
            include_once '../controllers/sesiones/' . $clase . '.php';
        }
    }

    public function cargarCookies($clase) {
        if (file_exists('../controllers/cookies/' . $clase . '.php')) {
            include_once '../controllers/cookies/' . $clase . '.php';
        }
    }

    public function cargar($clase) {
        if (file_exists($clase . ".php")) {
            include_once $clase . '.php';
        }
    }

}
