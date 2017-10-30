<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InventarioDAO
 *
 * @author Josué Francisco
 */

final class InventarioDAO implements DAOPaginable {

    private $db;

    public function __construct() {
        $this->db = Conexion::getInstance();
    }

    private function resultToArray(mysqli_result $resultado) {
        $tablaInventario = [];
        while ($fila = $resultado->fetch_array()) {
            $inv = new InventarioDTO();
            $inv->setIdInventario($fila["ID_INVENTARIO"]);
            $inv->setProductoIdProducto("PRODUCTO_ID_PRODUCTO");
            $inv->setFecha($fila["FECHA"]);
            $inv->setCantidad($fila["CANTIDAD"]);
            $inv->setPrecioMayor($fila["PRECIO_MAYOR"]);
            $inv->setObservaciones($fila["OBSERVACIONES"]);
            $tablaInventario[] = $inv;
        }
        return $tablaInventario;
    }

    private function resultToObject(mysqli_result $resultado) {
        $fila = $resultado->fetch_array();
        $inv = new InventarioDTO();
        $inv->setIdInventario($fila["ID_INVENTARIO"]);
        $inv->setProductoIdProducto("PRODUCTO_ID_PRODUCTO");
        $inv->setFecha($fila["FECHA"]);
        $inv->setCantidad($fila["CANTIDAD"]);
        $inv->setPrecioMayor($fila["PRECIO_MAYOR"]);
        $inv->setObservaciones($fila["OBSERVACIONES"]);

        return $inv;
    }

    public function insert(InventarioDTO $inventario) {
        $idInv = $inventario->getIdInventario();
        $producto = $inventario->getProductoIdProducto();
        $fecha = $inventario->getFecha();
        $cantidad = $inventario->getCantidad();
        $precioMayor = $inventario->getPrecioMayor();
        $observaciones = $inventario->getObservaciones();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::inventario_insert);
            $stmt->bind_param("sssids", $idInv, $producto, $fecha, $cantidad, $precioMayor, $observaciones);
            $stmt->execute();
            $res = $stmt->affected_rows;

            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $res;
    }

    public function update(InventarioDTO $inveUpdate) {
        $idInv = $inveUpdate->getIdInventario();
        $producto = $inveUpdate->getProductoIdProducto();
        $fecha = $inveUpdate->getFecha();
        $cantidad = $inveUpdate->getCantidad();
        $precioMayor = $inveUpdate->getPrecioMayor();
        $observaciones = $inveUpdate->getObservaciones();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::inventario_update);
            $stmt->bind_param("sidsss", $fecha, $cantidad, $precioMayor, $observaciones, $idInv, $producto);
            $stmt->execute();
            $res = $stmt->affected_rows;

            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $res;
    }

    public function delete(InventarioDTO $invDelete) {
        $idInv = $invDelete->getIdInventario();
        $producto = $invDelete->getProductoIdProducto();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::inventario_delete);
            $stmt->bind_param("ss", $idInv, $producto);
            $stmt->execute();
            $res = $stmt->affected_rows;

            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $res;
    }

    public function findAll() {
        $tablaInventario = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $resultado = $conexion->query(PreparedSQL::inventario_find_all);
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $tablaInventario = $this->resultToArray($resultado);
            }
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $tablaInventario;
    }

    public function find(InventarioDTO $invFind) {
        $idInventario = $invFind->getIdInventario();
        $idProducto = $invFind->getProductoIdProducto();
        $inv = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::inventario_find);
            $stmt->bind_param("ss", $idInventario, $idProducto);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows != 0) {
                $inv = $this->resultToObject($resultado);
            }
            $stmt->close();
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $inv;
    }

    public function findByProducto(InventarioDTO $invFind) {
        $producto = $invFind->getProductoIdProducto();
        $tablaInventario = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::inventario_find_by_producto);
            $stmt->bind_param("s", $producto);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $tablaInventario = $this->resultToArray($resultado);
            }
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $tablaInventario;
    }

    public function findByPaginationLimit($inicio, $cantidad) {
        
    }

    public function generateIdInCore() {
        $getNPro = "SELECT COUNT(i.ID_INVENTARIO) AS 'NINV' FROM INVENTARIO i;";
        $newId = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $resultado = $conexion->query($getNPro);
            $nInventarios = (int) $resultado->fetch_array()["NINV"];
            $zeros = 17 - (strlen($nInventarios + 1));
            $newId = "inv";
            $newId .= str_repeat("0", $zeros);
            $newId .= ($nInventarios + 1);
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $newId;
    }

    public function generateIdInDB() {
        $newId = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $resultado = $conexion->query(PreparedSQL::get_new_inventario_id);
            $newId = $resultado->fetch_array()["NEW_ID"];
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $newId;
    }

}
