<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GenericMaquetador
 *
 * @author SOPORTE
 */
// Interfaces y Clases padres para la abstraccion de las funcionalidades de La maquetacion de las siguientes clases
// ProductoDAO
// CatalogoDAO
// CategoriaDAO
// CuentaDAO
// DomicilioCuenta

interface GenericMaquetador {
    public function maquetaObject(EntityDTO $entidad);

    public function maquetaArrayObject(array $entidades);
}
