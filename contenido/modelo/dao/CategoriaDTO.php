<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoriaDTO
 *
 * @author Josué Francisco
 */
//include_once 'EntityDTO.php';

final class CategoriaDTO implements EntityDTO {

    private $idCategoria;
    private $nombre;
    private $activa = true;
    private $descripcion;
    private $categoriaIdCategoria;

    public function __construct() {
        
    }

    function getIdCategoria() {
        return $this->idCategoria;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getActiva() {
        return $this->activa;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getCategoriaIdCategoria() {
        return $this->categoriaIdCategoria;
    }

    function setIdCategoria($idCategoria) {
        $this->idCategoria = (int) $idCategoria;
    }

    function setNombre($nombre) {
        $this->nombre = (string) $nombre;
    }

    function setActiva($activa) {
        $this->activa = (boolean) $activa;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = (string) $descripcion;
    }

    function setCategoriaIdCategoria($categoriaIdCategoria) {
        $this->categoriaIdCategoria = (int) $categoriaIdCategoria;
    }

    public function jsonSerialize() {
        $array = array(
            "ID_CATEGORIA" => $this->idCategoria,
            "NOMBRE" => $this->nombre,
            "ACTIVA" => $this->activa,
            "DESCRIPCION" => $this->descripcion,
            "CATEGORIA_ID_CATEGORIA" => $this->categoriaIdCategoria
        );
        return $array;
    }

    public static function stdClassToDTO(stdClass $obj) {
        try {
            $categoria = new CategoriaDTO();
            $categoria->setIdCategoria($obj->ID_CATEGORIA);
            $categoria->setNombre($obj->NOMBRE);
            $categoria->setActiva($obj->ACTIVA);
            $categoria->setDescripcion($obj->DESCRIPCION);
            $categoria->setCategoriaIdCategoria($obj->CATEGORIA_ID_CATEGORIA); 
            return $categoria;
        } catch (ErrorException $exc) {
            echo $exc->getTraceAsString();
        }
        return null;
    }

}

?>