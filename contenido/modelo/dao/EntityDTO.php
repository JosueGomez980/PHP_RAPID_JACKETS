<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Josué Francisco
 */
interface EntityDTO extends JsonSerializable {

    public static function stdClassToDTO(stdClass $obj);
}

interface DAOPaginable {

    public function findByPaginationLimit($inicio, $cantidad);
}

interface GenericDAO {

    public static function getInstancia();

    public function resultToArray(mysqli_result $resultado);

    public function resultToObject(mysqli_result $resultado);

    public function insert(EntityDTO $entidad);

    public function update(EntityDTO $entidad);

    public function delete(EntityDTO $entidad);

    public function find(EntityDTO $entidad);

    public function findAll();
}

interface MultiCrudDAO extends GenericDAO {

    public function inserts(array $entidades);

    public function updates(array $entidades);

    public function deletes(array $entidades);
}
