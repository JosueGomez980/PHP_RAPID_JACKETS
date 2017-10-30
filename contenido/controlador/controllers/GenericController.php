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
interface GenericController {

    public function insertar(EntityDTO $entidad);

    public function actualizar(EntityDTO $entidad);

    public function eliminar(EntityDTO $entidad);

    public function encontrar(EntityDTO $entidad);

    public function encontrarTodos();
}

