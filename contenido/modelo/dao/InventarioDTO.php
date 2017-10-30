<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InventarioDTO
 *
 * @author Josué Francisco
 */
//include_once 'EntityDTO.php';

final class InventarioDTO implements EntityDTO {

    private $idInventario;
    private $productoIdProducto;
    private $fecha;
    private $cantidad;
    private $precioMayor;
    private $observaciones;

    public function __construct() {
        
    }

    public function getIdInventario() {
        return $this->idInventario;
    }

    public function getProductoIdProducto() {
        return $this->productoIdProducto;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getPrecioMayor() {
        return $this->precioMayor;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

    public function setIdInventario($idInventario) {
        $this->idInventario = (string) $idInventario;
    }

    public function setProductoIdProducto($productoIdProducto) {
        $this->productoIdProducto = (string) $productoIdProducto;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = (int) $cantidad;
    }

    public function setPrecioMayor($precioMayor) {
        $this->precioMayor = (double) $precioMayor;
    }

    public function setObservaciones($observaciones) {
        $this->observaciones = (string) $observaciones;
    }

    public function jsonSerialize() {
        $array = array(
            "ID_INVENTARIO" => $this->idInventario,
            "PRODUCTO_ID_PRODUCTO" => $this->productoIdProducto,
            "CANTIDAD" => $this->cantidad,
            "FECHA" => $this->fecha,
            "PRECIO_MAYOR" => $this->precioMayor,
            "OBSERVACIONES" => $this->observaciones
        );
        return $array;
    }

    public static function stdClassToDTO(stdClass $obj) {
        try {
            $invent = new InventarioDTO();
            $invent->setIdInventario($obj->ID_INVENTARIO);
            $invent->setProductoIdProducto($obj->PRODUCTO_ID_PRODUCTO);
            $invent->setCantidad($obj->CANTIDAD);
            $invent->setFecha($obj->FECHA);
            $invent->setPrecioMayor($obj->PRECIO_MAYOR);
            $invent->setObservaciones($obj->OBSERVACIONES);
            return $invent;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return null;
    }

}
