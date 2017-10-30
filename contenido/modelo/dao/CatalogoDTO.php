<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CatalogoDTO
 *
 * @author Josué Francisco
 */
//include_once 'EntityDTO.php';

final class CatalogoDTO implements EntityDTO {

    private $idCatalogo;
    private $nombre;
    private $descripcion;
    private $activo = true;
    private $foto;

    function __construct() {
        
    }

    public function getIdCatalogo() {
        return $this->idCatalogo;
    }

    public function setIdCatalogo($idCatalogo) {
        $this->idCatalogo = (int) $idCatalogo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setNombre($nombre) {
        $this->nombre = (string) $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = (string) $descripcion;
    }

    public function setActivo($activo) {
        $this->activo = (boolean) $activo;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function jsonSerialize() {
        $json = array(
            "ID_CATALOGO" => $this->idCatalogo,
            "NOMBRE" => $this->nombre,
            "DESCRIPCION" => $this->descripcion,
            "ACTIVO" => $this->activo,
            "FOTO" => $this->foto
        );
    }

    public static function stdClassToDTO(stdClass $obj) {
        try {
            $catalogo = new CatalogoDTO();
            $catalogo->setIdCatalogo($obj->ID_CATALOGO);
            $catalogo->setNombre($obj->NOMBRE);
            $catalogo->setDescripcion($obj->DESCRIPCION);
            $catalogo->setActivo($obj->ACTIVO);
            $catalogo->setFoto($obj->FOTO);
            return $catalogo;
        } catch (ErrorException $ex) {
            echo($ex->getMessage());
        }
        return null;;
    }

}
