<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'cargar_clases2.php';
AutoCarga2::init();

$userManager = new ProductoController();
$productoRequest = new ProductoRequest();
$productoPost = $productoRequest->getProductoDTO();
$userManager->listarByCategoria($productoPost);

