<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CatalogoDAO
 *
 * @author Josué Francisco
 */
//include_once("Conexion.php");
//include_once("CatalogoDTO.php");
//include_once("PreparedSQL.php");

final class CatalogoDAO implements DAOPaginable{

    private $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    public function insert(CatalogoDTO $catalogo) {
        $nombre = $catalogo->getNombre();
        $descripcion = $catalogo->getDescripcion();
        $foto = $catalogo->getFoto();
        if (is_null($foto)) {
            $foto = "SIN_ASIGNAR";
        }
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof Mysqli;
            $stmt = $conexion->prepare(PreparedSQL::catalogo_insert);
            $stmt->bind_param("sss", $nombre, $descripcion, $foto);
            if ($stmt->execute()) {
                $res = $stmt->affected_rows;
            }
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $ex) {
            echo ($ex->getMessage());
        }
        return $res;
    }

    public function update(CatalogoDTO $catUpdate) {
        $idCat = $catUpdate->getIdCatalogo();
        $nombre = $catUpdate->getNombre();
        $descripcion = $catUpdate->getDescripcion();
        $foto = $catUpdate->getFoto();
        $res = 0;
        if (is_null($foto)) {
            $foto = "SIN_ASIGNAR";
        }
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::catalogo_update);
            $stmt->bind_param("sssi", $nombre, $descripcion, $foto, $idCat);
            $stmt->execute();
            $res = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $ex) {
            echo($ex->getMessage());
        }
        return $res;
    }

    public function find(CatalogoDTO $catFind) {
        $idCat = $catFind->getIdCatalogo();
        $catalogo = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::catalogo_find_pk);
            $stmt->bind_param("i", $idCat);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $fila = $resultado->fetch_array();
                $catalogo = new CatalogoDTO();
                $catalogo->setIdCatalogo($fila["ID_CATALOGO"]);
                $catalogo->setNombre($fila["NOMBRE"]);
                $catalogo->setDescripcion($fila["DESCRIPCION"]);
                $catalogo->setActivo($fila["ACTIVO"]);
                $catalogo->setFoto($fila["FOTO"]);
            }
            $stmt->close();
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $ex) {
            echo($ex->getMessage());
        }
        return $catalogo;
    }

    public function findAll() {
        $tablaCatalogo = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $resultado = $conexion->query(PreparedSQL::catalogo_find_all);
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $tablaCatalogo = [];
                while ($fila = $resultado->fetch_array()) {
                    $catalogo = new CatalogoDTO();
                    $catalogo->setIdCatalogo($fila["ID_CATALOGO"]);
                    $catalogo->setNombre($fila["NOMBRE"]);
                    $catalogo->setDescripcion($fila["DESCRIPCION"]);
                    $catalogo->setActivo($fila["ACTIVO"]);
                    $catalogo->setFoto($fila["FOTO"]);
                    $tablaCatalogo[] = $catalogo;
                }
            }
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $ex) {
            echo($ex->getMessage());
        }
        return $tablaCatalogo;
    }

    public function delete(CatalogoDTO $catDelete) {
        $idCat = $catDelete->getIdCatalogo();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::catalogo_delete);
            $stmt->bind_param("i", $idCat);
            $stmt->execute();
            $res = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $ex) {
            echo($ex->getMessage());
        }
        return $res;
    }

    public function disable_enable(CatalogoDTO $catEnaDis){
        $idCat = $catEnaDis->getIdCatalogo();
        $yn = $catEnaDis->getActivo();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::catalogo_enable_disable);
            $stmt->bind_param("ii", $yn, $idCat);
            $stmt->execute();
            $res = $stmt->affected_rows;
        } catch (mysqli_sql_exception $ex) {
            echo($ex->getMessage());
        }
        return $res;
    }
    
    public function findByPaginationLimit($inicio, $cantidad){
        
    }

}
