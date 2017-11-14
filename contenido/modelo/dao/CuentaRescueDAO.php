<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CuentaRescueDAO
 *
 * @author JosueFrancisco
 */
class CuentaRescueDAO implements GenericDAO {

    private $db;
    private static $instancia = null;

    public function __construct() {
        $this->db = new Conexion();
    }

    public function delete(EntityDTO $entidad) {
        
    }

    public function find(EntityDTO $entidad) {
        
    }

    public function findAll() {
        
    }

    public function insert(EntityDTO $entidad) {
        
    }

    public function resultToArray(mysqli_result $resultado) {
        
    }

    public function resultToObject(mysqli_result $resultado) {
        
    }

    public function update(EntityDTO $entidad) {
        
    }

    public static function getInstancia() {
        if(is_null(self::$instancia)){
            self::$instancia = new CuentaRescueDAO();
        }
        return self::$instancia;
    }

}
