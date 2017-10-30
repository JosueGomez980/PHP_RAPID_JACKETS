<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemDAO
 *
 * @author Josué Francisco
 */
//include_once 'Conexion.php';
//include_once 'PreparedSQL.php';
//include_once 'ItemDTO.php';

final class ItemDAO implements DAOPaginable {

    private $db;
    private static $idProducto = "PRODUCTO_ID_PRODUCTO";
    private static $idFactura = "FACTURA_ID_FACTURA";
    private static $cantidad = "CANTIDAD";
    private static $costo_unit = "COSTO_UNITARIO";
    private static $costo_total = "COSTO_TOTAL";

    public function __construct() {
        $this->db = Conexion::getInstance();
    }

    private function resultToObject(mysqli_result $resultado) {
        $fila = $resultado->fetch_array();
        $item = new ItemDTO();
        $item->setFacturaIdFactura($fila[self::$idFactura]);
        $item->setProductoIdProducto($fila[self::$idProducto]);
        $item->setCantidad($fila[self::$cantidad]);
        $item->setCostoUnitario($fila[self::$costo_unit]);
        $item->setCostoTotal($fila[self::$costo_total]);
        return $item;
    }

    private function resultToArray(mysqli_result $resultado) {
        $items = [];
        while ($fila = $resultado->fetch_array()) {
            $item = new ItemDTO();
            $item->setFacturaIdFactura($fila[self::$idFactura]);
            $item->setProductoIdProducto($fila[self::$idProducto]);
            $item->setCantidad($fila[self::$cantidad]);
            $item->setCostoUnitario($fila[self::$costo_unit]);
            $item->setCostoTotal($fila[self::$costo_total]);
            $items[] = $item;
        }
        return $items;
    }

    public function insert(ItemDTO $item) {
        $idFactura = $item->getFacturaIdFactura();
        $idProducto = $item->getProductoIdProducto();
        $cantidad = $item->getCantidad();
        $costoUnit = $item->getCostoUnitario();
        $total = $item->getCostoTotal();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::item_insert);
            $stmt->bind_param("ssidd", $idProducto, $idFactura, $cantidad, $costoUnit, $total);
            $stmt->execute();
            $res = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $res;
    }

    public function inserts(array $items) {
        $affR = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::item_insert);
            foreach ($items as $item) {
                $idFactura = $item->getFacturaIdFactura();
                $idProducto = $item->getProductoIdProducto();
                $cantidad = $item->getCantidad();
                $costoUnit = $item->getCostoUnitario();
                $total = $item->getCostoTotal();
                $res = 0;
                $stmt->bind_param("ssidd", $idProducto, $idFactura, $cantidad, $costoUnit, $total);
                $stmt->execute();
                $res = $stmt->affected_rows;
                $stmt->reset();
                $affR += $res;
            }
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
            return $affR;
        }
        return $affR;
    }

    public function update(ItemDTO $item) {
        $idFactura = $item->getFacturaIdFactura();
        $idProducto = $item->getProductoIdProducto();
        $cantidad = $item->getCantidad();
        $costoUnit = $item->getCostoUnitario();
        $total = $item->getCostoTotal();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::item_update);
            $stmt->bind_param("iddss", $cantidad, $costoUnit, $total, $idFactura, $idProducto);
            $stmt->execute();
            $res = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $res;
    }

    public function delete(ItemDTO $item) {
        $idFactura = $item->getFacturaIdFactura();
        $idProducto = $item->getProductoIdProducto();
        $res = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::item_delete);
            $stmt->bind_param("ss", $idFactura, $idProducto);
            $stmt->execute();
            $res = $stmt->affected_rows;
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $res;
    }

    public function find(ItemDTO $item) {
        $idFactura = $item->getFacturaIdFactura();
        $idProducto = $item->getProductoIdProducto();
        $itemFd = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::item_find);
            $stmt->bind_param("ss", $idFactura, $idProducto);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows != 0) {
                $itemFd = $this->resultToObject($result);
            }
            $stmt->close();
            $result->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $itemFd;
    }

    public function findByFactura(ItemDTO $item) {
        $idFactura = $item->getFacturaIdFactura();
        $itemsFd = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::item_find_by_factura);
            $stmt->bind_param("s", $idFactura);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows != 0) {
                $itemsFd = $this->resultToArray($result);
            }
            $stmt->close();
            $result->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $itemsFd;
    }

    public function findAll() {
        $itemsFd = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $result = $conexion->query(PreparedSQL::item_find_all);
            if ($result->num_rows != 0) {
                $itemsFd = $this->resultToArray($result);
            }
            $result->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $itemsFd;
    }

    public static function itemCarritoToItemDTO(ItemCarritoDTO $it, $idFactura) {
        try {
            $itemDTO = new ItemDTO();
            $itemDTO->setProductoIdProducto($it->getProductoIdProducto());
            $itemDTO->setFacturaIdFactura($idFactura);
            $itemDTO->setCantidad($it->getCantidad());
            $itemDTO->setCostoUnitario($it->getCostoUnitario());
            $itemDTO->setCostoTotal($it->getCostoTotal());
            return $itemDTO;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
        return null;
    }

    public function findByPaginationLimit($inicio, $cantidad) {
        
    }

}
