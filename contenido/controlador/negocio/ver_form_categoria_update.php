<?php

include_once 'cargar_clases2.php';
AutoCarga2::init();

$acceso = AccesoPagina::getInstacia();
$acceso instanceof AccesoPagina;
$acceso->comprobarSesionAdmin(AccesoPagina::INICIO);
$categoriaDAO = CategoriaDAO::getInstancia();
$categoriaDAO instanceof CategoriaDAO;

//Instancia de las clases para manejar los controladores hacia el modelo

$categoriaManager = new CategoriaController();
$categoriaUpdate = new CategoriaDTO();

if (isset($_POST[CategoriaRequest::id_cat])) {
    $categoriaUpdate->setIdCategoria(CriptManager::urlVarDecript($_POST[CategoriaRequest::id_cat]));
    $categoriaManager->mostrarCategoriaFormUpdate($categoriaUpdate);
}
