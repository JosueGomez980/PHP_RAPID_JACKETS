<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemCarrito;
 *
 * @author Josué Francisco
 */
//include_once 'EntityDTO.php';

final class ItemCarritoDTO implements EntityDTO {

    private $producto = NULL;
    private $productoIdProducto;
    private $carritoIdCarrito;
    private $cantidad;
    private $costoUnitario;
    private $costoTotal;
    private $impuestos;

    public function __construct(ProductoDTO $producto) {
        $this->producto = $producto;
        $this->productoIdProducto = $producto->getIdProducto();
        $this->costoUnitario = $producto->getPrecio();
    }

    public function getProductoIdProducto() {
        return $this->productoIdProducto;
    }

    public function getCarritoIdCarrito() {
        return $this->carritoIdCarrito;
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

    public function getImpuestos() {
        return $this->impuestos;
    }

    public function setProductoIdProducto($productoIdProducto) {
        $this->productoIdProducto = (string) $productoIdProducto;
    }

    public function setCarritoIdCarrito($carritoIdCarrito) {
        $this->carritoIdCarrito = (string) $carritoIdCarrito;
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

    public function setImpuestos($impuestos) {
        $this->impuestos = (double) $impuestos;
    }

    public function getProducto() {
        return $this->producto;
    }

    public function setProducto(ProductoDTO $producto) {
        $this->producto = $producto;
    }

    public function jsonSerialize() {
        $array = array(
            "pro_id_producto" => $this->productoIdProducto,
            "cart_id_carrito" => $this->carritoIdCarrito,
            "cantidad" => $this->cantidad,
            "costo_unitario" => $this->costoUnitario,
            "costo_total" => $this->costoTotal,
            "impuesto" => $this->impuestos
        );
        return $array;
    }

    public static function stdClassToDTO(stdClass $obj) {
        try {
            //$itemCarrito = new ItemCarritoDTO();
        } catch (ErrorException $exc) {
            echo $exc->getMessage();
        }
        return null;
    }

}
