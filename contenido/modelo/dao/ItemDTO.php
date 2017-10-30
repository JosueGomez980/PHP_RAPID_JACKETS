<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemFactura
 *
 * @author Josué Francisco
 */
//include_once 'EntityDTO.php';

final class ItemDTO implements EntityDTO {

    private $productoIdProducto;
    private $facturaIdFactura;
    private $cantidad;
    private $costoUnitario;
    private $costoTotal;

    public function __construct() {
        
    }

    public function getProductoIdProducto() {
        return $this->productoIdProducto;
    }

    public function getFacturaIdFactura() {
        return $this->facturaIdFactura;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getCostoUnitario() {
        return $this->costoUnitario;
    }

    public function getCostoTotal() {
        return $this->costoTotal;
    }

    public function setProductoIdProducto($productoIdProducto) {
        $this->productoIdProducto = (string) $productoIdProducto;
    }

    public function setFacturaIdFactura($facturaIdFactura) {
        $this->facturaIdFactura = (string) $facturaIdFactura;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = (int) $cantidad;
    }

    public function setCostoUnitario($costoUnitario) {
        $this->costoUnitario = (double) $costoUnitario;
    }

    public function setCostoTotal($costoTotal) {
        $this->costoTotal = (double) $costoTotal;
    }

    public function jsonSerialize() {
        $array = array(
            "PRODUCTO_ID_PRODUCTO" => $this->productoIdProducto,
            "FACTURA_ID_FACTURA" => $this->facturaIdFactura,
            "CANTIDAD" => $this->cantidad,
            "COSTO_UNITARIO" => $this->costoUnitario,
            "COSTO_TOTAL" => $this->costoTotal
        );
        return $array;
    }

    public static function stdClassToDTO(stdClass $obj) {
        try {
            $item = new ItemDTO();
            $item->setProductoIdProducto($obj->PRODUCTO_ID_PRODUCTO);
            $item->setFacturaIdFactura($obj->FACTURA_ID_FACTURA);
            $item->setCantidad($obj->CANTIDAD);
            $item->setCostoUnitario($obj->COSTO_UNITARIO);
            $item->setCostoTotal($obj->COSTO_TOTAL);
            return $item;
        } catch (ErrorException $exc) {
            echo $exc->getTraceAsString();
        }
        return null;
    }

}
