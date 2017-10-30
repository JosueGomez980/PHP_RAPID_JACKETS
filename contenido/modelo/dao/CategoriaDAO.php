<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoriaDAO
 *
 * @author Josué Francisco
 */
//include_once("CategoriaDTO.php");
//include_once("Conexion.php");
//include_once("PreparedSQL.php");

final class CategoriaDAO implements DAOPaginable{

    private $db;
    public static $instancia = NULL;
    private static $id_cat = "ID_CATEGORIA";
    private static $name = "NOMBRE";
    private static $activa = "ACTIVA";
    private static $desc = "DESCRIPCION";
    private static $cat_id_cat = "CATEGORIA_ID_CATEGORIA";

    public function __construct() {
        $this->db = Conexion::getInstance();
    }

    public static function getInstancia() {
        if (is_null(self::$instancia)) {
            self::$instancia = new CategoriaDAO();
        }
        return self::$instancia;
    }

    private function resultToArray(mysqli_result $resultado) {
        $tablaCategoria = array();
        while ($fila = $resultado->fetch_array()) {
            $categoria = new CategoriaDTO();
            $categoria->setIdCategoria($fila[self::$id_cat]);
            $categoria->setActiva($fila[self::$activa]);
            $categoria->setCategoriaIdCategoria($fila[self::$cat_id_cat]);
            $categoria->setNombre($fila[self::$name]);
            $categoria->setDescripcion($fila[self::$desc]);
            $tablaCategoria[] = $categoria;
        }
        return $tablaCategoria;
    }

    private function resultToObject(mysqli_result $resultado) {
        $categoria = new CategoriaDTO();
        $resultado->data_seek(0);
        $fila = $resultado->fetch_array();
        $categoria->setIdCategoria($fila[self::$id_cat]);
        $categoria->setActiva($fila[self::$activa]);
        $categoria->setCategoriaIdCategoria($fila[self::$cat_id_cat]);
        $categoria->setNombre($fila[self::$name]);
        $categoria->setDescripcion($fila[self::$desc]);
        return $categoria;
    }

    function insert(CategoriaDTO $categoria) {
        $nombre = $categoria->getNombre();
        $descripcion = $categoria->getDescripcion();
        $cate_id_cate = $categoria->getCategoriaIdCategoria();
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::categoria_insert);
            $stmt->bind_param("ssi", $nombre, $descripcion, $cate_id_cate);
            $stmt->execute();
            $resultado = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return($resultado);
    }

    public function delete(CategoriaDTO $categoria) {
        $idCat = $categoria->getIdCategoria();
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::categoria_delete);
            $stmt->bind_param("i", $idCat);
            $res = $stmt->execute();
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $ex) {
            echo($ex->getMessage());
        }
        return($res);
    }

    public function findAll() {
        $tablaCategoria = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $resultado = $conexion->query(PreparedSQL::categoria_find_all);
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $tablaCategoria = $this->resultToArray($resultado);
            }
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $ex) {
            echo($ex->getMessage());
        }
        return ($tablaCategoria);
    }

    public function find(CategoriaDTO $categoriaT) {
        $categoria = NULL;
        $idCat = $categoriaT->getIdCategoria();
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::categoria_find_pk);
            $stmt->bind_param("i", $idCat);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $categoria = $this->resultToObject($resultado);
            }
            $stmt->close();
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $ex) {
            echo($ex->getMessage());
        }
        return $categoria;
    }

    public function findByFK(CategoriaDTO $categoria) {
        $cat_id_cat = $categoria->getCategoriaIdCategoria();
        $tablaCategoria = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::categoria_find_by_fk);
            $stmt->bind_param("ii", $cat_id_cat, $cat_id_cat);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $tablaCategoria = $this->resultToArray($resultado);
            }
            $stmt->close();
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $ex) {
            echo($ex->getMessage());
        }
        return $tablaCategoria;
    }

    public function update(CategoriaDTO $catUpdate) {
        $idCat = $catUpdate->getIdCategoria();
        $nombre = $catUpdate->getNombre();
        $descripcion = $catUpdate->getDescripcion();
        $catIdCat = $catUpdate->getCategoriaIdCategoria();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::categoria_update);
            $stmt->bind_param("ssii", $nombre, $descripcion, $catIdCat, $idCat);
            $stmt->execute();
            $res = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $ex) {
            echo($ex->getMessage());
        }
        return $res;
    }

    public function disable_enable(CategoriaDTO $catDisable) {
        $idCat = $catDisable->getIdCategoria();
        $yn = $catDisable->getActiva();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::categoria_disable);
            $stmt->bind_param("ii", $yn, $idCat);
            $stmt->execute();
            $res = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $ex) {
            echo($ex->getMessage());
        }
        return($res);
    }
    public function findByPaginationLimit($inicio, $cantidad){
        
    }
}

?>
