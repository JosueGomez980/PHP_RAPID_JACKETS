<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductoDTO
 *
 * @author Josué Francisco
 */
//include_once 'EntityDTO.php';

final class ProductoDTO implements EntityDTO {

    private $idProducto;
    private $categoriaIdCategoria;
    private $catalogoIdCatalogo;
    private $nombre;
    private $precio;
    private $activo;
    private $cantidad;
    private $descripcion;
    private $foto;

    function __construct() {
        
    }

    function getIdProducto() {
        return $this->idProducto;
    }

    function getCategoriaIdCategoria() {
        return $this->categoriaIdCategoria;
    }

    function getCatalogoIdCatalogo() {
        return $this->catalogoIdCatalogo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getActivo() {
        return $this->activo;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getFoto() {
        return $this->foto;
    }

    function setIdProducto($idProducto) {
        $this->idProducto = (string) $idProducto;
    }

    function setCategoriaIdCategoria($categoriaIdCategoria) {
        $this->categoriaIdCategoria = (int) $categoriaIdCategoria;
    }

    function setCatalogoIdCatalogo($catalogoIdCatalogo) {
        $this->catalogoIdCatalogo = (int) $catalogoIdCatalogo;
    }

    function setNombre($nombre) {
        $this->nombre = (string) $nombre;
    }

    function setPrecio($precio) {
        $this->precio = (double) $precio;
    }

    function setActivo($activo) {
        $this->activo = (boolean) $activo;
    }

    function setCantidad($cantidad) {
        $this->cantidad = (int) $cantidad;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = (string) $descripcion;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    public function jsonSerialize() {
        $array = array(
            "ID_PRODUCTO" => $this->idProducto,
            "CATEGORIA_ID_CATEGORIA" => $this->categoriaIdCategoria,
            "CATALOGO_ID_CATALOGO" => $this->catalogoIdCatalogo,
            "NOMBRE" => $this->nombre,
            "PRECIO" => $this->precio,
            "ACTIVO" => $this->activo,
            "CANTIDAD" => $this->cantidad,
            "DESCRIPCION" => $this->descripcion,
            "FOTO" => $this->foto
        );
        return $array;
    }

    public static function stdClassToDTO(stdClass $obj) {
        try {
            $productoDTO = new ProductoDTO();
            $productoDTO->setIdProducto($obj->ID_PRODUCTO);
            $productoDTO->setCategoriaIdCategoria($obj->CATEGORIA_ID_CATEGORIA);
            $productoDTO->setCatalogoIdCatalogo($obj->CATALOGO_ID_CATALOGO);
            $productoDTO->setNombre($obj->NOMBRE);
            $productoDTO->setPrecio($obj->PRECIO);
            $productoDTO->setActivo($obj->ACTIVO);
            $productoDTO->setCantidad($obj->CANTIDAD);
            $productoDTO->setDescripcion($obj->DESCRIPCION);
            $productoDTO->setFoto($obj->FOTO);
            return $productoDTO;
        } catch (ErrorException $ex) {
            printf($ex->getMessage());
        }
        return null;
    }

}
